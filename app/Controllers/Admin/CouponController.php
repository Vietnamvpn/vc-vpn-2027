<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\Coupon;

class CouponController extends BaseController
{
    private Coupon $couponModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
        $this->couponModel = new Coupon();
    }

    public function index(): void
    {
        $coupons = $this->couponModel->all();

        $this->render('admin.coupons.index', [
            'activeMenu' => 'coupons',
            'coupons'    => $coupons
        ]);
    }

    // GET /admin/coupons/create
    public function showCreate(): void
    {
        $this->render('admin.coupons.create', [
            'activeMenu' => 'coupons'
        ]);
    }

    // POST /admin/coupons/create
    public function create(): void
    {
        $code          = strtoupper(trim($_POST['code'] ?? ''));
        $discountType  = $_POST['discount_type'] ?? 'percent';
        $discountValue = (float)($_POST['discount_value'] ?? 0);
        $minOrderValue = (float)($_POST['min_order_value'] ?? 0);
        $usageLimit    = (int)($_POST['usage_limit'] ?? 0);
        $expiredAt     = !empty($_POST['expired_at']) ? $_POST['expired_at'] : null;
        $status        = $_POST['status'] ?? 'active';

        if (empty($code) || $discountValue <= 0) {
            $_SESSION['error'] = 'Vui lòng nhập mã giảm giá và giá trị giảm hợp lệ!';
            $this->redirect('/admin/coupons/create');
            return;
        }

        $data = [
            'code'            => $code,
            'discount_type'   => $discountType,
            'discount_value'  => $discountValue,
            'min_order_value' => $minOrderValue,
            'usage_limit'     => $usageLimit,
            'expired_at'      => $expiredAt,
            'status'          => $status,
            'created_at'      => date('Y-m-d H:i:s')
        ];

        if ($this->couponModel->create($data)) {
            $_SESSION['flash_message'] = 'Tạo mã giảm giá thành công!';
            $_SESSION['flash_type']    = 'success';
            $this->redirect('/admin/coupons');
        } else {
            $_SESSION['error'] = 'Lỗi hệ thống, không thể tạo mã giảm giá!';
            $this->redirect('/admin/coupons/create');
        }
    }

    // GET /admin/coupons/edit
    public function showEdit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $coupon = $this->couponModel->find($id);

        if (!$coupon) {
            $_SESSION['error'] = 'Mã giảm giá không tồn tại!';
            $this->redirect('/admin/coupons');
            return;
        }

        $this->render('admin.coupons.edit', [
            'activeMenu' => 'coupons',
            'coupon'     => $coupon
        ]);
    }

    // POST /admin/coupons/edit
    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $coupon = $this->couponModel->find($id);

        if (!$coupon) {
            $_SESSION['error'] = 'Mã giảm giá không tồn tại!';
            $this->redirect('/admin/coupons');
            return;
        }

        $code          = strtoupper(trim($_POST['code'] ?? ''));
        $discountType  = $_POST['discount_type'] ?? 'percent';
        $discountValue = (float)($_POST['discount_value'] ?? 0);
        $minOrderValue = (float)($_POST['min_order_value'] ?? 0);
        $usageLimit    = (int)($_POST['usage_limit'] ?? 0);
        $expiredAt     = !empty($_POST['expired_at']) ? $_POST['expired_at'] : null;
        $status        = $_POST['status'] ?? 'active';

        if (empty($code) || $discountValue <= 0) {
            $_SESSION['error'] = 'Vui lòng nhập mã giảm giá và giá trị giảm hợp lệ!';
            $this->redirect('/admin/coupons/edit?id=' . $id);
            return;
        }

        $data = [
            'code'            => $code,
            'discount_type'   => $discountType,
            'discount_value'  => $discountValue,
            'min_order_value' => $minOrderValue,
            'usage_limit'     => $usageLimit,
            'expired_at'      => $expiredAt,
            'status'          => $status
        ];

        if ($this->couponModel->update($id, $data)) {
            $_SESSION['flash_message'] = 'Cập nhật mã giảm giá thành công!';
            $_SESSION['flash_type']    = 'success';
            $this->redirect('/admin/coupons');
        } else {
            $_SESSION['error'] = 'Không thể cập nhật thông tin mã giảm giá!';
            $this->redirect('/admin/coupons/edit?id=' . $id);
        }
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);

        if ($id > 0) {
            if ($this->couponModel->delete($id)) {
                $_SESSION['flash_message'] = 'Đã xóa mã giảm giá thành công!';
                $_SESSION['flash_type']    = 'success';
            } else {
                $_SESSION['error'] = 'Không thể xóa mã giảm giá này!';
            }
        }

        $this->redirect('/admin/coupons');
    }
}