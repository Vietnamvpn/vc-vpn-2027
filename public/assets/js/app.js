document.addEventListener('DOMContentLoaded', function () {
    const sidebar = document.querySelector('.admin-sidebar');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const overlay = document.querySelector('.sidebar-overlay');
    const profileBtn = document.getElementById('profile-dropdown-btn');
    const profileMenu = document.getElementById('profile-dropdown-menu');

    function closeAll() {
        if (sidebar) sidebar.classList.remove('active');
        if (profileMenu) profileMenu.classList.remove('show');
        if (overlay) overlay.classList.remove('active');
    }

    // 1. Toggle Sidebar Mobile
    if (sidebar && toggleBtn) {
        toggleBtn.addEventListener('click', function (e) {
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
        });
    }

    // 2. Toggle Profile Menu (Mở kèm lớp phủ đen mờ bên dưới)
    if (profileBtn && profileMenu) {
        profileBtn.addEventListener('click', function (e) {
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
        });
    }

    // 3. Bấm vào lớp đen mờ -> Đóng tất cả
    if (overlay) {
        overlay.addEventListener('click', closeAll);
    }

    // 4. Bấm ra ngoài vùng menu -> Đóng Profile Menu & tắt lớp mờ
    document.addEventListener('click', function (e) {
        if (profileBtn && profileMenu && !profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
            if (profileMenu.classList.contains('show')) {
                closeAll();
            }
        }
    });

    window.addEventListener('resize', function () {
        if (window.innerWidth >= 992) {
            if (sidebar) sidebar.classList.remove('active');
            if (overlay && (!profileMenu || !profileMenu.classList.contains('show'))) {
                overlay.classList.remove('active');
            }
        }
    });
});