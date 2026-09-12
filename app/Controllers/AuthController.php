<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Setting;

class AuthController extends BaseController
{
    public function showLogin(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }

        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        $siteTitle = "VC VPN 2027";
        $siteSubtitle = "An Toàn - Bảo Mật - Uy Tín";

        if (class_exists('App\Models\Setting')) {
            $settingModel = new Setting();
            $siteTitle = $settingModel->get('site_name', $siteTitle) ?? $siteTitle;
            $siteSubtitle = $settingModel->get('site_subtitle', $siteSubtitle) ?? $siteSubtitle;
        }

        $this->render('auth.login', [
            'error'        => $error,
            'siteTitle'    => $siteTitle,
            'siteSubtitle' => $siteSubtitle
        ]);
    }

    public function login(): void
    {
        // 1. Chống CSRF Attack
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Yêu cầu không hợp lệ hoặc phiên làm việc đã hết hạn. Vui lòng thử lại.';
            $this->redirect('/login');
        }

        // 2. Chống Brute Force (Giới hạn 5 lần thử trong 15 phút)
        $now = time();
        $_SESSION['login_throttle'] = $_SESSION['login_throttle'] ?? [];
        $_SESSION['login_throttle'] = array_filter(
            $_SESSION['login_throttle'], 
            fn($timestamp) => ($now - $timestamp) < 900
        );

        if (count($_SESSION['login_throttle']) >= 5) {
            $_SESSION['error'] = 'Bạn đã nhập sai quá 5 lần. Vui lòng thử lại sau 15 phút.';
            $this->redirect('/login');
        }

        $username = trim($_POST['username'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (empty($username) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng nhập đầy đủ tên đăng nhập và mật khẩu.';
            $this->redirect('/login');
        }

        if (class_exists('App\Models\User')) {
            $userModel = new User();
            
            // Tìm kiếm người dùng sử dụng so sánh BINARY trong MySQL
            $user = $userModel->findByUsernameOrEmailStrict($username);

            // Kiểm tra phân biệt tuyệt đối chữ hoa/chữ thường trong PHP (Tránh Timing Attack)
            $dummyHash = '$2y$10$abcdefghijklmnopqrstuuNOPQRSTUVWXYZ0123456789abcdefgh';
            $isExactMatch = $user && (
                hash_equals($user['username'], $username) || 
                hash_equals($user['email'], $username)
            );

            if ($isExactMatch) {
                $passwordValid = password_verify($password, $user['password_hash']);
            } else {
                // Chạy hàm mã hóa giả định để thời gian xử lý giữ nguyên 100% (Chống Timing Attack)
                password_verify($password, $dummyHash);
                $passwordValid = false;
            }

            if ($isExactMatch && $passwordValid) {
                if (($user['status'] ?? 'active') !== 'active') {
                    $_SESSION['error'] = 'Tài khoản của bạn đã bị khóa hoặc chưa kích hoạt.';
                    $this->redirect('/login');
                }

                // 3. Chống Session Fixation (Cấp lại ID phiên khi đăng nhập)
                session_regenerate_id(true);
                unset($_SESSION['login_throttle']);

                $clientIp = $this->getClientIp();
                $userModel->update($user['id'], [
                    'last_login_ip' => $clientIp,
                    'last_login_time' => date('Y-m-d H:i:s')
                ]);

                $_SESSION['user_id'] = $user['id'];
                $_SESSION['username'] = $user['username'];
                $_SESSION['role'] = $user['role'] ?? 'user';

                if ($_SESSION['role'] === 'admin') {
                    $this->redirect('/admin');
                } else {
                    $this->redirect('/dashboard');
                }
            }
        }

        // Đánh dấu 1 lần thử sai
        $_SESSION['login_throttle'][] = $now;

        $_SESSION['error'] = 'Tên đăng nhập hoặc mật khẩu không chính xác.';
        $this->redirect('/login');
    }

    public function showRegister(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }

        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        $this->render('auth.register', [
            'error' => $error
        ]);
    }

    public function register(): void
    {
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Phiên làm việc không hợp lệ. Vui lòng thử lại.';
            $this->redirect('/register');
        }

        $username = trim($_POST['username'] ?? '');
        $email = trim($_POST['email'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $passwordConfirm = trim($_POST['password_confirm'] ?? '');
        $refCodeInput = trim($_POST['ref_code'] ?? '');

        if (empty($username) || empty($email) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ thông tin.';
            $this->redirect('/register');
        }

        if ($password !== $passwordConfirm) {
            $_SESSION['error'] = 'Mật khẩu xác nhận không trùng khớp.';
            $this->redirect('/register');
        }

        if (class_exists('App\Models\User')) {
            $userModel = new User();

            if ($userModel->findByUsernameOrEmailStrict($username)) {
                $_SESSION['error'] = 'Tên đăng nhập đã được sử dụng.';
                $this->redirect('/register');
            }

            if ($userModel->findByUsernameOrEmailStrict($email)) {
                $_SESSION['error'] = 'Email đã được sử dụng.';
                $this->redirect('/register');
            }

            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
            $clientIp = $this->getClientIp();
            $myRefCode = strtoupper(substr(md5(uniqid($username, true)), 0, 8));

            $referredBy = null;
            if (!empty($refCodeInput)) {
                $referrer = $userModel->findByRefCode($refCodeInput);
                if ($referrer) {
                    $referredBy = $referrer['id'];
                }
            }

            $created = $userModel->create([
                'username'      => $username,
                'email'         => $email,
                'password_hash' => $hashedPassword,
                'ref_code'      => $myRefCode,
                'referred_by'   => $referredBy,
                'register_ip'   => $clientIp
            ]);

            if ($created) {
                $_SESSION['success'] = 'Đăng ký tài khoản thành công. Vui lòng đăng nhập.';
                $this->redirect('/login');
            }
        }

        $_SESSION['error'] = 'Đã có lỗi xảy ra trong quá trình đăng ký. Vui lòng thử lại sau.';
        $this->redirect('/register');
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
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Phiên làm việc không hợp lệ.';
            $this->redirect('/forgot-password');
        }

        $email = trim($_POST['email'] ?? '');

        if (empty($email)) {
            $_SESSION['error'] = 'Vui lòng nhập địa chỉ email.';
            $this->redirect('/forgot-password');
        }

        $_SESSION['success'] = 'Nếu email tồn tại trong hệ thống, chúng tôi đã gửi liên kết khôi phục mật khẩu.';
        $this->redirect('/forgot-password');
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
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Phiên làm việc không hợp lệ.';
            $this->redirect('/login');
        }

        $token = trim($_POST['token'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $passwordConfirm = trim($_POST['password_confirm'] ?? '');

        if (empty($password) || $password !== $passwordConfirm) {
            $_SESSION['error'] = 'Mật khẩu không hợp lệ hoặc xác nhận không khớp.';
            $this->redirect('/reset-password?token=' . urlencode($token));
        }

        $_SESSION['success'] = 'Mật khẩu đã được cập nhật thành công. Vui lòng đăng nhập.';
        $this->redirect('/login');
    }

    public function logout(): void
    {
        unset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['role']);
        session_destroy();
        $this->redirect('/');
    }
}