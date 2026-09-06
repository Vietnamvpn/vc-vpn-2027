<?php
$currentUri = $_SERVER['REQUEST_URI'] ?? '';
$isAdminRoute = (strncmp($currentUri, '/admin', 6) === 0);
$userRole = $_SESSION['role'] ?? 'user';

// Logic chuyển đổi trang linh hoạt khi click Logo cho Admin
$logoHref = '/';
if (isset($_SESSION['user_id'])) {
    if ($userRole === 'admin') {
        $logoHref = $isAdminRoute ? '/user/dashboard' : '/admin/dashboard';
    } else {
        $logoHref = '/user/dashboard';
    }
}
?>

<nav class="glass-card navbar-container" style="margin: 0; padding: 0.75rem 1.5rem; border-radius: 0; border-x: none; border-top: none; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; z-index: 1001;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <!-- Nút Toggle Sidebar Mobile -->
        <button id="sidebar-toggle" type="button" aria-label="Toggle Sidebar" style="background: transparent; border: none; font-size: 1.3rem; color: var(--ios-text); cursor: pointer; padding: 0.25rem 0.5rem; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-sm);" class="mobile-only-btn">
            ☰
        </button>

        <!-- Logo Web: Admin click vào sẽ chuyển linh hoạt giữa 2 trang -->
        <a href="<?= $logoHref ?>" title="<?= ($userRole === 'admin') ? ($isAdminRoute ? 'Chuyển sang Trang User' : 'Chuyển sang Trang Admin') : 'Trang Chủ' ?>" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: var(--ios-text); font-weight: 700; font-size: 1.1rem;">
            <img src="/assets/images/logo.png" alt="Logo" style="height: 32px; width: 32px; border-radius: 8px;">
            <span>VC VPN 2027</span>
            <?php if ($userRole === 'admin'): ?>
                <span style="font-size: 0.65rem; background: rgba(0, 122, 255, 0.15); color: var(--ios-blue); padding: 0.15rem 0.4rem; border-radius: 4px; border: 1px solid rgba(0,122,255,0.2);">
                    <?= $isAdminRoute ? 'ADMIN' : 'USER' ?>
                </span>
            <?php endif; ?>
        </a>
    </div>

    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Menu Profile Dropdown -->
            <div class="profile-dropdown-wrapper" style="position: relative;">
                <button type="button" id="profile-dropdown-btn" class="profile-trigger" style="display: flex; align-items: center; gap: 0.5rem; background: rgba(255, 255, 255, 0.25); border: 1px solid var(--glass-border); padding: 0.4rem 0.8rem; border-radius: 9999px; cursor: pointer; color: var(--ios-text); font-weight: 600; font-size: 0.85rem;">
                    <span style="width: 24px; height: 24px; border-radius: 50%; background: var(--ios-blue); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">
                        <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
                    </span>
                    <span><?= htmlspecialchars($_SESSION['username'] ?? 'Tài khoản') ?></span>
                    <span style="font-size: 0.7rem; color: var(--ios-text-secondary);">▼</span>
                </button>

                <!-- Box Sổ Xung Cụ Thể Thông Tin -->
                <div id="profile-dropdown-menu" class="profile-menu glass-card" style="position: absolute; top: calc(100% + 0.5rem); right: 0; width: 260px; padding: 1rem; display: none; flex-direction: column; gap: 0.75rem; border-radius: var(--radius-md); box-shadow: var(--glass-shadow); z-index: 1005;">
                    <div style="border-bottom: 1px solid var(--glass-border); padding-bottom: 0.75rem;">
                        <div style="font-weight: 700; font-size: 0.95rem; color: var(--ios-text);">
                            <?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'N/A') ?>
                        </div>
                        <div style="font-size: 0.75rem; color: var(--ios-text-secondary); margin-top: 0.15rem; word-break: break-all;">
                            <?= htmlspecialchars($_SESSION['email'] ?? 'Chưa cập nhật email') ?>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.4rem; font-size: 0.825rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--ios-text-secondary);">Số dư:</span>
                            <span style="font-weight: 700; color: var(--ios-success);"><?= number_format($_SESSION['balance'] ?? 0, 0, ',', '.') ?> đ</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--ios-text-secondary);">Đăng ký:</span>
                            <span style="font-weight: 500; color: var(--ios-text);"><?= !empty($_SESSION['created_at']) ? date('d/m/Y', strtotime($_SESSION['created_at'])) : 'N/A' ?></span>
                        </div>
                    </div>

                    <div style="border-top: 1px solid var(--glass-border); pt-3; margin-top: 0.25rem; padding-top: 0.75rem;">
                        <a href="/logout" style="display: flex; align-items: center; justify-content: center; gap: 0.4rem; width: 100%; color: var(--ios-danger); text-decoration: none; font-size: 0.85rem; font-weight: 700; padding: 0.5rem; background: rgba(255, 59, 48, 0.1); border-radius: var(--radius-sm); transition: var(--transition);">
                            🚪 Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <a href="/auth/login" style="color: var(--ios-text); text-decoration: none; font-size: 0.85rem; font-weight: 500;">Đăng nhập</a>
            <a href="/auth/register" class="glass-btn" style="padding: 0.45rem 0.85rem; font-size: 0.85rem;">Đăng ký</a>
        <?php endif; ?>
    </div>
</nav>