<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Order;
use App\Models\User;
use App\Models\VpnPlan;
use App\Models\Subscription;

class OrderController extends BaseController
{
    private Order $orderModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
        $this->orderModel = new Order();
    }

    public function index(): void
    {
        $orders = $this->orderModel->allWithDetails();

        $this->render('admin.orders.index', [
            'activeMenu' => 'orders',
            'orders'     => $orders
        ]);
    }

    public function create(): void
    {
        $userModel = new User();
        $planModel = class_exists('App\Models\VpnPlan') ? new VpnPlan() : null;

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $userId        = (int)($_POST['user_id'] ?? 0);
            $planId        = (int)($_POST['plan_id'] ?? 0);
            $paymentStatus = $_POST['payment_status'] ?? 'pending';
            $customAmount  = $_POST['amount'] !== '' ? (float)$_POST['amount'] : null;

            if ($userId <= 0 || $planId <= 0) {
                $_SESSION['flash_message'] = 'Vui lòng chọn Người dùng và Gói cước hợp lệ!';
                $_SESSION['flash_type']    = 'danger';
                $this->redirect('/admin/orders/create' . ($userId > 0 ? '?user_id=' . $userId : ''));
            }

            // Lấy thông tin gói cước
            $plan = $planModel ? $planModel->find($planId) : null;
            if (!$plan) {
                $_SESSION['flash_message'] = 'Gói cước không tồn tại!';
                $_SESSION['flash_type']    = 'danger';
                $this->redirect('/admin/orders/create?user_id=' . $userId);
            }

            $totalAmount = $customAmount !== null ? $customAmount : (float)$plan['price'];
            $orderCode   = 'ORD' . date('YmdHis') . rand(100, 999);

            // Tạo Đơn Hàng
            $orderData = [
                'order_code'     => $orderCode,
                'user_id'        => $userId,
                'plan_id'        => $planId,
                'total_amount'   => $totalAmount,
                'payment_status' => $paymentStatus,
                'purchase_ip'    => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
            ];

            if ($this->orderModel->create($orderData)) {
                $orderId = $this->orderModel->lastInsertId() ?? 0;

                // Nếu đơn hàng Hoàn tất (completed) -> Tự động kích hoạt Gói Đăng Ký (Subscription)
                if ($paymentStatus === 'completed' && class_exists('App\Models\Subscription')) {
                    $subModel       = new Subscription();
                    $durationDays   = (int)($plan['duration_days'] ?? 30);
                    $bandwidthLimit = (int)($plan['bandwidth_limit_gb'] ?? 0);
                    
                    $bytesTotal = $bandwidthLimit > 0 ? ($bandwidthLimit * 1073741824) : 0;
                    $uuid       = sprintf('%04x%04x-%04x-%04x-%04x-%04x%04x%04x', 
                                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), 
                                    mt_rand(0, 0xffff), 
                                    mt_rand(0, 0x0fff) | 0x4000, 
                                    mt_rand(0, 0x3fff) | 0x8000, 
                                    mt_rand(0, 0xffff), mt_rand(0, 0xffff), mt_rand(0, 0xffff));
                    $subToken   = bin2hex(random_bytes(16));

                    $startDate  = date('Y-m-d H:i:s');
                    $endDate    = date('Y-m-d H:i:s', strtotime("+{$durationDays} days"));

                    $subModel->create([
                        'user_id'         => $userId,
                        'plan_id'         => $planId,
                        'order_id'        => $orderId ?: null,
                        'uuid'            => $uuid,
                        'sub_token'       => $subToken,
                        'transfer_enable' => $bytesTotal,
                        'start_date'      => $startDate,
                        'end_date'        => $endDate,
                        'status'          => 'active'
                    ]);
                }

                $_SESSION['flash_message'] = 'Tạo đơn hàng thủ công thành công!';
                $_SESSION['flash_type']    = 'success';
                $this->redirect('/admin/orders');
            } else {
                $_SESSION['flash_message'] = 'Lỗi hệ thống, không thể tạo đơn hàng!';
                $_SESSION['flash_type']    = 'danger';
                $this->redirect('/admin/orders/create?user_id=' . $userId);
            }
        }

        // GET Request: Chuẩn bị dữ liệu hiển thị form
        $selectedUserId = (int)($_GET['user_id'] ?? 0);
        $users          = $userModel->getAll();
        $plans          = $planModel ? ($planModel->getAllActive() ?? $planModel->getAll()) : [];

        $this->render('admin.orders.create', [
            'activeMenu'     => 'orders',
            'users'          => $users,
            'plans'          => $plans,
            'selectedUserId' => $selectedUserId
        ]);
    }

    public function detail(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $order = $this->orderModel->findWithDetails($id);

        if (!$order) {
            $_SESSION['error'] = 'Đơn hàng không tồn tại!';
            $this->redirect('/admin/orders');
            return;
        }

        $this->render('admin.orders.detail', [
            'activeMenu' => 'orders',
            'order'      => $order
        ]);
    }
}