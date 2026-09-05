<aside class="admin-sidebar" style="border-radius: var(--radius-lg);">
    <div style="padding: 0.5rem 1rem; font-weight: 700; color: var(--ios-text-secondary); font-size: 0.75rem; text-transform: uppercase;">
        Menu Khách Hàng
    </div>
    <a href="/user/dashboard" class="nav-item <?= ($activeMenu ?? '') === 'dashboard' ? 'active' : '' ?>">
        <span>📊 Dashboard</span>
    </a>
    <a href="/user/plans" class="nav-item <?= ($activeMenu ?? '') === 'plans' ? 'active' : '' ?>">
        <span>📦 Gói Dịch Vụ</span>
    </a>
    <a href="/user/subscriptions" class="nav-item <?= ($activeMenu ?? '') === 'subscriptions' ? 'active' : '' ?>">
        <span>⚡ Gói Đã Mua</span>
    </a>
    <a href="/user/orders" class="nav-item <?= ($activeMenu ?? '') === 'orders' ? 'active' : '' ?>">
        <span>🛒 Đơn Hàng</span>
    </a>
    <a href="/user/payments" class="nav-item <?= ($activeMenu ?? '') === 'payments' ? 'active' : '' ?>">
        <span>💳 Lịch Sử Giao Dịch</span>
    </a>
    <a href="/user/wallet" class="nav-item <?= ($activeMenu ?? '') === 'wallet' ? 'active' : '' ?>">
        <span>💰 Ví Tiền</span>
    </a>
    <a href="/user/referrals" class="nav-item <?= ($activeMenu ?? '') === 'referrals' ? 'active' : '' ?>">
        <span>🎁 Tiếp Thị Liên Kết</span>
    </a>
    <a href="/user/tickets" class="nav-item <?= ($activeMenu ?? '') === 'tickets' ? 'active' : '' ?>">
        <span>🎧 Hỗ Trợ</span>
    </a>
    <a href="/user/profile" class="nav-item <?= ($activeMenu ?? '') === 'profile' ? 'active' : '' ?>">
        <span>👤 Tài Khoản</span>
    </a>
</aside>