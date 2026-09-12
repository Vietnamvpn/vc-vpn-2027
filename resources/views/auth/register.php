<?php
$authTitle = "Tạo Tài Khoản";
$authSubtitle = "Trải nghiệm dịch vụ VPN chất lượng cao";
ob_start();
?>

<form action="/register" method="POST" class="auth-form" id="registerForm">
    <!-- CSRF Protection Input Token -->
    <input type="hidden" name="csrf_token" id="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '', ENT_QUOTES, 'UTF-8') ?>">

    <?php if (isset($error)): ?>
        <div style="background: rgba(255, 59, 48, 0.12); color: #dc2626; padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.85rem; border: 1px solid rgba(220, 38, 38, 0.3); margin-bottom: 1.5rem; text-align: center;">
            <?= htmlspecialchars($error, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <?php if (isset($success)): ?>
        <div style="background: rgba(52, 199, 89, 0.12); color: #16a34a; padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.85rem; border: 1px solid rgba(22, 163, 74, 0.3); margin-bottom: 1.5rem; text-align: center;">
            <?= htmlspecialchars($success, ENT_QUOTES, 'UTF-8') ?>
        </div>
    <?php endif; ?>

    <div id="ajax-alert" style="display: none; padding: 0.75rem 1rem; border-radius: 12px; font-size: 0.85rem; margin-bottom: 1.5rem; text-align: center;"></div>

    <div class="form-group assemble-left">
        <label for="username">Tên đăng nhập</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">👤</span>
            <input type="text" id="username" name="username" class="form-control-custom" placeholder="ten_tai_khoan" required autofocus autocomplete="username">
        </div>
    </div>

    <div class="form-group assemble-right">
        <label for="email">Địa chỉ Email</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">✉️</span>
            <input type="email" id="email" name="email" class="form-control-custom" placeholder="email@domain.com" required autocomplete="email">
        </div>
    </div>

    <!-- Khối Nhập Mã Xác Thực OTP Email -->
    <div class="form-group assemble-left">
        <label for="otp_code">Mã xác thực OTP (Gửi qua Email)</label>
        <div class="input-group-custom" style="display: flex; gap: 8px;">
            <span class="input-group-text-custom">🔑</span>
            <input type="text" id="otp_code" name="otp_code" class="form-control-custom" placeholder="6 chữ số" maxlength="6" required style="flex: 1;">
            <button type="button" id="btnSendOtp" class="btn-toggle-pw" style="padding: 0 12px; font-size: 0.8rem; font-weight: 600; background: var(--ios-blue, #3b82f6); color: #fff; border-radius: 8px; border: none; cursor: pointer; white-space: nowrap; width: auto;" onclick="sendOtpCode()">Gửi mã</button>
        </div>
    </div>

    <div class="form-group assemble-left">
        <label for="password">Mật khẩu</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🔒</span>
            <input type="password" id="password" name="password" class="form-control-custom" placeholder="••••••••" required autocomplete="new-password">
            <button type="button" class="btn-toggle-pw toggle-password" data-target="password" onclick="togglePasswordVisibility(this)" title="Bật/Tắt hiển thị mật khẩu">👁️</button>
        </div>
    </div>

    <div class="form-group assemble-right">
        <label for="password_confirm">Xác nhận mật khẩu</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🔒</span>
            <input type="password" id="password_confirm" name="password_confirm" class="form-control-custom" placeholder="••••••••" required autocomplete="new-password">
            <button type="button" class="btn-toggle-pw toggle-password" data-target="password_confirm" onclick="togglePasswordVisibility(this)" title="Bật/Tắt hiển thị mật khẩu">👁️</button>
        </div>
    </div>

    <div class="form-group assemble-left">
        <label for="ref_code">Mã giới thiệu (Nếu có)</label>
        <div class="input-group-custom">
            <span class="input-group-text-custom">🎁</span>
            <input type="text" id="ref_code" name="ref_code" class="form-control-custom" placeholder="Mã giới thiệu" value="<?= htmlspecialchars($_GET['ref'] ?? '', ENT_QUOTES, 'UTF-8') ?>">
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

function sendOtpCode() {
    const emailInput = document.getElementById('email');
    const btnSend = document.getElementById('btnSendOtp');
    const csrfToken = document.getElementById('csrf_token').value;
    const alertBox = document.getElementById('ajax-alert');

    if (!emailInput.value || !emailInput.checkValidity()) {
        alertBox.style.display = 'block';
        alertBox.style.background = 'rgba(255, 59, 48, 0.12)';
        alertBox.style.color = '#dc2626';
        alertBox.style.border = '1px solid rgba(220, 38, 38, 0.3)';
        alertBox.textContent = 'Vui lòng nhập địa chỉ Email hợp lệ trước khi lấy mã OTP.';
        emailInput.focus();
        return;
    }

    btnSend.disabled = true;
    btnSend.textContent = 'Đang gửi...';

    const formData = new FormData();
    formData.append('email', emailInput.value);
    formData.append('csrf_token', csrfToken);

    fetch('/register/send-otp', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alertBox.style.display = 'block';
        if (data.success) {
            alertBox.style.background = 'rgba(52, 199, 89, 0.12)';
            alertBox.style.color = '#16a34a';
            alertBox.style.border = '1px solid rgba(22, 163, 74, 0.3)';
            alertBox.textContent = data.message;
            startOtpCountdown(60);
        } else {
            alertBox.style.background = 'rgba(255, 59, 48, 0.12)';
            alertBox.style.color = '#dc2626';
            alertBox.style.border = '1px solid rgba(220, 38, 38, 0.3)';
            alertBox.textContent = data.message || 'Có lỗi xảy ra.';
            btnSend.disabled = false;
            btnSend.textContent = 'Gửi mã';
        }
    })
    .catch(error => {
        alertBox.style.display = 'block';
        alertBox.style.background = 'rgba(255, 59, 48, 0.12)';
        alertBox.style.color = '#dc2626';
        alertBox.style.border = '1px solid rgba(220, 38, 38, 0.3)';
        alertBox.textContent = 'Không thể kết nối đến máy chủ. Vui lòng thử lại sau.';
        btnSend.disabled = false;
        btnSend.textContent = 'Gửi mã';
    });
}

function startOtpCountdown(seconds) {
    const btnSend = document.getElementById('btnSendOtp');
    let left = seconds;
    btnSend.disabled = true;

    const timer = setInterval(() => {
        if (left <= 0) {
            clearInterval(timer);
            btnSend.disabled = false;
            btnSend.textContent = 'Gửi mã';
        } else {
            btnSend.textContent = left + 's';
            left--;
        }
    }, 1000);
}
</script>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/auth.php';
?>