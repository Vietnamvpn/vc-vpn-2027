<?php
$pageTitle = "Chi Tiết Máy Chủ - Quản Trị Hệ Thống";
$activeMenu = "servers";

ob_start();
?>

<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 0.75rem; flex-wrap: wrap;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; word-break: break-word; margin: 0;">Máy Chủ: <?= htmlspecialchars($server['name'] ?? 'N/A') ?></h1>
    </div>
    <div style="display: flex; gap: 0.5rem;">
        <a href="/admin/servers/edit?id=<?= $server['id'] ?>" class="glass-btn" style="text-decoration: none; font-weight: 600;">✏️ Chỉnh Sửa</a>
        <a href="/admin/servers" class="glass-btn" style="text-decoration: none; font-weight: 600;">⬅️ Quay Lại</a>
    </div>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.25rem;">
    <!-- Thẻ Thông Tin Tổng Quan -->
    <div class="glass-card" style="padding: 1.25rem;">
        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.75rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem;">Thông Tin Tổng Quan</h2>
        
        <div style="display: flex; flex-direction: column; gap: 0.65rem; font-size: 0.9rem;">
            <div><strong>ID Máy Chủ:</strong> #<?= $server['id'] ?></div>
            <div><strong>Tên Máy Chủ:</strong> <?= htmlspecialchars($server['name'] ?? 'N/A') ?></div>
            <div><strong>Nhóm Máy Chủ:</strong> <?= htmlspecialchars($server['group_name'] ?? 'Chưa phân nhóm') ?></div>
            <div>
                <strong>Trạng Thái:</strong> 
                <?php if (($server['status'] ?? 'active') === 'active'): ?>
                    <span style="background: rgba(52, 199, 89, 0.15); color: var(--ios-success); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: 700;">ACTIVE</span>
                <?php elseif (($server['status'] ?? '') === 'maintenance'): ?>
                    <span style="background: rgba(255, 149, 0, 0.15); color: var(--ios-warning); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: 700;">BẢO TRÌ</span>
                <?php else: ?>
                    <span style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.8rem; font-weight: 700;">INACTIVE</span>
                <?php endif; ?>
            </div>
            <div><strong>Ngày Tạo:</strong> <?= !empty($server['created_at']) ? date('d/m/Y H:i:s', strtotime($server['created_at'])) : 'N/A' ?></div>
            <div><strong>Cập Nhật Cuối:</strong> <?= !empty($server['updated_at']) ? date('d/m/Y H:i:s', strtotime($server['updated_at'])) : 'Chưa cập nhật' ?></div>
        </div>
    </div>

    <!-- Thẻ Thông Số Kỹ Thuật -->
    <div class="glass-card" style="padding: 1.25rem;">
        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.75rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem;">Cấu Hình & Kết Nối</h2>
        
        <div style="display: flex; flex-direction: column; gap: 0.65rem; font-size: 0.9rem;">
            <div><strong>Địa Chỉ IP / Domain:</strong> <code style="background: rgba(0,122,255,0.1); color: var(--ios-blue); padding: 0.2rem 0.4rem; border-radius: var(--radius-sm); font-weight: 700;"><?= htmlspecialchars($server['ip_address'] ?? 'N/A') ?></code></div>
            <div><strong>Cổng Kết Nối (Port):</strong> <span style="font-weight: 700;"><?= htmlspecialchars($server['port'] ?? '443') ?></span></div>
            <div><strong>Hệ Số Tính Dung Lượng:</strong> <span style="font-weight: 700; color: var(--ios-blue);">x<?= htmlspecialchars($server['rate'] ?? '1.0') ?></span></div>
            <div><strong>Giao Thức Tích Hợp:</strong> <span style="font-weight: 700; text-transform: uppercase;"><?= htmlspecialchars($server['type'] ?? 'Sing-Box') ?></span></div>
            <div>
                <strong>Ghi Chú / Mô Tả:</strong>
                <p style="margin: 0.25rem 0 0 0; color: var(--ios-text-secondary); background: rgba(255,255,255,0.03); padding: 0.5rem; border-radius: var(--radius-sm); border: 1px solid var(--glass-border);">
                    <?= !empty($server['description']) ? nl2br(htmlspecialchars($server['description'])) : 'Không có ghi chú nào.' ?>
                </p>
            </div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>