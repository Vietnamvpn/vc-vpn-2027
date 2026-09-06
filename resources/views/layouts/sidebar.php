<?php
$currentUri = $_SERVER['REQUEST_URI'] ?? '';
$isAdminRoute = (strncmp($currentUri, '/admin', 6) === 0);
$userRole = $_SESSION['role'] ?? 'user';

$logoHref = '/';
if (isset($_SESSION['user_id'])) {
    if ($userRole === 'admin') {
        $logoHref = $isAdminRoute ? '/dashboard' : '/admin';
    } else {
        $logoHref = '/dashboard';
    }
}
?>
<aside class="admin-sidebar">
    <!-- Logo & Tên Web đặt trong Sidebar -->
    <div class="sidebar-brand" style="padding: 0.5rem 0.5rem 1rem 0.5rem; border-bottom: 1px solid var(--glass-border); margin-bottom: 0.75rem;">
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

    <div style="padding: 0.25rem 0.5rem; font-weight: 700; color: var(--ios-text-secondary); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
        Menu Khách Hàng
    </div>
    <a href="/dashboard" class="nav-item <?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">
        <span>📊 Dashboard</span>
    </a>
    <a href="/user/plans" class="nav-item <?= ($activeMenu ?? '') === 'plans' ? 'active' : '' ?>">
        <span>📦 Gói Dịch Vụ</span>
    </a>
    <a href="/subscriptions" class="nav-item <?= ($activeMenu ?? '') === 'subscriptions' ? 'active' : '' ?>">
        <span>⚡ Gói Đã Mua</span>
    </a>
    <a href="/orders" class="nav-item <?= ($activeMenu ?? '') === 'orders' ? 'active' : '' ?>">
        <span>🛒 Đơn Hàng</span>
    </a>
    <a href="/payments" class="nav-item <?= ($activeMenu ?? '') === 'payments' ? 'active' : '' ?>">
        <span>💳 Lịch Sử Giao Dịch</span>
    </a>
    <a href="/wallet" class="nav-item <?= ($activeMenu ?? '') === 'wallet' ? 'active' : '' ?>">
        <span>💰 Ví Tiền</span>
    </a>
    <a href="/referrals" class="nav-item <?= ($activeMenu ?? '') === 'referrals' ? 'active' : '' ?>">
        <span>🎁 Tiếp Thị Liên Kết</span>
    </a>
    <a href="/tickets" class="nav-item <?= ($activeMenu ?? '') === 'tickets' ? 'active' : '' ?>">
        <span>🎧 Hỗ Trợ</span>
    </a>
    <a href="/profile" class="nav-item <?= ($activeMenu ?? '') === 'profile' ? 'active' : '' ?>">
        <span>👤 Tài Khoản</span>
    </a>
</aside>