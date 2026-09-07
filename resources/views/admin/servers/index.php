<?php
$pageTitle = "Quản Lý Máy Chủ - Quản Trị Hệ Thống";
$activeMenu = "servers";

ob_start();
?>

<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem; flex-wrap: wrap;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Danh Sách Máy Chủ</h1>
        <p style="font-size: 0.875rem; color: var(--ios-text-secondary); margin: 0.25rem 0 0 0;">Quản lý các máy chủ VPN và thông số kỹ thuật trong hệ thống</p>
    </div>
    <a href="/admin/servers/create" class="glass-btn" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600;">
        ➕ Thêm Máy Chủ Mới
    </a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div style="background: rgba(52, 199, 89, 0.15); color: var(--ios-success); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.875rem; border: 1px solid rgba(52, 199, 89, 0.3); margin-bottom: 1.25rem;">
        <?= htmlspecialchars($_SESSION['success']) ?>
    </div>
    <?php unset($_SESSION['success']); ?>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.875rem; border: 1px solid rgba(255, 59, 48, 0.3); margin-bottom: 1.25rem;">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="glass-card" style="padding: 1.25rem; overflow-x: auto;">
    <table class="glass-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
        <thead>
            <tr style="border-bottom: 1px solid var(--glass-border); color: var(--ios-text-secondary);">
                <th style="padding: 0.75rem 0.5rem; width: 60px;">ID</th>
                <th style="padding: 0.75rem 0.5rem;">Tên Máy Chủ</th>
                <th style="padding: 0.75rem 0.5rem;">Nhóm</th>
                <th style="padding: 0.75rem 0.5rem;">IP / Domain</th>
                <th style="padding: 0.75rem 0.5rem; text-align: center;">Cổng</th>
                <th style="padding: 0.75rem 0.5rem; text-align: center;">Hệ Số</th>
                <th style="padding: 0.75rem 0.5rem; text-align: center;">Trạng Thái</th>
                <th style="padding: 0.75rem 0.5rem; text-align: right; width: 140px;">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($servers)): ?>
                <?php foreach ($servers as $server): ?>
                    <tr style="border-bottom: 1px solid var(--glass-border);">
                        <td style="padding: 0.75rem 0.5rem; font-weight: 700;">#<?= $server['id'] ?></td>
                        <td style="padding: 0.75rem 0.5rem; font-weight: 600; color: var(--ios-text);"><?= htmlspecialchars($server['name']) ?></td>
                        <td style="padding: 0.75rem 0.5rem; color: var(--ios-text-secondary);"><?= htmlspecialchars($server['group_name'] ?? 'Mặc định') ?></td>
                        <td style="padding: 0.75rem 0.5rem; font-family: monospace; color: var(--ios-blue);"><?= htmlspecialchars($server['ip_address'] ?? 'N/A') ?></td>
                        <td style="padding: 0.75rem 0.5rem; text-align: center; font-weight: 600;"><?= htmlspecialchars($server['port'] ?? '443') ?></td>
                        <td style="padding: 0.75rem 0.5rem; text-align: center;">
                            <span style="background: rgba(0, 122, 255, 0.1); color: var(--ios-blue); padding: 0.2rem 0.5rem; border-radius: var(--radius-sm); font-weight: 700; font-size: 0.8rem;">
                                x<?= htmlspecialchars($server['rate'] ?? '1.0') ?>
                            </span>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; text-align: center;">
                            <?php if (($server['status'] ?? 'active') === 'active'): ?>
                                <span style="background: rgba(52, 199, 89, 0.15); color: var(--ios-success); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">ACTIVE</span>
                            <?php elseif (($server['status'] ?? '') === 'maintenance'): ?>
                                <span style="background: rgba(255, 149, 0, 0.15); color: var(--ios-warning); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">BAO TRI</span>
                            <?php else: ?>
                                <span style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">INACTIVE</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; text-align: right;">
                            <a href="/admin/servers/detail?id=<?= $server['id'] ?>" style="text-decoration: none; margin-right: 0.4rem;" title="Xem Chi Tiết">🔍</a>
                            <a href="/admin/servers/edit?id=<?= $server['id'] ?>" style="text-decoration: none; margin-right: 0.4rem;" title="Chỉnh Sửa">✏️</a>
                            <a href="/admin/servers/delete?id=<?= $server['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa máy chủ này?');" style="text-decoration: none;" title="Xóa">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="8" style="padding: 2rem; text-align: center; color: var(--ios-text-secondary);">Chưa có máy chủ nào được khởi tạo.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>