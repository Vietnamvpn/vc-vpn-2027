<?php
$pageTitle = "Chi Tiết Nút Kết Nối - Quản Trị Hệ Thống";
$activeMenu = "nodes";

ob_start();
?>

<div style="margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px; margin: 0;">Nút Kết Nối #<?= $node['id'] ?></h1>
        <p style="font-size: 0.875rem; color: var(--ios-text-secondary); margin: 0.25rem 0 0 0;">Cấu hình chi tiết được gửi lên từ máy chủ VPS</p>
    </div>
    <div>
        <a href="/admin/nodes" class="glass-btn" style="text-decoration: none; padding: 0.65rem 1.25rem; font-size: 0.9rem; font-weight: 600;">⬅️ Quay Lại</a>
    </div>
</div>

<div class="glass-card" style="padding: 1.75rem; width: 100%;">
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem;">
        <div>
            <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem;">Thông Tin Máy Chủ VPS</h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <tr>
                    <td style="padding: 0.5rem 0; color: var(--ios-text-secondary); width: 120px;">Máy Chủ:</td>
                    <td style="padding: 0.5rem 0; font-weight: 600;"><?= htmlspecialchars($node['server_name'] ?? ('Server #' . $node['server_id'])) ?></td>
                </tr>
                <tr>
                    <td style="padding: 0.5rem 0; color: var(--ios-text-secondary);">Địa Chỉ IP:</td>
                    <td style="padding: 0.5rem 0; font-family: monospace; color: var(--ios-blue);"><?= htmlspecialchars($node['server_ip'] ?? 'N/A') ?></td>
                </tr>
                <tr>
                    <td style="padding: 0.5rem 0; color: var(--ios-text-secondary);">Vị Trí:</td>
                    <td style="padding: 0.5rem 0;"><?= htmlspecialchars($node['server_location'] ?? 'N/A') ?></td>
                </tr>
            </table>
        </div>

        <div>
            <h3 style="font-size: 1.05rem; font-weight: 700; margin-bottom: 1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem;">Cấu Hình Giao Thức (Inbound)</h3>
            <table style="width: 100%; border-collapse: collapse; font-size: 0.9rem;">
                <tr>
                    <td style="padding: 0.5rem 0; color: var(--ios-text-secondary); width: 120px;">Cổng (Port):</td>
                    <td style="padding: 0.5rem 0; font-family: monospace; font-weight: 700; color: var(--ios-blue);"><?= htmlspecialchars($node['port']) ?></td>
                </tr>
                <tr>
                    <td style="padding: 0.5rem 0; color: var(--ios-text-secondary);">Giao Thức:</td>
                    <td style="padding: 0.5rem 0;"><span style="font-weight: 700; text-transform: uppercase; background: rgba(0, 122, 255, 0.15); color: var(--ios-blue); padding: 0.15rem 0.5rem; border-radius: var(--radius-sm);"><?= htmlspecialchars($node['protocol']) ?></span></td>
                </tr>
                <tr>
                    <td style="padding: 0.5rem 0; color: var(--ios-text-secondary);">Mạng (Network):</td>
                    <td style="padding: 0.5rem 0; text-transform: uppercase; font-weight: 600;"><?= htmlspecialchars($node['network']) ?></td>
                </tr>
                <tr>
                    <td style="padding: 0.5rem 0; color: var(--ios-text-secondary);">Mã Hóa TLS:</td>
                    <td style="padding: 0.5rem 0; font-weight: 600;"><?= !empty($node['tls']) ? '<span style="color: var(--ios-success);">Đã bật</span>' : '<span style="color: var(--ios-text-secondary);">Đã tắt</span>' ?></td>
                </tr>
                <tr>
                    <td style="padding: 0.5rem 0; color: var(--ios-text-secondary);">SNI:</td>
                    <td style="padding: 0.5rem 0; font-family: monospace;"><?= htmlspecialchars($node['sni'] ?: '-') ?></td>
                </tr>
                <tr>
                    <td style="padding: 0.5rem 0; color: var(--ios-text-secondary);">Host:</td>
                    <td style="padding: 0.5rem 0; font-family: monospace;"><?= htmlspecialchars($node['host'] ?: '-') ?></td>
                </tr>
                <tr>
                    <td style="padding: 0.5rem 0; color: var(--ios-text-secondary);">Path:</td>
                    <td style="padding: 0.5rem 0; font-family: monospace;"><?= htmlspecialchars($node['path'] ?: '-') ?></td>
                </tr>
                <tr>
                    <td style="padding: 0.5rem 0; color: var(--ios-text-secondary);">Trạng Thái:</td>
                    <td style="padding: 0.5rem 0;">
                        <?php if (($node['status'] ?? 'active') === 'active'): ?>
                            <span style="background: rgba(52, 199, 89, 0.15); color: var(--ios-success); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">ACTIVE</span>
                        <?php else: ?>
                            <span style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">INACTIVE</span>
                        <?php endif; ?>
                    </td>
                </tr>
            </table>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>