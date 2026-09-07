<?php
$authTitle = "VC VPN 2027";
$authSubtitle = "An Toàn - Bảo Mật - Uy Tín";
ob_start();
?>

<form action="/login" method="POST" class="auth-form">
    <?php if (isset($error)): ?>
        <div style="background: rgba(255, 59, 48, 0.15); color: #ff4d4d; padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.85rem; border: 1px solid rgba(255, 59, 48, 0.3); margin-bottom: 1rem;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="form-group assemble-left" style="margin-bottom: 1rem;">
        <label for="username" style="display: block; font-weight: 700; font-size: 0.85rem; color: #d4af37; margin-bottom: 0.4rem; margin-left: 5px;">Tên đăng nhập hoặc Email</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">👤</span>
            <input type="text" id="username" name="username" class="form-control-custom" placeholder="Email hoặc Username" required autofocus>
        </div>
    </div>

    <div class="form-group assemble-right" style="margin-bottom: 1.25rem;">
        <label for="password" style="display: block; font-weight: 700; font-size: 0.85rem; color: #d4af37; margin-bottom: 0.4rem; margin-left: 5px;">Mật khẩu</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🔒</span>
            <input type="password" id="password" name="password" class="form-control-custom" placeholder="Password" required>
            <button type="button" class="btn-toggle-pw toggle-password" data-target="password" title="Bật/Tắt hiển thị mật khẩu">👁️</button>
        </div>
    </div>

    <div class="assemble-bottom-1">
        <button type="submit" class="btn-login">Đăng Nhập</button>
    </div>
</form>

<div class="auth-footer assemble-bottom-2">
    <a href="/forgot-password">Quên mật khẩu?</a>
    <span class="divider">|</span>
    <a href="/register">Đăng ký ngay</a>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>