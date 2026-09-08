<?php
$pageTitle = "Quản Lý Nhóm Máy Chủ - Quản Trị Hệ Thống";
$activeMenu = "server-groups";

ob_start();
?>

<div style="margin-bottom: 0.75rem;">
    <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px; margin: 0;">Nhóm Máy Chủ</h1>
    <p style="font-size: 0.875rem; color: var(--ios-text-secondary); margin: 0.25rem 0 0 0;">Quản lý và phân loại các cụm server cho người dùng</p>
</div>

<div style="margin-bottom: 1.25rem; display: flex; justify-content: flex-end;">
    <a href="/admin/server-groups/create" class="glass-btn" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600; padding: 0.65rem 1.25rem; font-size: 0.9rem;">
        ➕ Thêm Nhóm Mới
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
                <th style="padding: 0.75rem 0.5rem;">Tên Nhóm</th>
                <th style="padding: 0.75rem 0.5rem;">Mô Tả</th>
                <th style="padding: 0.75rem 0.5rem; text-align: center;">Trạng Thái</th>
                <th style="padding: 0.75rem 0.5rem;">Ngày Tạo</th>
                <th style="padding: 0.75rem 0.5rem; text-align: right; width: 120px;">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($groups)): ?>
                <?php foreach ($groups as $group): ?>
                    <tr style="border-bottom: 1px solid var(--glass-border);">
                        <td style="padding: 0.75rem 0.5rem; font-weight: 700;">#<?= $group['id'] ?></td>
                        <td style="padding: 0.75rem 0.5rem; font-weight: 600; color: var(--ios-text);"><?= htmlspecialchars($group['name']) ?></td>
                        <td style="padding: 0.75rem 0.5rem; color: var(--ios-text-secondary);"><?= htmlspecialchars($group['description'] ?? 'Chưa có mô tả') ?></td>
                        <td style="padding: 0.75rem 0.5rem; text-align: center;">
                            <?php if (($group['status'] ?? 'active') === 'active'): ?>
                                <span style="background: rgba(52, 199, 89, 0.15); color: var(--ios-success); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">ACTIVE</span>
                            <?php else: ?>
                                <span style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.2rem 0.6rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700;">INACTIVE</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; color: var(--ios-text-secondary); font-size: 0.85rem;">
                            <?= !empty($group['created_at']) ? date('d/m/Y H:i', strtotime($group['created_at'])) : 'N/A' ?>
                        </td>
                        <td style="padding: 0.75rem 0.5rem; text-align: right;">
                            <a href="/admin/server-groups/edit?id=<?= $group['id'] ?>" style="text-decoration: none; margin-right: 0.5rem;" title="Chỉnh Sửa">✏️</a>
                            <a href="/admin/server-groups/delete?id=<?= $group['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa nhóm máy chủ này?');" style="text-decoration: none;" title="Xóa">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="6" style="padding: 2rem; text-align: center; color: var(--ios-text-secondary);">Chưa có nhóm máy chủ nào được tạo.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>