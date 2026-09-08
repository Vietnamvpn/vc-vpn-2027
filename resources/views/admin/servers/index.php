<?php
$pageTitle = "Quản Lý Máy Chủ - Quản Trị Hệ Thống";
$activeMenu = "servers";

ob_start();
?>

<div style="margin-bottom: 0.75rem;">
    <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px; margin: 0;">Danh Sách Máy Chủ</h1>
    <p style="font-size: 0.875rem; color: var(--ios-text-secondary); margin: 0.25rem 0 0 0;">Quản lý hạ tầng máy chủ và thông số API kết nối</p>
</div>

<div style="margin-bottom: 1.25rem; display: flex; justify-content: flex-end;">
    <a href="/admin/servers/create" class="glass-btn" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600; padding: 0.65rem 1.25rem; font-size: 0.9rem;">
        ➕ Thêm Máy Chủ Mới
    </a>
</div>

<?php if (isset($_SESSION['success'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-success); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; font-size: 0.9rem; color: var(--ios-success);"><?= htmlspecialchars($_SESSION['success']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['success']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-danger); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; font-size: 0.9rem; color: var(--ios-danger);"><?= htmlspecialchars($_SESSION['error']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div class="glass-card" style="padding: 1.25rem; overflow-x: auto;">
    <table class="glass-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
        <thead>
            <tr style="border-bottom: 1px solid var(--glass-border); color: var(--ios-text-secondary);">
                <th style="padding: 0.75rem 0.5rem; width: 60px;">ID</th>
                <th style="padding: 0.75rem 0.5rem;">Tên Máy Chủ</th>
                <th style="padding: 0.75rem 0.5rem;">Nhóm</th>
                <th style="padding: 0.75rem 0.5rem;">Quốc Gia</th>
                <th style="padding: 0.75rem 0.5rem;">Vị Trí</th>
                <th style="padding: 0.75rem 0.5rem;">IP Address</th>
                <th style="padding: 0.75rem 0.5rem; text-align: center;">API Port</th>
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
                        <td style="padding: 0.75rem 0.5rem; color: var(--ios-text-secondary);"><?= htmlspecialchars($server['group_name'] ?? 'Chưa phân nhóm') ?></td>
                        <td style="padding: 0.75rem 0.5rem;">
                            <span style="font-weight: 700; text-transform: uppercase; background: rgba(0, 122, 255, 0.1); color: var(--ios-blue); padding: 0.2rem 0.4rem; border-radius: var(--radius-sm);">
                                <?= htmlspecialchars($server['country_code']) ?>
                            </span>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; color: var(--ios-text);"><?= htmlspecialchars($server['location']) ?></td>
                        <td style="padding: 0.75rem 0.5rem; font-family: monospace; color: var(--ios-blue);"><?= htmlspecialchars($server['ip_address']) ?></td>
                        <td style="padding: 0.75rem 0.5rem; text-align: center; font-weight: 600;"><?= htmlspecialchars($server['api_port']) ?></td>
                        <td style="padding: 0.75rem 0.5rem; text-align: center;">
                            <?php if (($server['status'] ?? 'active') === 'active'): ?>
                                <span style="background: rgba(52, 199, 89, 0.15); color: var(--ios-success); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">ACTIVE</span>
                            <?php elseif (($server['status'] ?? '') === 'maintenance'): ?>
                                <span style="background: rgba(255, 149, 0, 0.15); color: var(--ios-warning); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">MAINTENANCE</span>
                            <?php else: ?>
                                <span style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">OFFLINE</span>
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
                    <td colspan="9" style="padding: 2rem; text-align: center; color: var(--ios-text-secondary);">Chưa có máy chủ nào được khởi tạo.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>