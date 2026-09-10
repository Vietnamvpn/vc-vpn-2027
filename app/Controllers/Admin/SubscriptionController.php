<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Subscription;
use App\Models\User;
use App\Models\VpnPlan;
use App\Models\Server;
use App\Models\NodeTask;
use App\Models\Order;

class SubscriptionController extends BaseController
{
    private Subscription $subscriptionModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
        $this->subscriptionModel = new Subscription();
    }

    /**
     * Hàm phụ trợ: Tự động tạo task 'add_user' cho các VPS thuộc đúng Nhóm Máy Chủ (group_id)
     */
    private function dispatchAddUserTask(int $subId, string $uuid, int $bytesTotal, string $endDate, int $groupId): void
    {
        if (class_exists('App\Models\Server') && class_exists('App\Models\NodeTask')) {
            $serverModel = new Server();
            $servers     = $serverModel->getAll();

            if (empty($servers)) return;

            $taskModel = new NodeTask();
            $payload   = [
                'username'        => 'sub_' . $subId,
                'uuid'            => $uuid,
                'transfer_enable' => $bytesTotal,
                'end_date'        => $endDate
            ];

            foreach ($servers as $server) {
                if (($server['status'] ?? 'active') === 'active' && (int)($server['group_id'] ?? 0) === $groupId) {
                    $taskModel->create([
                        'server_id' => (int)$server['id'],
                        'action'    => 'add_user',
                        'payload'   => $payload
                    ]);
                }
            }
        }
    }

    /**
     * Hàm phụ trợ: Tự động tạo task 'delete_user' gửi xuống VPS thuộc đúng Nhóm Máy Chủ (group_id)
     */
    private function dispatchDelUserTask(int $subId, int $groupId): void
    {
        if (class_exists('App\Models\Server') && class_exists('App\Models\NodeTask')) {
            $serverModel = new Server();
            $servers     = $serverModel->getAll();

            if (empty($servers)) return;

            $taskModel = new NodeTask();
            $payload   = [
                'username' => 'sub_' . $subId
            ];

            foreach ($servers as $server) {
                if (($server['status'] ?? 'active') === 'active' && (int)($server['group_id'] ?? 0) === $groupId) {
                    $taskModel->create([
                        'server_id' => (int)$server['id'],
                        'action'    => 'delete_user',
                        'payload'   => $payload
                    ]);
                }
            }
        }
    }

    public function index(): void
    {
        $userId = isset($_GET['user_id']) ? (int)$_GET['user_id'] : null;
        $subscriptions = $this->subscriptionModel->allWithDetails($userId);

        $filterUser = null;
        if ($userId && class_exists('App\Models\User')) {
            $userModel  = new User();
            $filterUser = $userModel->findById($userId);
        }

        $this->render('admin.subscriptions.index', [
            'activeMenu'    => 'subscriptions',
            'subscriptions' => $subscriptions,
            'filterUser'    => $filterUser,
            'userId'        => $userId
        ]);
    }

    public function detail(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $subscription = $this->subscriptionModel->findWithDetails($id);

        if (!$subscription) {
            $_SESSION['error'] = 'Gói đăng ký không tồn tại!';
            $this->redirect('/admin/subscriptions');
            return;
        }

        $this->render('admin.subscriptions.detail', [
            'activeMenu'   => 'subscriptions',
            'subscription' => $subscription
        ]);
    }

    public function updateStatus(): void
    {
        $id     = (int)($_GET['id'] ?? 0);
        $status = $_GET['status'] ?? '';
        $userId = (int)($_GET['user_id'] ?? 0);

        $validStatuses = ['active', 'suspended', 'cancelled', 'expired'];

        if ($id <= 0 || !in_array($status, $validStatuses, true)) {
            $_SESSION['flash_message'] = 'Yêu cầu không hợp lệ!';
            $_SESSION['flash_type']    = 'danger';
            $this->redirect('/admin/subscriptions' . ($userId > 0 ? '?user_id=' . $userId : ''));
        }

        $sub = $this->subscriptionModel->find($id);
        if (!$sub) {
            $_SESSION['flash_message'] = 'Gói đăng ký không tồn tại!';
            $_SESSION['flash_type']    = 'danger';
            $this->redirect('/admin/subscriptions' . ($userId > 0 ? '?user_id=' . $userId : ''));
        }

        if ($this->subscriptionModel->update($id, ['status' => $status])) {
            $groupId = 0;
            if (class_exists('App\Models\VpnPlan') && !empty($sub['plan_id'])) {
                $planModel = new VpnPlan();
                $plan      = $planModel->find((int)$sub['plan_id']);
                $groupId   = (int)($plan['group_id'] ?? 0);
            }

            if ($groupId > 0) {
                if ($status === 'active') {
                    $this->dispatchAddUserTask($id, $sub['uuid'], (int)$sub['transfer_enable'], $sub['end_date'], $groupId);
                } else {
                    $this->dispatchDelUserTask($id, $groupId);
                }
            }

            $_SESSION['flash_message'] = 'Cập nhật trạng thái gói đăng ký thành công!';
            $_SESSION['flash_type']    = 'success';
        } else {
            $_SESSION['flash_message'] = 'Không thể cập nhật trạng thái gói!';
            $_SESSION['flash_type']    = 'danger';
        }

        $this->redirect('/admin/subscriptions' . ($userId > 0 ? '?user_id=' . $userId : ''));
    }

    public function renew(): void
    {
        $id     = (int)($_GET['id'] ?? 0);
        $userId = (int)($_GET['user_id'] ?? 0);

        $sub = $this->subscriptionModel->find($id);
        if (!$sub) {
            $_SESSION['flash_message'] = 'Gói đăng ký không tồn tại!';
            $_SESSION['flash_type']    = 'danger';
            $this->redirect('/admin/subscriptions' . ($userId > 0 ? '?user_id=' . $userId : ''));
        }

        $planModel = class_exists('App\Models\VpnPlan') ? new VpnPlan() : null;
        $plan      = $planModel ? $planModel->find((int)$sub['plan_id']) : null;

        if (!$plan) {
            $_SESSION['flash_message'] = 'Không tìm thấy thông tin gói cước tương ứng!';
            $_SESSION['flash_type']    = 'danger';
            $this->redirect('/admin/subscriptions' . ($userId > 0 ? '?user_id=' . $userId : ''));
        }

        // 1. Khởi tạo đơn hàng mới cho giao dịch gia hạn
        $orderModel  = new Order();
        $orderCode   = 'ORD' . date('YmdHis') . rand(100, 999);
        $totalAmount = (float)($plan['price'] ?? 0);

        $orderCreated = $orderModel->create([
            'order_code'     => $orderCode,
            'user_id'        => (int)$sub['user_id'],
            'plan_id'        => (int)$sub['plan_id'],
            'total_amount'   => $totalAmount,
            'payment_status' => 'completed',
            'purchase_ip'    => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1'
        ]);

        if ($orderCreated) {
            $newOrderId   = method_exists($orderModel, 'lastInsertId') ? $orderModel->lastInsertId() : null;
            $durationDays = (int)($plan['duration_days'] ?? 30);
            $groupId      = (int)($plan['group_id'] ?? 0);

            $currentEndDate = strtotime($sub['end_date']);
            $baseTime       = ($currentEndDate > time()) ? $currentEndDate : time();
            $newEndDate     = date('Y-m-d H:i:s', strtotime("+{$durationDays} days", $baseTime));

            $updateData = [
                'end_date' => $newEndDate,
                'status'   => 'active'
            ];

            if ($newOrderId) {
                $updateData['order_id'] = $newOrderId;
            }

            // 2. Cập nhật thời hạn và liên kết đơn hàng mới vào gói đăng ký
            if ($this->subscriptionModel->update($id, $updateData)) {
                if ($groupId > 0) {
                    $this->dispatchAddUserTask($id, $sub['uuid'], (int)$sub['transfer_enable'], $newEndDate, $groupId);
                }

                $_SESSION['flash_message'] = 'Gia hạn gói đăng ký và tạo đơn hàng mới thành công!';
                $_SESSION['flash_type']    = 'success';
            } else {
                $_SESSION['flash_message'] = 'Tạo đơn hàng thành công nhưng không thể cập nhật gia hạn!';
                $_SESSION['flash_type']    = 'warning';
            }
        } else {
            $_SESSION['flash_message'] = 'Không thể khởi tạo đơn hàng mới cho lần gia hạn này!';
            $_SESSION['flash_type']    = 'danger';
        }

        $this->redirect('/admin/subscriptions' . ($userId > 0 ? '?user_id=' . $userId : ''));
    }

    public function resetTraffic(): void
    {
        $id     = (int)($_GET['id'] ?? 0);
        $userId = (int)($_GET['user_id'] ?? 0);

        $sub = $this->subscriptionModel->find($id);
        if (!$sub) {
            $_SESSION['flash_message'] = 'Gói đăng ký không tồn tại!';
            $_SESSION['flash_type']    = 'danger';
            $this->redirect('/admin/subscriptions' . ($userId > 0 ? '?user_id=' . $userId : ''));
        }

        if ($this->subscriptionModel->update($id, ['upload' => 0, 'download' => 0])) {
            $_SESSION['flash_message'] = 'Reset lưu lượng gói đăng ký về 0 GB thành công!';
            $_SESSION['flash_type']    = 'success';
        } else {
            $_SESSION['flash_message'] = 'Không thể reset lưu lượng!';
            $_SESSION['flash_type']    = 'danger';
        }

        $this->redirect('/admin/subscriptions' . ($userId > 0 ? '?user_id=' . $userId : ''));
    }

    public function delete(): void
    {
        $id     = (int)($_GET['id'] ?? 0);
        $userId = (int)($_GET['user_id'] ?? 0);

        $sub = $this->subscriptionModel->find($id);
        if (!$sub) {
            $_SESSION['flash_message'] = 'Gói đăng ký không tồn tại!';
            $_SESSION['flash_type']    = 'danger';
        } else {
            if (class_exists('App\Models\VpnPlan') && !empty($sub['plan_id'])) {
                $planModel = new VpnPlan();
                $plan      = $planModel->find((int)$sub['plan_id']);
                $groupId   = (int)($plan['group_id'] ?? 0);

                if ($groupId > 0) {
                    $this->dispatchDelUserTask($id, $groupId);
                }
            }

            if ($this->subscriptionModel->delete($id)) {
                $_SESSION['flash_message'] = 'Xóa gói đăng ký thành công!';
                $_SESSION['flash_type']    = 'success';
            } else {
                $_SESSION['flash_message'] = 'Không thể xóa gói đăng ký!';
                $_SESSION['flash_type']    = 'danger';
            }
        }

        $this->redirect('/admin/subscriptions' . ($userId > 0 ? '?user_id=' . $userId : ''));
    }
}