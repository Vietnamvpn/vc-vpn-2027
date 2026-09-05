<?php
$authTitle = "Đăng Nhập";
$authSubtitle = "Truy cập tài khoản VC VPN 2027 của bạn";
ob_start();
?>

<form action="/auth/login" method="POST" class="auth-form">
    <?php if (isset($error)): ?>
        <div style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.85rem; border: 1px solid rgba(255, 59, 48, 0.3);">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="username">Tên đăng nhập hoặc Email</label>
        <input type="text" id="username" name="username" class="glass-input" placeholder="nhap_tai_khoan" required autofocus>
    </div>

    <div class="form-group">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <label for="password">Mật khẩu</label>
            <a href="/auth/forgot-password" style="font-size: 0.75rem; color: var(--ios-blue); text-decoration: none;">Quên mật khẩu?</a>
        </div>
        <input type="password" id="password" name="password" class="glass-input" placeholder="••••••••" required>
    </div>

    <button type="submit" class="glass-btn" style="width: 100%; margin-top: 0.5rem;">Đăng Nhập</button>
</form>

<div class="auth-footer" style="margin-top: 1rem;">
    Chưa có tài khoản? <a href="/auth/register">Đăng ký ngay</a>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>