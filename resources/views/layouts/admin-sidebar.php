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
<aside class="admin-sidebar" style="background: rgba(26, 243, 229, 0.49);">
    <!-- Tên Web đặt trong Sidebar -->
    <div class="sidebar-brand" style="padding: 0.5rem 0.5rem 1rem 0.5rem; border-bottom: 1px solid var(--glass-border); margin-bottom: 0.75rem;">
        <a href="<?= $logoHref ?>" style="display: flex; align-items: center; text-decoration: none; font-weight: 800; font-size: 1.25rem; letter-spacing: 0.6px; background: linear-gradient(135deg, #FFCC00 0%, #FF9500 50%, #FF2D55 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; filter: drop-shadow(0px 2px 10px rgba(255, 149, 0, 0.5));">
            <span>VC VPN 2027</span>
        </a>
    </div>

    <div style="padding: 0.25rem 0.5rem; font-weight: 700; color: var(--ios-text-secondary); font-size: 0.75rem; text-transform: uppercase; letter-spacing: 0.5px;">
        Quản Trị Hệ Thống
    </div>
    <a href="/admin" class="nav-item <?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">📈 Dashboard</a>
    <a href="/admin/users" class="nav-item <?= ($activeMenu ?? '') === 'users' ? 'active' : '' ?>">👥 Người Dùng</a>
    <a href="/admin/server-groups" class="nav-item <?= ($activeMenu ?? '') === 'server-groups' ? 'active' : '' ?>">📁 Nhóm Máy Chủ</a>
    <a href="/admin/servers" class="nav-item <?= ($activeMenu ?? '') === 'servers' ? 'active' : '' ?>">🖥️ Máy Chủ</a>
    <a href="/admin/nodes" class="nav-item <?= ($activeMenu ?? '') === 'nodes' ? 'active' : '' ?>">🌐 Node Inbound</a>
    <a href="/admin/plans" class="nav-item <?= ($activeMenu ?? '') === 'plans' ? 'active' : '' ?>">💎 Gói Cước</a>
    <a href="/admin/coupons" class="nav-item <?= ($activeMenu ?? '') === 'coupons' ? 'active' : '' ?>">🏷️ Mã Giảm Giá</a>
    <a href="/admin/orders" class="nav-item <?= ($activeMenu ?? '') === 'orders' ? 'active' : '' ?>">🧾 Đơn Hàng</a>
    <a href="/admin/payments" class="nav-item <?= ($activeMenu ?? '') === 'payments' ? 'active' : '' ?>">💵 Thanh Toán</a>
    <a href="/admin/subscriptions" class="nav-item <?= ($activeMenu ?? '') === 'subscriptions' ? 'active' : '' ?>">🔑 Đăng Ký VPN</a>
    <a href="/admin/referrals" class="nav-item <?= ($activeMenu ?? '') === 'referrals' ? 'active' : '' ?>">🤝 Hoa Hồng</a>
    <a href="/admin/withdrawals" class="nav-item <?= ($activeMenu ?? '') === 'withdrawals' ? 'active' : '' ?>">🏦 Rút Tiền</a>
    <a href="/admin/posts" class="nav-item <?= ($activeMenu ?? '') === 'posts' ? 'active' : '' ?>">📰 Bài Viết</a>
    <a href="/admin/tickets" class="nav-item <?= ($activeMenu ?? '') === 'tickets' ? 'active' : '' ?>">🎫 Ticket Hỗ Trợ</a>
    <a href="/admin/expenses" class="nav-item <?= ($activeMenu ?? '') === 'expenses' ? 'active' : '' ?>">💸 Chi Phí</a>
    <a href="/admin/settings" class="nav-item <?= ($activeMenu ?? '') === 'settings' ? 'active' : '' ?>">⚙️ Cài Đặt</a>
    <a href="/admin/logs/system" class="nav-item <?= ($activeMenu ?? '') === 'logs' ? 'active' : '' ?>">📝 Logs Hệ Thống</a>
</aside>