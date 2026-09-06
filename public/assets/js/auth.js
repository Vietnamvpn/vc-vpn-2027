document.addEventListener('DOMContentLoaded', function () {
    // 1. Ẩn/Hiện Mật Khẩu (Password Visibility Toggle)
    const togglePasswordBtns = document.querySelectorAll('.toggle-password');
    
    togglePasswordBtns.forEach(function (btn) {
        btn.addEventListener('click', function () {
            const targetId = this.getAttribute('data-target');
            const passwordInput = document.getElementById(targetId) || this.previousElementSibling;
            
            if (passwordInput && (passwordInput.type === 'password' || passwordInput.type === 'text')) {
                if (passwordInput.type === 'password') {
                    passwordInput.type = 'text';
                    this.textContent = '👁️‍🗨️';
                } else {
                    passwordInput.type = 'password';
                    this.textContent = '👁️';
                }
            }
        });
    });

    // 2. Validation Form Đăng Ký / Đổi Mật Khẩu
    const authForms = document.querySelectorAll('.auth-form');

    authForms.forEach(function (form) {
        form.addEventListener('submit', function (e) {
            const password = form.querySelector('input[name="password"]');
            const confirmPassword = form.querySelector('input[name="confirm_password"]');
            const submitBtn = form.querySelector('button[type="submit"]');

            // Kiểm tra mật khẩu khớp nhau
            if (password && confirmPassword) {
                if (password.value !== confirmPassword.value) {
                    e.preventDefault();
                    alert('Mật khẩu xác nhận không trùng khớp. Vui lòng kiểm tra lại!');
                    confirmPassword.focus();
                    return false;
                }
            }

            // Kiểm tra độ dài mật khẩu tối thiểu (6 ký tự)
            if (password && password.value.length < 6) {
                e.preventDefault();
                alert('Mật khẩu phải chứa ít nhất 6 ký tự!');
                password.focus();
                return false;
            }

            // Hiệu ứng Loading cho nút submit
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.style.opacity = '0.7';
                submitBtn.style.cursor = 'wait';
                const originalText = submitBtn.innerHTML;
                submitBtn.innerHTML = '⏳ Đang xử lý...';

                // Khôi phục nút nếu có sự cố
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