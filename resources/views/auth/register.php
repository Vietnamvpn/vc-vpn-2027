<?php
$authTitle = "Tạo Tài Khoản";
$authSubtitle = "Trải nghiệm dịch vụ VPN chất lượng cao";
ob_start();
?>

<form action="/register" method="POST" class="auth-form" id="registerForm">
    <!-- CSRF Protection Input Token -->
    <input type="hidden" name="csrf_token" id="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <?php if (isset($error)): ?>
        <div class="auth-alert alert-danger">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div class="auth-alert alert-success">
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div id="ajax-alert" class="auth-alert" style="display: none;"></div>

    <div class="form-group assemble-left">
        <label for="username">Tên đăng nhập</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">👤</span>
            <input type="text" id="username" name="username" class="form-control-custom" placeholder="Email hoặc Username" required autofocus autocomplete="username">
        </div>
    </div>

    <div class="form-group assemble-right">
        <label for="email">Địa chỉ Email</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">✉️</span>
            <input type="email" id="email" name="email" class="form-control-custom" placeholder="email@domain.com" required autocomplete="email">
        </div>
    </div>

    <!-- Khối Nhập Mã Xác Thực OTP Email -->
    <div class="form-group assemble-left">
        <label for="otp_code">Mã xác thực OTP (Gửi qua Email)</label>
        <div class="input-group-custom input-group-otp">
            <span class="input-group-text-custom">🔑</span>
            <input type="text" id="otp_code" name="otp_code" class="form-control-custom input-otp-field" placeholder="6 chữ số" maxlength="6" required>
            <button type="button" id="btnSendOtp" class="btn-send-otp" data-action="/register/send-otp">Gửi mã</button>
        </div>
    </div>

    <div class="form-group assemble-left">
        <label for="password">Mật khẩu</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🔒</span>
            <input type="password" id="password" name="password" class="form-control-custom" placeholder="••••••••" required autocomplete="new-password">
            <button type="button" class="btn-toggle-pw toggle-password" data-target="password" title="Bật/Tắt hiển thị mật khẩu">👁️</button>
        </div>
    </div>

    <div class="form-group assemble-left">
        <label for="ref_code">Mã giới thiệu (Nếu có)</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🎁</span>
            <input type="text" id="ref_code" name="ref_code" class="form-control-custom" placeholder="Mã giới thiệu" value="<?= htmlspecialchars($_GET['ref'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
        </div>
    </div>

    <div class="assemble-bottom-1">
        <button type="submit" class="btn-login">ĐĂNG KÝ</button>
    </div>
</form>

<div class="auth-footer assemble-bottom-2">
    <span>Đã có tài khoản? <a href="/login">Đăng nhập</a></span>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>