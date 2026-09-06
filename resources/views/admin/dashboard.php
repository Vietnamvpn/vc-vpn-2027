<?php
$pageTitle = "Dashboard - Quản Trị Hệ Thống";
$activeMenu = "dashboard";

ob_start();
?>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="glass-card" style="padding: 1rem 1.25rem; margin-bottom: 1rem; border-left: 4px solid var(--ios-blue); display: flex; align-items: center; justify-content: space-between;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<div style="display: flex; flex-direction: column; gap: 0.25rem; margin-bottom: 0.5rem;">
    <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Tổng Quan Hệ Thống</h1>
    <p style="color: var(--ios-text-secondary); font-size: 0.875rem;">Theo dõi chỉ số hoạt động real-time của VPN Service</p>
</div>

<!-- Stats Grid -->
<div class="stats-grid">
    <div class="glass-card stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="title">Tổng Người Dùng</span>
            <span style="font-size: 1.25rem;">👥</span>
        </div>
        <div class="value"><?= number_format($stats['total_users'] ?? 0) ?></div>
        <div style="font-size: 0.8rem; color: var(--ios-success); font-weight: 600;">+<?= number_format($stats['new_users_today'] ?? 0) ?> hôm nay</div>
    </div>

    <div class="glass-card stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="title">Gói Dịch Vụ Active</span>
            <span style="font-size: 1.25rem;">🔑</span>
        </div>
        <div class="value"><?= number_format($stats['active_subscriptions'] ?? 0) ?></div>
        <div style="font-size: 0.8rem; color: var(--ios-text-secondary);">Đang hoạt động</div>
    </div>

    <div class="glass-card stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="title">Doanh Thu Tháng</span>
            <span style="font-size: 1.25rem;">💵</span>
        </div>
        <div class="value" style="color: var(--ios-success);"><?= number_format($stats['monthly_revenue'] ?? 0, 0, ',', '.') ?> đ</div>
        <div style="font-size: 0.8rem; color: var(--ios-text-secondary);">Tổng đơn đã thanh toán</div>
    </div>

    <div class="glass-card stat-card">
        <div style="display: flex; justify-content: space-between; align-items: center;">
            <span class="title">Máy Chủ Online</span>
            <span style="font-size: 1.25rem;">🖥️</span>
        </div>
        <div class="value" style="color: var(--ios-blue);"><?= ($stats['active_servers'] ?? 0) ?> / <?= ($stats['total_servers'] ?? 0) ?></div>
        <div style="font-size: 0.8rem; color: var(--ios-success); font-weight: 600;">Hoạt động ổn định</div>
    </div>
</div>

<!-- Layout 2 Cột Responsive -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem; align-items: start;">
    <!-- Đơn Hàng Mới -->
    <div class="glass-card" style="padding: 1.25rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h2 style="font-size: 1.1rem; font-weight: 700;">Đơn Hàng Gần Đây</h2>
            <a href="/admin/orders" style="font-size: 0.85rem; color: var(--ios-blue); text-decoration: none; font-weight: 600;">Xem tất cả &rarr;</a>
        </div>
        <div class="table-responsive">
            <table class="glass-table">
                <thead>
                    <tr>
                        <th>Mã Đơn</th>
                        <th>Khách Hàng</th>
                        <th>Số Tiền</th>
                        <th>Trạng Thái</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (!empty($recentOrders)): ?>
                        <?php foreach ($recentOrders as $order): ?>
                            <tr>
                                <td style="font-weight: 600;">#<?= htmlspecialchars($order['order_code']) ?></td>
                                <td><?= htmlspecialchars($order['username'] ?? 'N/A') ?></td>
                                <td style="font-weight: 600;"><?= number_format($order['total_amount'], 0, ',', '.') ?> đ</td>
                                <td>
                                    <?php
                                    $statusStyle = [
                                        'completed' => 'background: rgba(52, 199, 89, 0.15); color: var(--ios-success);',
                                        'pending' => 'background: rgba(255, 149, 0, 0.15); color: var(--ios-warning);',
                                        'failed' => 'background: rgba(255, 59, 48, 0.15); color: var(--ios-danger);',
                                        'cancelled' => 'background: rgba(142, 142, 147, 0.15); color: var(--ios-text-secondary);'
                                    ];
                                    ?>
                                    <span style="padding: 0.25rem 0.6rem; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 700; <?= $statusStyle[$order['payment_status']] ?? '' ?>">
                                        <?= strtoupper($order['payment_status']) ?>
                                    </span>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else: ?>
                        <tr><td colspan="4" style="text-align: center; color: var(--ios-text-secondary);">Chưa có đơn hàng mới</td></tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- Trạng Thái Máy Chủ -->
    <div class="glass-card" style="padding: 1.25rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
            <h2 style="font-size: 1.1rem; font-weight: 700;">Hạ Tầng VPN</h2>
            <a href="/admin/servers" style="font-size: 0.85rem; color: var(--ios-blue); text-decoration: none; font-weight: 600;">Quản lý</a>
        </div>
        <div style="display: flex; flex-direction: column; gap: 0.75rem;">
            <?php if (!empty($servers)): ?>
                <?php foreach ($servers as $server): ?>
                    <div style="display: flex; justify-content: space-between; align-items: center; padding: 0.75rem 1rem; background: rgba(255, 255, 255, 0.2); border: 1px solid var(--glass-border); border-radius: var(--radius-md);">
                        <div>
                            <div style="font-weight: 600; font-size: 0.9rem;"><?= htmlspecialchars($server['name']) ?></div>
                            <div style="font-size: 0.75rem; color: var(--ios-text-secondary);"><?= htmlspecialchars($server['ip_address']) ?> (<?= htmlspecialchars($server['location']) ?>)</div>
                        </div>
                        <span style="height: 10px; width: 10px; border-radius: 50%; background-color: <?= $server['status'] === 'active' ? 'var(--ios-success)' : 'var(--ios-danger)' ?>; box-shadow: 0 0 8px <?= $server['status'] === 'active' ? 'var(--ios-success)' : 'var(--ios-danger)' ?>;"></span>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <div style="text-align: center; color: var(--ios-text-secondary); padding: 1rem;">Chưa có máy chủ nào</div>
            <?php endif; ?>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>