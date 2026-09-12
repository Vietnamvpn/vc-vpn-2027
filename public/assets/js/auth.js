document.addEventListener('DOMContentLoaded', function () {
    // 1. Logic Toggle Ẩn/Hiện Mật Khẩu
    const toggleBtns = document.querySelectorAll('.toggle-password, .btn-toggle-pw');

    toggleBtns.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            e.stopPropagation();
            
            const targetId = this.getAttribute('data-target');
            let passwordInput = null;

            if (targetId) {
                passwordInput = document.getElementById(targetId);
            } else {
                passwordInput = this.parentElement.querySelector('input[type="password"], input[type="text"]');
            }

            if (passwordInput) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.textContent = '🙈';
                } else {
                    passwordInput.type = 'password';
                    this.textContent = '👁️';
                }
            }
        });
    });

    // 2. Logic Gửi Mã Xác Thực OTP (Áp dụng tự động cho Đăng ký & Quên Mật Khẩu)
    const btnSendOtp = document.getElementById('btnSendOtp');
    if (btnSendOtp) {
        btnSendOtp.addEventListener('click', function (e) {
            e.preventDefault();
            
            const emailInput = document.getElementById('email');
            const csrfTokenInput = document.getElementById('csrf_token');
            const alertBox = document.getElementById('ajax-alert');
            const targetUrl = this.getAttribute('data-action') || '/register/send-otp';

            if (!emailInput || !emailInput.value || !emailInput.checkValidity()) {
                if (alertBox) {
                    alertBox.style.display = 'block';
                    alertBox.className = 'auth-alert alert-danger';
                    alertBox.textContent = 'Vui lòng nhập địa chỉ Email hợp lệ trước khi lấy mã OTP.';
                }
                if (emailInput) emailInput.focus();
                return;
            }

            btnSendOtp.disabled = true;
            btnSendOtp.textContent = 'Đang gửi...';

            const formData = new FormData();
            formData.append('email', emailInput.value);
            if (csrfTokenInput) {
                formData.append('csrf_token', csrfTokenInput.value);
            }

            fetch(targetUrl, {
                method: 'POST',
                body: formData
            })
            .then(response => response.json())
            .then(data => {
                if (alertBox) alertBox.style.display = 'block';
                if (data.success) {
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-success';
                        alertBox.textContent = data.message;
                    }
                    startOtpCountdown(btnSendOtp, 60);
                } else {
                    if (alertBox) {
                        alertBox.className = 'auth-alert alert-danger';
                        alertBox.textContent = data.message || 'Có lỗi xảy ra.';
                    }
                    btnSendOtp.disabled = false;
                    btnSendOtp.textContent = 'Gửi mã';
                }
            })
            .catch(error => {
                if (alertBox) {
                    alertBox.style.display = 'block';
                    alertBox.className = 'auth-alert alert-danger';
                    alertBox.textContent = 'Không thể kết nối đến máy chủ. Vui lòng thử lại sau.';
                }
                btnSendOtp.disabled = false;
                btnSendOtp.textContent = 'Gửi mã';
            });
        });
    }

    // 3. Đếm ngược thời gian chờ gửi lại OTP
    function startOtpCountdown(button, seconds) {
        let left = seconds;
        button.disabled = true;

        const timer = setInterval(() => {
            if (left <= 0) {
                clearInterval(timer);
                button.disabled = false;
                button.textContent = 'Gửi mã';
            } else {
                button.textContent = left + 's';
                left--;
            }
        }, 1000);
    }

    // 4. Validation Form & Loading Indicator
    const authForms = document.querySelectorAll('.auth-form');
    authForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const password = form.querySelector('input[name="password"]');
            const confirmPassword = form.querySelector('input[name="password_confirm"], input[name="confirm_password"]');
            const submitBtn = form.querySelector('button[type="submit"]');

            if (password && confirmPassword && password.value !== confirmPassword.value) {
                e.preventDefault();
                alert('Mật khẩu xác nhận không trùng khớp. Vui lòng kiểm tra lại!');
                confirmPassword.focus();
                return false;
            }

            if (password && password.value.length < 6) {
                e.preventDefault();
                alert('Mật khẩu phải chứa ít nhất 6 ký tự!');
                password.focus();
                return false;
            }

            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.7';
                submitBtn.style.cursor = 'wait';
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '⏳ Đang xử lý...';

                setTimeout(function () {
                    submitBtn.disabled = false;
                    submitBtn.style.opacity = '1';
                    submitBtn.style.cursor = 'pointer';
                    submitBtn.innerHTML = originalText;
                }, 8000);
            }
        });
    });
});