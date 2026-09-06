<?php
$pageTitle = "Chi Tiết Người Dùng - Admin";
$activeMenu = "users";

ob_start();
?>

<div style="display: flex; flex-direction: column; gap: 1.5rem;">
    <div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem;">
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Hồ Sơ: <?= htmlspecialchars($user['username'] ?? '') ?></h1>
            <p style="color: var(--ios-text-secondary); font-size: 0.875rem;">Đăng ký lúc: <?= date('d/m/Y H:i', strtotime($user['created_at'])) ?></p>
        </div>
        <div>
            <a href="/admin/users/edit?id=<?= $user['id'] ?>" class="glass-btn" style="background: var(--ios-success); border: none; font-size: 0.875rem; padding: 0.6rem 1rem; margin-right: 0.5rem;">Sửa Tài Khoản</a>
            <a href="/admin/users" style="color: var(--ios-text-secondary); text-decoration: none; font-size: 0.875rem;">&larr; Quay lại</a>
        </div>
    </div>

    <!-- Stats Cards Grid -->
    <div class="stats-grid">
        <div class="glass-card stat-card">
            <span class="title">Số Dư Chính</span>
            <div class="value" style="color: var(--ios-success);"><?= number_format($user['balance'] ?? 0, 0, ',', '.') ?> đ</div>
        </div>

        <div class="glass-card stat-card">
            <span class="title">Ví Hoa Hồng</span>
            <div class="value" style="color: var(--ios-warning);"><?= number_format($user['commission_balance'] ?? 0, 0, ',', '.') ?> đ</div>
        </div>

        <div class="glass-card stat-card">
            <span class="title">Mã Giới Thiệu</span>
            <div class="value" style="color: var(--ios-blue); font-size: 1.4rem;"><?= htmlspecialchars($user['ref_code'] ?? 'Chưa tạo') ?></div>
        </div>

        <div class="glass-card stat-card">
            <span class="title">IP Đăng Nhập Cuối</span>
            <div class="value" style="font-size: 1.2rem; word-break: break-all;"><?= htmlspecialchars($user['last_login_ip'] ?? 'N/A') ?></div>
        </div>
    </div>

    <!-- Multi-Column Layout -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(320px, 1fr)); gap: 1.5rem;">
        <!-- Subscriptions Card -->
        <div class="glass-card" style="padding: 1.25rem;">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">Gói VPN Đang Đăng Ký</h2>
            <div class="table-responsive">
                <table class="glass-table">
                    <thead>
                        <tr>
                            <th>Gói</th>
                            <th>Dung Lượng</th>
                            <th>Hạn Dùng</th>
                            <th>Trạng Thái</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($subscriptions)): ?>
                            <?php foreach ($subscriptions as $sub): ?>
                                <tr>
                                    <td style="font-weight: 600;"><?= htmlspecialchars($sub['plan_name'] ?? 'N/A') ?></td>
                                    <td><?= round(($sub['upload'] + $sub['download']) / (1024*1024*1024), 2) ?> GB</td>
                                    <td><?= date('d/m/Y', strtotime($sub['end_date'])) ?></td>
                                    <td><span style="color: var(--ios-success); font-weight: 700;"><?= strtoupper($sub['status']) ?></span></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" style="text-align: center; color: var(--ios-text-secondary);">Chưa đăng ký gói cước nào</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>

        <!-- Orders Card -->
        <div class="glass-card" style="padding: 1.25rem;">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem;">Lịch Sử Đơn Hàng</h2>
            <div class="table-responsive">
                <table class="glass-table">
                    <thead>
                        <tr>
                            <th>Mã Đơn</th>
                            <th>Tổng Tiền</th>
                            <th>Trạng Thái</th>
                            <th>Ngày Tạo</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($orders)): ?>
                            <?php foreach ($orders as $ord): ?>
                                <tr>
                                    <td style="font-weight: 600;">#<?= htmlspecialchars($ord['order_code']) ?></td>
                                    <td style="font-weight: 600;"><?= number_format($ord['total_amount'], 0, ',', '.') ?> đ</td>
                                    <td><?= strtoupper($ord['payment_status']) ?></td>
                                    <td style="color: var(--ios-text-secondary); font-size: 0.8rem;"><?= date('d/m/Y H:i', strtotime($ord['created_at'])) ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr><td colspan="4" style="text-align: center; color: var(--ios-text-secondary);">Chưa có đơn hàng nào</td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>