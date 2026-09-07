<?php
$authTitle = "VC VPN 2027";
$authSubtitle = "An Toàn - Bảo Mật - Uy Tín";
ob_start();
?>

<form action="/login" method="POST" class="auth-form">
    <?php if (isset($error)): ?>
        <div style="background: rgba(255, 59, 48, 0.12); color: #dc2626; padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.85rem; border: 1px solid rgba(220, 38, 38, 0.3); margin-bottom: 1.5rem; text-align: center;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="form-group assemble-left">
        <label for="username">Tên đăng nhập hoặc Email</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">👤</span>
            <input type="text" id="username" name="username" class="form-control-custom" placeholder="Email hoặc Username" required autofocus>
        </div>
    </div>

    <div class="form-group assemble-right">
        <label for="password">Mật khẩu</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🔒</span>
            <input type="password" id="password" name="password" class="form-control-custom" placeholder="••••••••" required>
            <button type="button" class="btn-toggle-pw toggle-password" data-target="password" title="Bật/Tắt hiển thị mật khẩu">👁️</button>
        </div>
    </div>

    <div class="assemble-bottom-1">
        <button type="submit" class="btn-login">ĐĂNG NHẬP</button>
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