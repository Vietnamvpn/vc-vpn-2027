<?php
$authTitle = "Quên Mật Khẩu";
$authSubtitle = "Nhập email để nhận liên kết khôi phục";
ob_start();
?>

<form action="/forgot-password" method="POST" class="auth-form">
    <?php if (isset($error)): ?>
        <div style="background: rgba(255, 59, 48, 0.12); color: #dc2626; padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.85rem; border: 1px solid rgba(220, 38, 38, 0.3); margin-bottom: 1.5rem; text-align: center;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div style="background: rgba(52, 199, 89, 0.12); color: #16a34a; padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.85rem; border: 1px solid rgba(22, 163, 74, 0.3); margin-bottom: 1.5rem; text-align: center;">
            <?= htmlspecialchars($success) ?>
        </div>
    <?php endif; ?>

    <div class="form-group assemble-left">
        <label for="email">Địa chỉ Email đã đăng ký</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">✉️</span>
            <input type="email" id="email" name="email" class="form-control-custom" placeholder="email@domain.com" required autofocus>
        </div>
    </div>

    <div class="assemble-bottom-1">
        <button type="submit" class="btn-login">GỬI YÊU CẦU</button>
    </div>
</form>

<div class="auth-footer assemble-bottom-2">
    <span>Quay lại <a href="/login">Đăng nhập</a></span>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>