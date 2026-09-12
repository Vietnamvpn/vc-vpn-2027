<?php
$authTitle = "Đặt Lại Mật Khẩu";
$authSubtitle = "Tạo mật khẩu mới cho tài khoản của bạn";
ob_start();
?>

<form action="/reset-password" method="POST" class="auth-form">
    <!-- CSRF Protection Input Token -->
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <?php if (isset($error)): ?>
        <div style="background: rgba(255, 59, 48, 0.12); color: #dc2626; padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.85rem; border: 1px solid rgba(220, 38, 38, 0.3); margin-bottom: 1.5rem; text-align: center;">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div style="background: rgba(52, 199, 89, 0.12); color: #16a34a; padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.85rem; border: 1px solid rgba(22, 163, 74, 0.3); margin-bottom: 1.5rem; text-align: center;">
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div class="form-group assemble-left">
        <label for="email">Địa chỉ Email</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">✉️</span>
            <input type="email" id="email" name="email" class="form-control-custom" placeholder="email@domain.com" value="<?= htmlspecialchars($email ?? $_GET['email'] ?? '', ENT_QUOTES, 'UTF-8') ?>" required autofocus autocomplete="email">
        </div>
    </div>

    <div class="form-group assemble-right">
        <label for="otp_code">Mã xác thực OTP (6 chữ số)</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🔑</span>
            <input type="text" id="otp_code" name="otp_code" class="form-control-custom" placeholder="Nhập 6 chữ số OTP" maxlength="6" required>
        </div>
    </div>

    <div class="form-group assemble-left">
        <label for="password">Mật khẩu mới</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🔒</span>
            <input type="password" id="password" name="password" class="form-control-custom" placeholder="••••••••" required autocomplete="new-password">
            <button type="button" class="btn-toggle-pw toggle-password" data-target="password" onclick="togglePasswordVisibility(this)" title="Bật/Tắt hiển thị mật khẩu">👁️</button>
        </div>
    </div>

    <div class="form-group assemble-right">
        <label for="password_confirm">Xác nhận mật khẩu mới</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🔒</span>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control-custom" placeholder="••••••••" required autocomplete="new-password">
            <button type="button" class="btn-toggle-pw toggle-password" data-target="password_confirm" onclick="togglePasswordVisibility(this)" title="Bật/Tắt hiển thị mật khẩu">👁️</button>
        </div>
    </div>

    <div class="assemble-bottom-1">
        <button type="submit" class="btn-login">CẬP NHẬT MẬT KHẨU</button>
    </div>
</form>

<div class="auth-footer assemble-bottom-2">
    <span>Quay lại <a href="/login">Đăng nhập</a></span>
</div>

<script>
function togglePasswordVisibility(btn) {
    const targetId = btn.getAttribute('data-target');
    const input = targetId ? document.getElementById(targetId) : btn.parentElement.querySelector('input');
    if (input) {
        if (input.type === 'password') {
            input.type = 'text';
            btn.textContent = '🙈';
        } else {
            input.type = 'password';
            btn.textContent = '👁️';
        }
    }
}
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>