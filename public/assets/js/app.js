document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.admin-sidebar');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const overlay = document.querySelector('.sidebar-overlay');
    const profileBtn = document.getElementById('profile-dropdown-btn');
    const profileMenu = document.getElementById('profile-dropdown-menu');

    // Hàm đóng tất cả menu và ẩn lớp phủ đen mờ
    function closeAll() {
        if (sidebar) sidebar.classList.remove('active');
        if (profileMenu) profileMenu.classList.remove('show');
        if (overlay) overlay.classList.remove('active');
    }

    // 1. Toggle Sidebar Mobile (Menu 3 gạch)
    if (sidebar && toggleBtn) {
        toggleBtn.onclick = function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (profileMenu) profileMenu.classList.remove('show');

            const isSidebarActive = sidebar.classList.toggle('active');
            if (overlay) {
                if (isSidebarActive) {
                    overlay.classList.add('active');
                } else {
                    overlay.classList.remove('active');
                }
            }
        };
    }

    // 2. Toggle Menu Profile (Hiển thị cùng nền đen mờ)
    if (profileBtn && profileMenu) {
        profileBtn.onclick = function (e) {
            e.preventDefault();
            e.stopPropagation();
            if (sidebar) sidebar.classList.remove('active');

            const isProfileShow = profileMenu.classList.toggle('show');
            if (overlay) {
                if (isProfileShow) {
                    overlay.classList.add('active');
                } else {
                    overlay.classList.remove('active');
                }
            }
        };
    }

    // 3. Bấm vào lớp phủ mờ đen thì đóng toàn bộ menu
    if (overlay) {
        overlay.onclick = function () {
            closeAll();
        };
    }

    // 4. Bấm ra ngoài vùng menu cũng đóng toàn bộ
    document.onclick = function (e) {
        if (profileBtn && profileMenu && !profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
            if (profileMenu.classList.contains('show')) {
                closeAll();
            }
        }
    };

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) {
            if (sidebar) sidebar.classList.remove('active');
        }
    });
});