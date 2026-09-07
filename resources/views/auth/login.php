<?php
$authTitle = "Đăng Nhập";
$authSubtitle = "Truy cập tài khoản VC VPN 2027 của bạn";
ob_start();
?>

<form action="/login" method="POST" class="auth-form">
    <?php if (isset($error)): ?>
        <div style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.85rem; border: 1px solid rgba(255, 59, 48, 0.3);">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="username">Tên đăng nhập hoặc Email</label>
        <div class="input-icon-wrapper">
            <span class="field-icon">👤</span>
            <input type="text" id="username" name="username" class="glass-input" placeholder="nhap_tai_khoan" required autofocus>
        </div>
    </div>

    <div class="form-group">
        <label for="password">Mật khẩu</label>
        <div class="input-icon-wrapper">
            <span class="field-icon">🔒</span>
            <input type="password" id="password" name="password" class="glass-input" placeholder="••••••••" required>
            <span class="toggle-password" data-target="password" title="Bật/Tắt hiển thị mật khẩu">👁️</span>
        </div>
    </div>

    <button type="submit" class="glass-btn" style="width: 100%; margin-top: 0.5rem;">Đăng Nhập</button>
</form>

<div class="auth-footer">
    <a href="/forgot-password">Quên mật khẩu?</a>
    <span class="divider">|</span>
    <span>Chưa có tài khoản? <a href="/register">Đăng ký ngay</a></span>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>