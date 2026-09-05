<?php
$authTitle = "Đặt Lại Mật Khẩu";
$authSubtitle = "Tạo mật khẩu mới cho tài khoản của bạn";
ob_start();
?>

<form action="/auth/reset-password" method="POST" class="auth-form">
    <input type="hidden" name="token" value="<?= htmlspecialchars($_GET['token'] ?? '') ?>">

    <?php if (isset($error)): ?>
        <div style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.85rem; border: 1px solid rgba(255, 59, 48, 0.3);">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="password">Mật khẩu mới</label>
        <input type="password" id="password" name="password" class="glass-input" placeholder="••••••••" required autofocus>
    </div>

    <div class="form-group">
        <label for="password_confirm">Xác nhận mật khẩu mới</label>
        <input type="password" id="password_confirm" name="password_confirm" class="glass-input" placeholder="••••••••" required>
    </div>

    <button type="submit" class="glass-btn" style="width: 100%; margin-top: 0.5rem;">Cập Nhật Mật Khẩu</button>
</form>

<div class="auth-footer" style="margin-top: 1rem;">
    Quay lại <a href="/auth/login">Đăng nhập</a>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>