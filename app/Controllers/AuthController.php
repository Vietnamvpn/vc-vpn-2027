<?php

namespace App\Controllers;

use App\Models\User;

class AuthController extends BaseController
{
    public function showLogin(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/user/dashboard');
        }

        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        $this->render('auth.login', [
            'error' => $error
        ]);
    }

    public function login(): void
    {
        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.';
            $this->redirect('/auth/login');
        }

        if (class_exists('App\Models\User')) {
            $userModel = new User();
            $user = $userModel->findByUsernameOrEmail($username);

            if ($user && password_verify($password, $user['password'])) {
                if (($user['status'] ?? 'active') !== 'active') {
                    $_SESSION['error'] = 'Tài khoản của bạn đã bị khóa hoặc chưa kích hoạt.';
                    $this->redirect('/auth/login');
                }

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'] ?? 'user';

                if ($_SESSION['role'] === 'admin') {
                    $this->redirect('/admin/dashboard');
                } else {
                    $this->redirect('/user/dashboard');
                }
            }
        }

        $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
        $this->redirect('/auth/login');
    }

    public function showRegister(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/user/dashboard');
        }

        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        $this->render('auth.register', [
            'error' => $error
        ]);
    }

    public function register(): void
    {
        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $passwordConfirm = trim($_POST['password_confirm'] ?? '');
        $refCode = trim($_POST['ref_code'] ?? '');

        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin.';
            $this->redirect('/auth/register');
        }

        if ($password !== $passwordConfirm) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không trùng khớp.';
            $this->redirect('/auth/register');
        }

        if (class_exists('App\Models\User')) {
            $userModel = new User();

            if ($userModel->findByUsernameOrEmail($username)) {
                $_SESSION['error'] = 'Tên đăng nhập đã được sử dụng.';
                $this->redirect('/auth/register');
            }

            if ($userModel->findByUsernameOrEmail($email)) {
                $_SESSION['error'] = 'Email đã được sử dụng.';
                $this->redirect('/auth/register');
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $created = $userModel->create([
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword,
                'ref_code' => $refCode
            ]);

            if ($created) {
                $_SESSION['success'] = 'Đăng ký tài khoản thành công. Vui lòng đăng nhập.';
                $this->redirect('/auth/login');
            }
        }

        $_SESSION['error'] = 'Đã có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại sau.';
        $this->redirect('/auth/register');
    }

    public function showForgotPassword(): void
    {
        $error = $_SESSION['error'] ?? null;
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['error'], $_SESSION['success']);

        $this->render('auth.forgot-password', [
            'error' => $error,
            'success' => $success
        ]);
    }

    public function sendResetLink(): void
    {
        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            $_SESSION['error'] = 'Vui lòng nhập địa chỉ email.';
            $this->redirect('/auth/forgot-password');
        }

        $_SESSION['success'] = 'Nếu email tồn tại trong hệ thống, chúng tôi đã gửi liên kết khôi phục mật khẩu.';
        $this->redirect('/auth/forgot-password');
    }

    public function showResetPassword(): void
    {
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        $this->render('auth.reset-password', [
            'error' => $error
        ]);
    }

    public function resetPassword(): void
    {
        $token = trim($_POST['token'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $passwordConfirm = trim($_POST['password_confirm'] ?? '');

        if (empty($password) || $password !== $passwordConfirm) {
            $_SESSION['error'] = 'Mật khẩu không hợp lệ hoặc xác nhận không khớp.';
            $this->redirect('/auth/reset-password?token=' . urlencode($token));
        }

        $_SESSION['success'] = 'Mật khẩu đã được cập nhật thành công. Vui lòng đăng nhập.';
        $this->redirect('/auth/login');
    }

    public function logout(): void
    {
        unset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['role']);
        session_destroy();
        header('Location: /auth/login');
        exit;
    }
}