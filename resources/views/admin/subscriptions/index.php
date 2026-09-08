<?php
$pageTitle = "Quản Lý Gói Đăng Ký - Quản Trị Hệ Thống";
$activeMenu = "subscriptions";

ob_start();
?>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1rem; border-left: 4px solid <?= ($_SESSION['flash_type'] ?? '') === 'success' ? 'var(--ios-success)' : 'var(--ios-danger)' ?>; display: flex; justify-content: space-between; align-items: center; width: 100%; box-sizing: border-box;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1rem; border-left: 4px solid var(--ios-danger); display: flex; justify-content: space-between; align-items: center; width: 100%; box-sizing: border-box;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['error']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div style="margin-bottom: 1rem; width: 100%; box-sizing: border-box;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; word-break: break-word;">Quản Lý Gói Đăng Ký VPN</h1>
        <p style="color: var(--ios-text-secondary); font-size: 0.85rem;">Danh sách tài khoản VPN đang kích hoạt và theo dõi lưu lượng kết nối</p>
    </div>
</div>

<!-- Bảng Đăng Ký VPN -->
<div class="glass-card" style="padding: 1.25rem; width: 100%; box-sizing: border-box;">
    <div class="table-responsive">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách Hàng</th>
                    <th>Gói Cước</th>
                    <th>UUID / Token</th>
                    <th>Lưu Lượng Dùng</th>
                    <th>Ngày Bắt Đầu</th>
                    <th>Ngày Hết Hạn</th>
                    <th style="text-align: center;">Trạng Thái</th>
                    <th style="text-align: right;">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($subscriptions)): ?>
                    <?php foreach ($subscriptions as $sub): ?>
                        <?php
                        $usedBytes = ($sub['upload'] ?? 0) + ($sub['download'] ?? 0);
                        $usedGB = round($usedBytes / (1024 * 1024 * 1024), 2);
                        $totalGB = round(($sub['transfer_enable'] ?? 0) / (1024 * 1024 * 1024), 2);
                        ?>
                        <tr>
                            <td style="font-weight: 700;">#<?= $sub['id'] ?></td>
                            <td>
                                <div style="font-weight: 700; font-size: 0.85rem;"><?= htmlspecialchars($sub['username'] ?? 'N/A') ?></div>
                                <div style="font-size: 0.78rem; color: var(--ios-text-secondary);"><?= htmlspecialchars($sub['email'] ?? '') ?></div>
                            </td>
                            <td style="font-weight: 600; font-size: 0.85rem; color: var(--ios-text);">
                                <?= htmlspecialchars($sub['plan_name'] ?? ('Gói #' . $sub['plan_id'])) ?>
                            </td>
                            <td>
                                <code style="background: rgba(0, 122, 255, 0.08); padding: 0.15rem 0.4rem; border-radius: var(--radius-sm); font-size: 0.78rem; font-family: monospace; color: var(--ios-blue);">
                                    <?= htmlspecialchars(substr($sub['uuid'], 0, 13)) ?>...
                                </code>
                            </td>
                            <td style="font-size: 0.85rem;">
                                <span style="font-weight: 700; color: var(--ios-blue);"><?= $usedGB ?> GB</span>
                                <span style="color: var(--ios-text-secondary);">/ <?= $totalGB > 0 ? $totalGB . ' GB' : '∞' ?></span>
                            </td>
                            <td style="font-size: 0.8rem; color: var(--ios-text-secondary);">
                                <?= date('d/m/Y', strtotime($sub['start_date'])) ?>
                            </td>
                            <td style="font-size: 0.8rem; color: var(--ios-text-secondary);">
                                <?= date('d/m/Y', strtotime($sub['end_date'])) ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                $statusBadge = [
                                    'active'    => 'background: rgba(52, 199, 89, 0.15); color: var(--ios-success);',
                                    'expired'   => 'background: rgba(255, 149, 0, 0.15); color: var(--ios-warning);',
                                    'suspended' => 'background: rgba(255, 59, 48, 0.15); color: var(--ios-danger);',
                                    'cancelled' => 'background: rgba(142, 142, 147, 0.15); color: var(--ios-text-secondary);'
                                ];
                                ?>
                                <span style="padding: 0.2rem 0.5rem; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 700; <?= $statusBadge[$sub['status'] ?? 'active'] ?? '' ?>">
                                    <?= strtoupper($sub['status'] ?? 'active') ?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div class="action-dropdown">
                                    <button type="button" class="action-btn" title="Thao tác">⋮</button>
                                    <div class="action-menu">
                                        <a href="/admin/subscriptions/detail?id=<?= $sub['id'] ?>" class="action-item">
                                            <span>👁️</span> Xem chi tiết
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 2rem; color: var(--ios-text-secondary);">Chưa có tài khoản đăng ký VPN nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>