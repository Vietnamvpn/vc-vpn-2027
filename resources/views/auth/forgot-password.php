<?php
$authTitle = "Quên Mật Khẩu";
$authSubtitle = "Nhập email để nhận liên kết khôi phục";
ob_start();
?>

<form action="/forgot-password" method="POST" class="auth-form">
    <?php if (isset($error)): ?>
        <div style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.85rem; border: 1px solid rgba(255, 59, 48, 0.3);">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div style="background: rgba(52, 199, 89, 0.15); color: var(--ios-success); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.85rem; border: 1px solid rgba(52, 199, 89, 0.3);">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="email">Địa chỉ Email đã đăng ký</label>
        <input type="email" id="email" name="email" class="glass-input" placeholder="email@domain.com" required autofocus>
    </div>

    <button type="submit" class="glass-btn" style="width: 100%; margin-top: 0.5rem;">Gửi Yêu Cầu</button>
</form>

<div class="auth-footer" style="margin-top: 1rem;">
    Quay lại <a href="/login">Đăng nhập</a>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>