<?php
$pageTitle = "Quản Lý Nút Kết Nối - Quản Trị Hệ Thống";
$activeMenu = "nodes";

ob_start();
?>

<div style="margin-bottom: 1.25rem;">
    <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px; margin: 0;">Danh Sách Nút Kết Nối (Inbounds)</h1>
    <p style="font-size: 0.875rem; color: var(--ios-text-secondary); margin: 0.25rem 0 0 0;">Danh sách cổng kết nối và giao thức được đẩy tự động từ các máy chủ VPS</p>
</div>

<?php if (isset($_SESSION['success']) || !empty($_SESSION['flash_message'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-success); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; font-size: 0.9rem; color: var(--ios-success);"><?= htmlspecialchars($_SESSION['success'] ?? $_SESSION['flash_message']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['success'], $_SESSION['flash_message']); ?>
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
                <th style="padding: 0.75rem 0.5rem;">Máy Chủ</th>
                <th style="padding: 0.75rem 0.5rem; text-align: center;">Cổng (Port)</th>
                <th style="padding: 0.75rem 0.5rem;">Giao Thức</th>
                <th style="padding: 0.75rem 0.5rem;">Mạng (Network)</th>
                <th style="padding: 0.75rem 0.5rem; text-align: center;">TLS</th>
                <th style="padding: 0.75rem 0.5rem;">SNI / Host</th>
                <th style="padding: 0.75rem 0.5rem; text-align: center;">Trạng Thái</th>
                <th style="padding: 0.75rem 0.5rem; text-align: right; width: 100px;">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($nodes)): ?>
                <?php foreach ($nodes as $node): ?>
                    <tr style="border-bottom: 1px solid var(--glass-border);">
                        <td style="padding: 0.75rem 0.5rem; font-weight: 700;">#<?= $node['id'] ?></td>
                        <td style="padding: 0.75rem 0.5rem; font-weight: 600; color: var(--ios-text);">
                            <?= htmlspecialchars($node['server_name'] ?? ('Server #' . $node['server_id'])) ?>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; text-align: center; font-family: monospace; font-weight: 700; color: var(--ios-blue);">
                            <?= htmlspecialchars($node['port']) ?>
                        </td>
                        <td style="padding: 0.75rem 0.5rem;">
                            <span style="font-weight: 700; text-transform: uppercase; background: rgba(0, 122, 255, 0.15); color: var(--ios-blue); padding: 0.2rem 0.5rem; border-radius: var(--radius-sm); font-size: 0.8rem;">
                                <?= htmlspecialchars($node['protocol']) ?>
                            </span>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; text-transform: uppercase; font-weight: 600; color: var(--ios-text-secondary);">
                            <?= htmlspecialchars($node['network']) ?>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; text-align: center;">
                            <?php if (!empty($node['tls'])): ?>
                                <span style="color: var(--ios-success); font-weight: 700;">✓ Bật</span>
                            <?php else: ?>
                                <span style="color: var(--ios-text-secondary);">✕ Tắt</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; font-family: monospace; font-size: 0.85rem; color: var(--ios-text-secondary);">
                            <?= htmlspecialchars($node['sni'] ?: ($node['host'] ?: '-')) ?>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; text-align: center;">
                            <?php if (($node['status'] ?? 'active') === 'active'): ?>
                                <span style="background: rgba(52, 199, 89, 0.15); color: var(--ios-success); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">ACTIVE</span>
                            <?php else: ?>
                                <span style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">INACTIVE</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; text-align: right;">
                            <a href="/admin/nodes/detail?id=<?= $node['id'] ?>" style="text-decoration: none; margin-right: 0.5rem;" title="Xem Chi Tiết">🔍</a>
                            <a href="/admin/nodes/delete?id=<?= $node['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa dữ liệu nút kết nối này khỏi hệ thống?');" style="text-decoration: none;" title="Xóa">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="9" style="padding: 2rem; text-align: center; color: var(--ios-text-secondary);">Chưa có nút kết nối nào được đồng bộ từ VPS.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>