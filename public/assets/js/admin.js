document.addEventListener('DOMContentLoaded', function () {
    // 1. Quản lý Màn hình chờ (Preloader)
    const preloader = document.getElementById('page-preloader');

    // Tự động ẩn Preloader khi trang đã tải xong
    if (preloader) {
        preloader.style.opacity = '0';
        setTimeout(() => {
            preloader.style.display = 'none';
        }, 300);
    }

    // Xử lý bật/tắt Preloader khi chuyển trang hoặc bấm nút xóa
    document.addEventListener('click', function (e) {
        const link = e.target.closest('a');
        if (!link) return;

        const href = link.getAttribute('href');
        // Bỏ qua các link nội bộ, javascript hoặc mở tab mới
        if (!href || href.startsWith('#') || href.startsWith('javascript:') || link.target === '_blank') {
            return;
        }

        // Đợi kiểm tra sự kiện xem người dùng có bấm "Hủy" ở confirm() hay không
        setTimeout(() => {
            if (e.defaultPrevented) {
                // Nếu bấm "Hủy" (event bị hủy), ẩn Preloader ngay lập tức
                if (preloader) {
                    preloader.style.display = 'none';
                    preloader.style.opacity = '0';
                }
            } else if (preloader) {
                // Nếu bấm "OK" hoặc chuyển trang bình thường, hiển thị Preloader
                preloader.style.display = 'flex';
                preloader.style.opacity = '1';
            }
        }, 10);
    });

    // 2. Xử lý toggle Menu Ba Chấm (Action Dropdown)
    const actionBtns = document.querySelectorAll('.action-btn');

    actionBtns.forEach(btn => {
        btn.addEventListener('click', function (e) {
            e.stopPropagation();
            const currentMenu = this.nextElementSibling;
            
            // Đóng tất cả menu ba chấm khác đang mở
            document.querySelectorAll('.action-menu.show').forEach(menu => {
                if (menu !== currentMenu) {
                    menu.classList.remove('show');
                    if (menu.previousElementSibling) {
                        menu.previousElementSibling.classList.remove('active');
                    }
                }
            });

            // Bật/tắt menu hiện tại
            if (currentMenu) {
                const isOpen = currentMenu.classList.toggle('show');
                this.classList.toggle('active', isOpen);
            }
        });
    });

    // Bấm ra ngoài vùng menu -> Tự động đóng tất cả dropdown
    document.addEventListener('click', function () {
        document.querySelectorAll('.action-menu.show').forEach(menu => {
            menu.classList.remove('show');
            if (menu.previousElementSibling) {
                menu.previousElementSibling.classList.remove('active');
            }
        });
    });

    // 3. Xử lý Tự động ẩn và Nút đóng (✕) cho Thông Báo Flash
    const alerts = document.querySelectorAll('.glass-alert');
    alerts.forEach(alert => {
        // Tự động ẩn sau 4 giây
        const timer = setTimeout(() => {
            dismissAlert(alert);
        }, 4000);

        // Bấm nút ✕ để tắt ngay lập tức
        const closeBtn = alert.querySelector('.alert-close');
        if (closeBtn) {
            closeBtn.addEventListener('click', function () {
                clearTimeout(timer);
                dismissAlert(alert);
            });
        }
    });

    function dismissAlert(alertEl) {
        alertEl.style.transition = 'opacity 0.4s ease, transform 0.4s ease, margin 0.4s ease, padding 0.4s ease';
        alertEl.style.opacity = '0';
        alertEl.style.transform = 'translateY(-10px)';
        setTimeout(() => {
            alertEl.remove();
        }, 400);
    }
});