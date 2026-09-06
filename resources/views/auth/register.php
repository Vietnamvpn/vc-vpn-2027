<?php
$authTitle = "Tạo Tài Khoản";
$authSubtitle = "Trải nghiệm dịch vụ VPN chất lượng cao";
ob_start();
?>

<form action="/register" method="POST" class="auth-form">
    <?php if (isset($error)): ?>
        <div style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.85rem; border: 1px solid rgba(255, 59, 48, 0.3);">
            <?= htmlspecialchars($error) ?>
        </div>
    <?php endif; ?>

    <div class="form-group">
        <label for="username">Tên đăng nhập</label>
        <input type="text" id="username" name="username" class="glass-input" placeholder="ten_tai_khoan" required autofocus>
    </div>

    <div class="form-group">
        <label for="email">Địa chỉ Email</label>
        <input type="email" id="email" name="email" class="glass-input" placeholder="email@domain.com" required>
    </div>

    <div class="form-group">
        <label for="password">Mật khẩu</label>
        <input type="password" id="password" name="password" class="glass-input" placeholder="••••••••" required>
    </div>

    <div class="form-group">
        <label for="password_confirm">Xác nhận mật khẩu</label>
        <input type="password" id="password_confirm" name="password_confirm" class="glass-input" placeholder="••••••••" required>
    </div>

    <div class="form-group">
        <label for="ref_code">Mã giới thiệu (Nếu có)</label>
        <input type="text" id="ref_code" name="ref_code" class="glass-input" placeholder="Mã giới thiệu" value="<?= htmlspecialchars($_GET['ref'] ?? '') ?>">
    </div>

    <button type="submit" class="glass-btn" style="width: 100%; margin-top: 0.5rem;">Đăng Ký</button>
</form>

<div class="auth-footer" style="margin-top: 1rem;">
    Đã có tài khoản? <a href="/login">Đăng nhập</a>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>