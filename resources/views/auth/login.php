<?php
$authTitle = "Đăng Nhập Tài Khoản";
$authSubtitle = $siteSubtitle ?? "An Toàn - Bảo Mật - Uy Tín";
ob_start();
?>

<form action="/login" method="POST" class="auth-form">
    <!-- CSRF Protection Input Token -->
    <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <?php if (isset($error)): ?>
        <div class="auth-alert alert-danger">
            <span><?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?></span>
            <span class="close-alert">&times;</span>
        </div>
    <?php endif; ?>

    <div class="form-group assemble-left">
        <label for="username">Tên đăng nhập hoặc Email</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">👤</span>
            <input type="text" id="username" name="username" class="form-control-custom" placeholder="Email hoặc Username" required autofocus autocomplete="username">
        </div>
    </div>

    <div class="form-group assemble-right">
        <label for="password">Mật khẩu</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🔒</span>
            <input type="password" id="password" name="password" class="form-control-custom" placeholder="••••••••" required autocomplete="current-password">
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