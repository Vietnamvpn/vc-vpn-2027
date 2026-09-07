<?php

namespace App\Controllers\Admin;

use App\Controllers\BaseController;
use App\Models\User;

class UserController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        if (!isset($_SESSION['user_id']) || ($_SESSION['role'] ?? '') !== 'admin') {
            $this->redirect('/auth/login');
        }
        $this->userModel = new User();
    }

    public function index(): void
    {
        $search = trim($_GET['search'] ?? '');
        $role = trim($_GET['role'] ?? '');
        $status = trim($_GET['status'] ?? '');

        $users = $this->userModel->getAll($search, $role, $status);

        $this->render('admin.users.index', [
            'users' => $users,
            'search' => $search,
            'role' => $role,
            'status' => $status,
            'activeMenu' => 'users'
        ]);
    }

    public function create(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $fullName = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $role = $_POST['role'] ?? 'user';
            $status = $_POST['status'] ?? 'active';
            $balance = (float)($_POST['balance'] ?? 0);

            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['flash_message'] = 'Vui lòng điền đầy đủ Tên đăng nhập, Email và Mật khẩu!';
                $_SESSION['flash_type'] = 'danger';
                $this->redirect('/admin/users/create');
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['flash_message'] = 'Định dạng Email không hợp lệ!';
                $_SESSION['flash_type'] = 'danger';
                $this->redirect('/admin/users/create');
            }

            if ($this->userModel->findByUsernameOrEmail($username) || $this->userModel->findByUsernameOrEmail($email)) {
                $_SESSION['flash_message'] = 'Tên đăng nhập hoặc Email đã tồn tại trên hệ thống!';
                $_SESSION['flash_type'] = 'danger';
                $this->redirect('/admin/users/create');
            }

            $refCode = strtoupper(substr(md5(uniqid($username, true)), 0, 8));
            $data = [
                'username' => $username,
                'email' => $email,
                'password_hash' => password_hash($password, PASSWORD_BCRYPT),
                'full_name' => $fullName,
                'phone' => $phone,
                'role' => $role,
                'status' => $status,
                'balance' => $balance,
                'commission_balance' => 0.00,
                'ref_code' => $refCode,
                'created_by' => $_SESSION['user_id'] // Ghi nhận ID Admin tạo người dùng này
            ];

            if ($this->userModel->create($data)) {
                $_SESSION['flash_message'] = 'Thêm thành viên mới thành công!';
                $_SESSION['flash_type'] = 'success';
                $this->redirect('/admin/users');
            } else {
                $_SESSION['flash_message'] = 'Lỗi hệ thống, không thể thêm thành viên!';
                $_SESSION['flash_type'] = 'danger';
                $this->redirect('/admin/users/create');
            }
        }

        $this->render('admin.users.create', ['activeMenu' => 'users']);
    }

    public function edit(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $user = $this->userModel->findById($id);

        if (!$user) {
            $_SESSION['flash_message'] = 'Không tìm thấy thành viên!';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/admin/users');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $fullName = trim($_POST['full_name'] ?? '');
            $phone = trim($_POST['phone'] ?? '');
            $role = $_POST['role'] ?? $user['role'];
            $status = $_POST['status'] ?? $user['status'];
            $balance = (float)($_POST['balance'] ?? $user['balance']);
            $commissionBalance = (float)($_POST['commission_balance'] ?? $user['commission_balance']);
            $newPassword = $_POST['new_password'] ?? '';

            // Bảo mật: Không cho phép tự hạ vai trò Admin của chính mình
            if ($id === (int)$_SESSION['user_id'] && $role !== 'admin') {
                $_SESSION['flash_message'] = 'Bảo mật: Bạn không thể tự hạ vai trò Admin của chính mình!';
                $_SESSION['flash_type'] = 'danger';
                $this->redirect('/admin/users/edit?id=' . $id);
            }

            $updateData = [
                'full_name' => $fullName,
                'phone' => $phone,
                'role' => $role,
                'status' => $status,
                'balance' => $balance,
                'commission_balance' => $commissionBalance
            ];

            if (!empty($newPassword)) {
                if (strlen($newPassword) < 6) {
                    $_SESSION['flash_message'] = 'Mật khẩu mới phải có tối thiểu 6 ký tự!';
                    $_SESSION['flash_type'] = 'danger';
                    $this->redirect('/admin/users/edit?id=' . $id);
                }
                $updateData['password_hash'] = password_hash($newPassword, PASSWORD_BCRYPT);
            }

            if ($this->userModel->update($id, $updateData)) {
                $_SESSION['flash_message'] = 'Cập nhật thông tin người dùng thành công!';
                $_SESSION['flash_type'] = 'success';
                $this->redirect('/admin/users');
            } else {
                $_SESSION['flash_message'] = 'Không thể cập nhật thông tin!';
                $_SESSION['flash_type'] = 'danger';
            }
        }

        $this->render('admin.users.edit', [
            'user' => $user,
            'activeMenu' => 'users'
        ]);
    }

    public function detail(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $user = $this->userModel->findById($id);

        if (!$user) {
            $_SESSION['flash_message'] = 'Không tìm thấy thành viên!';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/admin/users');
        }

        $this->render('admin.users.detail', [
            'user' => $user,
            'activeMenu' => 'users'
        ]);
    }

    public function delete(): void
    {
        $id = (int)($_GET['id'] ?? 0);
        $targetUser = $this->userModel->findById($id);

        if (!$targetUser) {
            $_SESSION['flash_message'] = 'Không tìm thấy tài khoản cần xóa!';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/admin/users');
        }

        // BẢO MẬT TUYỆT ĐỐI: Không cho phép xóa bất kỳ tài khoản nào có vai trò Admin
        if ($targetUser['role'] === 'admin') {
            $_SESSION['flash_message'] = 'Cảnh báo bảo mật: Tất cả tài khoản Quản trị viên (Admin) không thể xóa!';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/admin/users');
        }

        // BẢO MẬT BỔ SUNG: Không cho phép tự xóa chính tài khoản đang đăng nhập
        if ($id === (int)$_SESSION['user_id']) {
            $_SESSION['flash_message'] = 'Cảnh báo bảo mật: Bạn không thể tự xóa tài khoản của chính mình!';
            $_SESSION['flash_type'] = 'danger';
            $this->redirect('/admin/users');
        }

        if ($this->userModel->delete($id)) {
            $_SESSION['flash_message'] = 'Đã xóa người dùng thành công!';
            $_SESSION['flash_type'] = 'success';
        } else {
            $_SESSION['flash_message'] = 'Lỗi hệ thống, không thể xóa người dùng!';
            $_SESSION['flash_type'] = 'danger';
        }
        $this->redirect('/admin/users');
    }
}