document.addEventListener('DOMContentLoaded', function () {
    // 1. Logic Toggle Ẩn/Hiện Mật Khẩu (Bắt sự kiện chính xác)
    const toggleBtns = document.querySelectorAll('.toggle-password, .btn-toggle-pw');

    toggleBtns.forEach(function (btn) {
        btn.addEventListener('click', function (e) {
            e.preventDefault();
            const targetId = this.getAttribute('data-target');
            let passwordInput = null;

            if (targetId) {
                passwordInput = document.getElementById(targetId);
            } else {
                passwordInput = this.parentElement.querySelector('input');
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

    // 2. Validation Form & Loading Indicator
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