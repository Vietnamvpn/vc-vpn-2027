<?php
$currentUri = $_SERVER['REQUEST_URI'] ?? '';
$isAdminRoute = (strncmp($currentUri, '/admin', 6) === 0);
$userRole = $_SESSION['role'] ?? 'user';
$siteTitle = $settings['site_title'] ?? 'VC VPN 2027';
$activeMenuKey = $activeMenu ?? '';

$menuGroups = [
    'commerce' => [
        'icon'  => '💳',
        'label' => 'Kinh doanh',
        'items' => [
            ['key' => 'users', 'href' => '/admin/users', 'icon' => '👥', 'label' => 'Người Dùng'],
            ['key' => 'plans', 'href' => '/admin/plans', 'icon' => '💎', 'label' => 'Gói Cước'],
            ['key' => 'coupons', 'href' => '/admin/coupons', 'icon' => '🏷️', 'label' => 'Mã Giảm Giá'],
            ['key' => 'orders', 'href' => '/admin/orders', 'icon' => '🧾', 'label' => 'Đơn Hàng'],
            ['key' => 'payments', 'href' => '/admin/payments', 'icon' => '💵', 'label' => 'Thanh Toán'],
            ['key' => 'subscriptions', 'href' => '/admin/subscriptions', 'icon' => '🔑', 'label' => 'Đăng Ký VPN']
        ]
    ],
    'finance' => [
        'icon'  => '💰',
        'label' => 'Tài chính',
        'items' => [
            ['key' => 'referrals', 'href' => '/admin/referrals', 'icon' => '🤝', 'label' => 'Hoa Hồng'],
            ['key' => 'withdrawals', 'href' => '/admin/withdrawals', 'icon' => '🏦', 'label' => 'Rút Tiền'],
            ['key' => 'expenses', 'href' => '/admin/expenses', 'icon' => '💸', 'label' => 'Chi Phí']
        ]
    ],
    'infrastructure' => [
        'icon'  => '🖥️',
        'label' => 'Hạ tầng VPN',
        'items' => [
            ['key' => 'server-groups', 'href' => '/admin/server-groups', 'icon' => '📁', 'label' => 'Nhóm Máy Chủ'],
            ['key' => 'servers', 'href' => '/admin/servers', 'icon' => '🖥️', 'label' => 'Máy Chủ'],
            ['key' => 'nodes', 'href' => '/admin/nodes', 'icon' => '🌐', 'label' => 'Node Inbound']
        ]
    ],
    'content-support' => [
        'icon'  => '🗂️',
        'label' => 'Nội dung & Hỗ trợ',
        'items' => [
            ['key' => 'posts', 'href' => '/admin/posts', 'icon' => '📰', 'label' => 'Bài Viết'],
            ['key' => 'tickets', 'href' => '/admin/tickets', 'icon' => '🎫', 'label' => 'Ticket Hỗ Trợ']
        ]
    ],
    'system' => [
        'icon'  => '⚙️',
        'label' => 'Hệ thống',
        'items' => [
            ['key' => 'settings', 'href' => '/admin/settings', 'icon' => '⚙️', 'label' => 'Cài Đặt'],
            ['key' => 'logs', 'href' => '/admin/logs', 'icon' => '📝', 'label' => 'Nhật Ký Hệ Thống']
        ]
    ]
];

$logoHref = '/';
if (isset($_SESSION['user_id'])) {
    if ($userRole === 'admin') {
        $logoHref = $isAdminRoute ? '/dashboard' : '/admin';
    } else {
        $logoHref = '/dashboard';
    }
}
?>
<aside class="admin-sidebar" style="background: rgba(180, 187, 213, 0.49);">
    <!-- Tên Web đặt trong Sidebar -->
    <div class="sidebar-brand" style="padding: 0.5rem 0.5rem 1rem 0.5rem; border-bottom: 1px solid var(--glass-border); margin-bottom: 0.75rem;">
        <a href="<?= $logoHref ?>" style="display: flex; align-items: center; text-decoration: none; font-weight: 800; font-size: 1.25rem; letter-spacing: 0.6px; background: linear-gradient(135deg, #FFCC00 0%, #FF9500 50%, #FF2D55 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent; filter: drop-shadow(0px 2px 10px rgba(255, 149, 0, 0.5));">
            <span><?= htmlspecialchars($siteTitle) ?></span>
        </a>
    </div>

    <div class="sidebar-section-label">
        Quản Trị Hệ Thống
    </div>
    <nav class="sidebar-navigation" aria-label="Điều hướng quản trị">
        <a href="/admin" class="nav-item sidebar-dashboard <?= $activeMenuKey === 'dashboard' ? 'active' : '' ?>" <?= $activeMenuKey === 'dashboard' ? 'aria-current="page"' : '' ?>>📈 Dashboard</a>

        <?php foreach ($menuGroups as $groupKey => $group): ?>
            <?php
            $groupMenuKeys = array_column($group['items'], 'key');
            $isGroupActive = in_array($activeMenuKey, $groupMenuKeys, true);
            ?>
            <details class="sidebar-nav-group" <?= $isGroupActive ? 'open' : '' ?> data-sidebar-group="<?= htmlspecialchars($groupKey) ?>">
                <summary class="sidebar-nav-group-toggle">
                    <span><?= $group['icon'] ?> <?= htmlspecialchars($group['label']) ?></span>
                    <span class="sidebar-nav-group-arrow" aria-hidden="true">⌄</span>
                </summary>
                <div class="sidebar-nav-group-items">
                    <?php foreach ($group['items'] as $item): ?>
                        <?php $isItemActive = $activeMenuKey === $item['key']; ?>
                        <a href="<?= $item['href'] ?>" class="nav-item <?= $isItemActive ? 'active' : '' ?>" <?= $isItemActive ? 'aria-current="page"' : '' ?>>
                            <?= $item['icon'] ?> <?= htmlspecialchars($item['label']) ?>
                        </a>
                    <?php endforeach; ?>
                </div>
            </details>
        <?php endforeach; ?>
    </nav>
</aside>

<script>
document.querySelectorAll('.sidebar-nav-group').forEach(function (group) {
    group.addEventListener('toggle', function () {
        if (!group.open) {
            return;
        }

        document.querySelectorAll('.sidebar-nav-group').forEach(function (otherGroup) {
            if (otherGroup !== group) {
                otherGroup.open = false;
            }
        });
    });
});
</script>
