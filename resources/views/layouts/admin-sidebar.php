<aside class="admin-sidebar">
    <div style="padding: 0.5rem 1rem; font-weight: 700; color: var(--ios-text-secondary); font-size: 0.75rem; text-transform: uppercase;">
        Quản Trị Hệ Thống
    </div>
    <a href="/admin/dashboard" class="nav-item <?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">📈 Dashboard</a>
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