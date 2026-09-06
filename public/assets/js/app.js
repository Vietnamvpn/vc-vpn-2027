document.addEventListener('DOMContentLoaded', function () {
    // 1. Xử lý Toggle Sidebar Mobile
    const sidebar = document.querySelector('.admin-sidebar');
    const toggleBtn = document.getElementById('sidebar-toggle');
    const overlay = document.querySelector('.sidebar-overlay');

    if (sidebar && toggleBtn) {
        toggleBtn.onclick = function (e) {
            e.preventDefault();
            e.stopPropagation();
            sidebar.classList.toggle('active');
            if (overlay) overlay.classList.toggle('active');
        };

        if (overlay) {
            overlay.onclick = function () {
                sidebar.classList.remove('active');
                overlay.classList.remove('active');
            };
        }

        window.addEventListener('resize', function () {
            if (window.innerWidth >= 992) {
                sidebar.classList.remove('active');
                if (overlay) overlay.classList.remove('active');
            }
        });
    }

    // 2. Xử lý Profile Dropdown Menu
    const profileBtn = document.getElementById('profile-dropdown-btn');
    const profileMenu = document.getElementById('profile-dropdown-menu');

    if (profileBtn && profileMenu) {
        profileBtn.onclick = function (e) {
            e.preventDefault();
            e.stopPropagation();
            profileMenu.classList.toggle('show');
        };

        document.onclick = function (e) {
            if (!profileBtn.contains(e.target) && !profileMenu.contains(e.target)) {
                profileMenu.classList.remove('show');
            }
        };
    }
});