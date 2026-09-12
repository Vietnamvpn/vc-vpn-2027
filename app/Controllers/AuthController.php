<?php

namespace App\Controllers;

use App\Models\User;
use App\Models\Setting;
use App\Services\MailService;

class AuthController extends BaseController
{
    /**
     * Lấy Tên trang web từ CSDL (vc_settings) cho góc trên màn hình
     */
    private function getSiteTitle(): string
    {
        $siteTitle = "VC VPN 2027";
        if (class_exists('App\Models\Setting')) {
            $settingModel = new Setting();
            $siteTitle = $settingModel->get('site_title', $siteTitle) ?? $siteTitle;
        }
        return $siteTitle;
    }

    public function showLogin(): void
    {
        if (isset($_SESSION['user_id'])) {
            $this->redirect('/dashboard');
        }

        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);

        $siteSubtitle = "An Toàn - Bảo Mật - Uy Tín";
        if (class_exists('App\Models\Setting')) {
            $settingModel = new Setting();
            $siteSubtitle = $settingModel->get('site_description', $siteSubtitle) ?? $siteSubtitle;
        }

        $this->render('auth.login', [
            'error'        => $error,
            'siteTitle'    => $this->getSiteTitle(),
            'siteSubtitle' => $siteSubtitle
        ]);
    }

    public function login(): void
    {
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Yêu cầu không hợp lệ hoặc phiên làm việc đã hết hạn. Vui lòng thử lại.';
            $this->redirect('/login');
        }

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
            
            $user = $userModel->findByUsernameOrEmailStrict($username);

            $dummyHash = '$2y$10$abcdefghijklmnopqrstuuNOPQRSTUVWXYZ0123456789abcdefgh';
            $isExactMatch = $user && (
                hash_equals($user['username'], $username) || 
                hash_equals($user['email'], $username)
            );

            if ($isExactMatch) {
                $passwordValid = password_verify($password, $user['password_hash']);
            } else {
                password_verify($password, $dummyHash);
                $passwordValid = false;
            }

            if ($isExactMatch && $passwordValid) {
                if (($user['status'] ?? 'active') !== 'active') {
                    $_SESSION['error'] = 'Tài khoản của bạn đã bị khóa hoặc chưa kích hoạt.';
                    $this->redirect('/login');
                }

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
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['error'], $_SESSION['success']);

        $this->render('auth.register', [
            'error'     => $error,
            'success'   => $success,
            'siteTitle' => $this->getSiteTitle()
        ]);
    }

    public function sendRegisterOtp(): void
    {
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->json(['success' => false, 'message' => 'Phiên làm việc không hợp lệ. Vui lòng tải lại trang.'], 403);
        }

        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $this->json(['success' => false, 'message' => 'Địa chỉ Email không hợp lệ.'], 400);
        }

        $now = time();
        if (isset($_SESSION['register_otp_cooldown']) && ($now - $_SESSION['register_otp_cooldown']) < 60) {
            $this->json(['success' => false, 'message' => 'Vui lòng chờ ' . (60 - ($now - $_SESSION['register_otp_cooldown'])) . ' giây trước khi yêu cầu mã mới.'], 429);
        }

        if (class_exists('App\Models\User')) {
            $userModel = new User();
            if ($userModel->findByUsernameOrEmailStrict($email)) {
                $this->json(['success' => false, 'message' => 'Địa chỉ Email này đã được đăng ký tài khoản.'], 400);
            }
        }

        $otpCode = (string)random_int(100000, 999999);
        $_SESSION['register_otp'] = [
            'email'      => $email,
            'code'       => $otpCode,
            'expires_at' => $now + 300
        ];
        $_SESSION['register_otp_cooldown'] = $now;

        $mailService = new MailService();
        $sent = $mailService->send($email, 'Mã xác thực đăng ký tài khoản', 'auth.register-otp', [
            'code' => $otpCode
        ]);

        if ($sent) {
            $this->json(['success' => true, 'message' => 'Mã xác thực OTP đã được gửi đến email của bạn.']);
        } else {
            $this->json(['success' => false, 'message' => 'Không thể gửi email OTP. Vui lòng kiểm tra lại địa chỉ email hoặc cấu hình SMTP.'], 500);
        }
    }

    public function register(): void
    {
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Phiên làm việc không hợp lệ. Vui lòng thử lại.';
            $this->redirect('/register');
        }

        $username = trim($_POST['username'] ?? '');
        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $otpCode = trim($_POST['otp_code'] ?? '');
        $password = trim($_POST['password'] ?? '');
        $refCodeInput = trim($_POST['ref_code'] ?? '');

        if (empty($username) || !$email || empty($otpCode) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ các thông tin bắt buộc.';
            $this->redirect('/register');
        }

        $sessionOtp = $_SESSION['register_otp'] ?? null;
        if (!$sessionOtp || 
            !hash_equals($sessionOtp['email'], $email) || 
            !hash_equals($sessionOtp['code'], $otpCode) || 
            time() > ($sessionOtp['expires_at'] ?? 0)) {
            $_SESSION['error'] = 'Mã xác thực OTP không chính xác hoặc đã hết hạn.';
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
                unset($_SESSION['register_otp'], $_SESSION['register_otp_cooldown']);
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
            'error'     => $error,
            'success'   => $success,
            'siteTitle' => $this->getSiteTitle()
        ]);
    }

    /**
     * API gửi mã OTP khôi phục mật khẩu qua Email
     */
    public function sendForgotPasswordOtp(): void
    {
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $this->json(['success' => false, 'message' => 'Phiên làm việc không hợp lệ. Vui lòng tải lại trang.'], 403);
        }

        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        if (!$email) {
            $this->json(['success' => false, 'message' => 'Địa chỉ Email không hợp lệ.'], 400);
        }

        $now = time();
        if (isset($_SESSION['forgot_otp_cooldown']) && ($now - $_SESSION['forgot_otp_cooldown']) < 60) {
            $this->json(['success' => false, 'message' => 'Vui lòng chờ ' . (60 - ($now - $_SESSION['forgot_otp_cooldown'])) . ' giây trước khi yêu cầu mã mới.'], 429);
        }

        if (class_exists('App\Models\User')) {
            $userModel = new User();
            $user = $userModel->findByUsernameOrEmailStrict($email);

            if (!$user) {
                $this->json(['success' => false, 'message' => 'Địa chỉ Email này chưa được đăng ký trong hệ thống.'], 404);
            }

            $otpCode = (string)random_int(100000, 999999);
            $_SESSION['forgot_otp'] = [
                'email'      => $user['email'],
                'code'       => $otpCode,
                'expires_at' => $now + 300
            ];
            $_SESSION['forgot_otp_cooldown'] = $now;

            $mailService = new MailService();
            $sent = $mailService->send($user['email'], 'Mã xác thực khôi phục mật khẩu', 'auth.forgot-password-otp', [
                'code' => $otpCode
            ]);

            if ($sent) {
                $this->json(['success' => true, 'message' => 'Mã xác thực OTP đã được gửi đến email của bạn.']);
            } else {
                $this->json(['success' => false, 'message' => 'Không thể gửi email OTP. Vui lòng kiểm tra lại cấu hình SMTP.'], 500);
            }
        } else {
            $this->json(['success' => false, 'message' => 'Đã có lỗi xảy ra.'], 500);
        }
    }

    /**
     * Xử lý Đặt lại mật khẩu trực tiếp tại /forgot-password
     */
    public function forgotPassword(): void
    {
        if (!$this->validateCsrfToken($_POST['csrf_token'] ?? '')) {
            $_SESSION['error'] = 'Phiên làm việc không hợp lệ.';
            $this->redirect('/forgot-password');
        }

        $email = filter_var(trim($_POST['email'] ?? ''), FILTER_VALIDATE_EMAIL);
        $otpCode = trim($_POST['otp_code'] ?? '');
        $password = trim($_POST['password'] ?? '');

        if (!$email || empty($otpCode) || empty($password)) {
            $_SESSION['error'] = 'Vui lòng điền đầy đủ các thông tin bắt buộc.';
            $this->redirect('/forgot-password');
        }

        $sessionOtp = $_SESSION['forgot_otp'] ?? null;
        if (!$sessionOtp || 
            !hash_equals($sessionOtp['email'], $email) || 
            !hash_equals($sessionOtp['code'], $otpCode) || 
            time() > ($sessionOtp['expires_at'] ?? 0)) {
            $_SESSION['error'] = 'Mã xác thực OTP không chính xác hoặc đã hết hạn.';
            $this->redirect('/forgot-password');
        }

        if (class_exists('App\Models\User')) {
            $userModel = new User();
            $user = $userModel->findByUsernameOrEmailStrict($email);

            if ($user) {
                $hashedPassword = password_hash($password, PASSWORD_BCRYPT);
                $userModel->update($user['id'], [
                    'password_hash' => $hashedPassword
                ]);
                unset($_SESSION['forgot_otp'], $_SESSION['forgot_otp_cooldown']);

                $_SESSION['success'] = 'Mật khẩu đã được cập nhật thành công. Vui lòng đăng nhập.';
                $this->redirect('/login');
            }
        }

        $_SESSION['error'] = 'Không thể cập nhật mật khẩu. Vui lòng thử lại.';
        $this->redirect('/forgot-password');
    }

    public function logout(): void
    {
        unset($_SESSION['user_id'], $_SESSION['username'], $_SESSION['role']);
        session_destroy();
        $this->redirect('/');
    }
}