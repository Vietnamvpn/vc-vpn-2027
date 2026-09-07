document.addEventListener('DOMContentLoaded', function () {
    // Xử lý toggle Menu Ba Chấm (Action Dropdown)
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
});