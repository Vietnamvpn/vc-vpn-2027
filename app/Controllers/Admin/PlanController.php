<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\VpnPlan;
use App\Models\ServerGroup;
use App\Models\Subscription;

class PlanController extends BaseController
{
    private VpnPlan $planModel;
    private ServerGroup $serverGroupModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/login');
        }
        $this->planModel = new VpnPlan();
        $this->serverGroupModel = new ServerGroup();
    }

    public function index(): void
    {
        $plans = method_exists($this->planModel, 'getAllWithGroup') 
            ? $this->planModel->getAllWithGroup() 
            : $this->planModel->getAll();

        $this->render('admin.plans.index', [
            'activeMenu' => 'plans',
            'plans'      => $plans
        ]);
    }

    public function showCreate(): void
    {
        $groups = $this->serverGroupModel->getAll();
        $this->render('admin.plans.create', [
            'activeMenu' => 'plans',
            'groups'     => $groups
        ]);
    }

    public function create(): void
    {
        $groupId          = (int)($_POST['group_id'] ?? 0);
        $name             = trim($_POST['name'] ?? '');
        $code             = trim($_POST['code'] ?? '');
        $price            = (float)($_POST['price'] ?? 0);
        $durationDays     = (int)($_POST['duration_days'] ?? 0);
        $bandwidthLimitGb = (int)($_POST['bandwidth_limit_gb'] ?? 0);
        $maxDevices       = (int)($_POST['max_devices'] ?? 1);
        $description      = trim($_POST['description'] ?? '');
        $status           = trim($_POST['status'] ?? 'active');

        // Nếu mã gói để trống, tự động sinh mã ngẫu nhiên dạng LS + 6 chữ số
        if (empty($code)) {
            $code = 'LS' . rand(100000, 999999);
        }

        if (!$groupId || empty($name) || $price < 0 || $durationDays <= 0) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ các thông tin bắt buộc!';
            $this->redirect('/admin/plans/create');
            return;
        }

        $this->planModel->create([
            'group_id'           => $groupId,
            'name'               => $name,
            'code'               => strtoupper($code),
            'price'              => $price,
            'duration_days'      => $durationDays,
            'bandwidth_limit_gb' => $bandwidthLimitGb,
            'max_devices'        => $maxDevices,
            'description'        => $description,
            'status'             => $status
        ]);

        $_SESSION['flash_message'] = 'Tạo gói cước mới thành công!';
        $this->redirect('/admin/plans');
    }

    public function showEdit(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $plan = $id ? $this->planModel->find($id) : null;

        if (!$plan) {
            $_SESSION['error'] = 'Gói cước không tồn tại!';
            $this->redirect('/admin/plans');
            return;
        }

        $groups = $this->serverGroupModel->getAll();
        $this->render('admin.plans.edit', [
            'activeMenu' => 'plans',
            'plan'       => $plan,
            'groups'     => $groups
        ]);
    }

    public function edit(): void
    {
        $id               = isset($_GET['id']) ? (int)$_GET['id'] : null;
        $groupId          = (int)($_POST['group_id'] ?? 0);
        $name             = trim($_POST['name'] ?? '');
        $code             = trim($_POST['code'] ?? '');
        $price            = (float)($_POST['price'] ?? 0);
        $durationDays     = (int)($_POST['duration_days'] ?? 0);
        $bandwidthLimitGb = (int)($_POST['bandwidth_limit_gb'] ?? 0);
        $maxDevices       = (int)($_POST['max_devices'] ?? 1);
        $description      = trim($_POST['description'] ?? '');
        $status           = trim($_POST['status'] ?? 'active');

        if (!$id || !$groupId || empty($name) || empty($code) || $price < 0 || $durationDays <= 0) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ các thông tin bắt buộc!';
            $this->redirect('/admin/plans/edit?id=' . $id);
            return;
        }

        $this->planModel->update($id, [
            'group_id'           => $groupId,
            'name'               => $name,
            'code'               => strtoupper($code),
            'price'              => $price,
            'duration_days'      => $durationDays,
            'bandwidth_limit_gb' => $bandwidthLimitGb,
            'max_devices'        => $maxDevices,
            'description'        => $description,
            'status'             => $status
        ]);

        $_SESSION['flash_message'] = 'Cập nhật gói cước thành công!';
        $this->redirect('/admin/plans');
    }

    public function delete(): void
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : null;

        if ($id) {
            $subModel = new Subscription();
            $count = $subModel->countByPlanId($id);

            if ($count > 0) {
                $_SESSION['error'] = "Không thể xóa gói cước này vì đang có {$count} tài khoản đăng ký sử dụng! Bạn nên đổi trạng thái gói sang Inactive (Tắt).";
            } else {
                $this->planModel->delete($id);
                $_SESSION['flash_message'] = 'Đã xóa gói cước thành công!';
            }
        }

        $this->redirect('/admin/plans');
    }
}