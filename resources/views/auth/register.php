<?php
$authTitle = "Tạo Tài Khoản";
$authSubtitle = "Trải nghiệm dịch vụ VPN chất lượng cao";
ob_start();
?>

<form action="/register" method="POST" class="auth-form">
    <?php if (isset($error)): ?>
        <div style="background: rgba(255, 59, 48, 0.12); color: #dc2626; padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.85rem; border: 1px solid rgba(220, 38, 38, 0.3); margin-bottom: 1.5rem; text-align: center;">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="form-group assemble-left">
        <label for="username">Tên đăng nhập</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">👤</span>
            <input type="text" id="username" name="username" class="form-control-custom" placeholder="ten_tai_khoan" required autofocus>
        </div>
    </div>

    <div class="form-group assemble-right">
        <label for="email">Địa chỉ Email</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">✉️</span>
            <input type="email" id="email" name="email" class="form-control-custom" placeholder="email@domain.com" required>
        </div>
    </div>

    <div class="form-group assemble-left">
        <label for="password">Mật khẩu</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🔒</span>
            <input type="password" id="password" name="password" class="form-control-custom" placeholder="••••••••" required>
            <button type="button" class="btn-toggle-pw toggle-password" data-target="password" onclick="togglePasswordVisibility(this)" title="Bật/Tắt hiển thị mật khẩu">👁️</button>
        </div>
    </div>

    <div class="form-group assemble-right">
        <label for="password_confirm">Xác nhận mật khẩu</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🔒</span>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control-custom" placeholder="••••••••" required>
            <button type="button" class="btn-toggle-pw toggle-password" data-target="password_confirm" onclick="togglePasswordVisibility(this)" title="Bật/Tắt hiển thị mật khẩu">👁️</button>
        </div>
    </div>

    <div class="form-group assemble-left">
        <label for="ref_code">Mã giới thiệu (Nếu có)</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🎁</span>
            <input type="text" id="ref_code" name="ref_code" class="form-control-custom" placeholder="Mã giới thiệu" value="<?= htmlspecialchars($_GET['ref'] ?? '') ?>">
        </div>
    </div>

    <div class="assemble-bottom-1">
        <button type="submit" class="btn-login">ĐĂNG KÝ</button>
    </div>
</form>

<div class="auth-footer assemble-bottom-2">
    <span>Đã có tài khoản? <a href="/login">Đăng nhập</a></span>
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