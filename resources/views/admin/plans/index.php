<?php
$pageTitle = "Quản Lý Gói Cước - Quản Trị Hệ Thống";
$activeMenu = "plans";

ob_start();
?>

<?php if (isset($_SESSION['success']) || !empty($_SESSION['flash_message'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-success); display: flex; justify-content: space-between; align-items: center; background: rgba(52, 199, 89, 0.1); border-radius: var(--radius-md);">
        <span style="font-weight: 500; font-size: 0.9rem; color: var(--ios-success); display: flex; align-items: center; gap: 0.5rem;">
            ✓ <?= htmlspecialchars($_SESSION['success'] ?? $_SESSION['flash_message']) ?>
        </span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['success'], $_SESSION['flash_message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-danger); display: flex; justify-content: space-between; align-items: center; background: rgba(255, 59, 48, 0.1); border-radius: var(--radius-md);">
        <span style="font-weight: 500; font-size: 0.9rem; color: var(--ios-danger); display: flex; align-items: center; gap: 0.5rem;">
            ✕ <?= htmlspecialchars($_SESSION['error']) ?>
        </span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div style="display: flex; justify-content: space-between; align-items: flex-end; margin-bottom: 0.75rem; flex-wrap: wrap; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px; margin: 0; color: var(--ios-text);">Danh Sách Gói Cước VPN</h1>
        <p style="font-size: 0.875rem; color: var(--ios-text-secondary); margin: 0.35rem 0 0 0;">Quản lý các gói dịch vụ, giá bán, thời hạn và giới hạn lưu lượng tài khoản</p>
    </div>
    <a href="/admin/plans/create" class="glass-btn" style="text-decoration: none; display: inline-flex; align-items: center; gap: 0.5rem; font-weight: 600; padding: 0.65rem 1.25rem; font-size: 0.9rem; background: var(--ios-blue); color: #fff; border-radius: var(--radius-md); transition: opacity 0.2s;" onmouseover="this.style.opacity='0.9'" onmouseout="this.style.opacity='1'">
        ➕ Thêm Gói Cước Mới
    </a>
</div>

<hr style="border: none; border-top: 1px solid var(--glass-border); margin: 0 0 1.25rem 0;">

<div class="glass-card" style="padding: 1.25rem; overflow-x: auto; border-radius: var(--radius-lg);">
    <table class="glass-table" style="width: 100%; border-collapse: collapse; text-align: left; font-size: 0.9rem;">
        <thead>
            <tr style="border-bottom: 1px solid var(--glass-border); color: var(--ios-text-secondary); text-transform: uppercase; font-size: 0.75rem; letter-spacing: 0.5px;">
                <th style="padding: 0.85rem 0.6rem; width: 60px;">ID</th>
                <th style="padding: 0.85rem 0.6rem;">Tên Gói Cước</th>
                <th style="padding: 0.85rem 0.6rem;">Mã Code</th>
                <th style="padding: 0.85rem 0.6rem;">Nhóm Server</th>
                <th style="padding: 0.85rem 0.6rem;">Giá Bán</th>
                <th style="padding: 0.85rem 0.6rem; text-align: center;">Thời Hạn</th>
                <th style="padding: 0.85rem 0.6rem; text-align: center;">Dung Lượng</th>
                <th style="padding: 0.85rem 0.6rem; text-align: center;">Thiết Bị</th>
                <th style="padding: 0.85rem 0.6rem; text-align: center;">Trạng Thái</th>
                <th style="padding: 0.85rem 0.6rem; text-align: right; width: 110px;">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($plans)): ?>
                <?php foreach ($plans as $plan): ?>
                    <tr style="border-bottom: 1px solid var(--glass-border); transition: background 0.15s;" onmouseover="this.style.background='rgba(255, 255, 255, 0.03)'" onmouseout="this.style.background='transparent'">
                        <td style="padding: 0.85rem 0.6rem; font-weight: 700; color: var(--ios-text-secondary);">#<?= $plan['id'] ?></td>
                        <td style="padding: 0.85rem 0.6rem; font-weight: 600; color: var(--ios-text);"><?= htmlspecialchars($plan['name']) ?></td>
                        <td style="padding: 0.85rem 0.6rem;">
                            <span style="font-family: monospace; font-size: 0.85rem; background: rgba(0, 122, 255, 0.1); color: var(--ios-blue); padding: 0.2rem 0.5rem; border-radius: var(--radius-sm); font-weight: 600;">
                                <?= htmlspecialchars($plan['code']) ?>
                            </span>
                        </td>
                        <td style="padding: 0.85rem 0.6rem; color: var(--ios-text-secondary); font-weight: 500;"><?= htmlspecialchars($plan['group_name'] ?? 'Chưa phân nhóm') ?></td>
                        <td style="padding: 0.85rem 0.6rem; font-weight: 700; color: var(--ios-success);"><?= number_format($plan['price'], 0, ',', '.') ?>đ</td>
                        <td style="padding: 0.85rem 0.6rem; text-align: center; font-weight: 600; color: var(--ios-text);"><?= htmlspecialchars($plan['duration_days']) ?> Ngày</td>
                        <td style="padding: 0.85rem 0.6rem; text-align: center; font-weight: 600;">
                            <?= ($plan['bandwidth_limit_gb'] > 0) ? htmlspecialchars($plan['bandwidth_limit_gb']) . ' GB' : '<span style="color: var(--ios-success); font-size: 0.8rem; background: rgba(52, 199, 89, 0.12); padding: 0.2rem 0.5rem; border-radius: 10px;">Vô hạn</span>' ?>
                        </td>
                        <td style="padding: 0.85rem 0.6rem; text-align: center; font-weight: 600; color: var(--ios-text);"><?= htmlspecialchars($plan['max_devices']) ?> Thiết bị</td>
                        <td style="padding: 0.85rem 0.6rem; text-align: center;">
                            <?php if (($plan['status'] ?? 'active') === 'active'): ?>
                                <span style="background: rgba(52, 199, 89, 0.15); color: var(--ios-success); padding: 0.25rem 0.65rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.3px;">HOẠT ĐỘNG</span>
                            <?php else: ?>
                                <span style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.25rem 0.65rem; border-radius: 12px; font-size: 0.75rem; font-weight: 700; letter-spacing: 0.3px;">TẮT</span>
                            <?php endif; ?>
                        </td>
                        <td style="padding: 0.85rem 0.6rem; text-align: right;">
                            <a href="/admin/plans/edit?id=<?= $plan['id'] ?>" style="text-decoration: none; margin-right: 0.5rem; display: inline-block; padding: 0.3rem 0.5rem; border-radius: var(--radius-sm); background: rgba(255, 255, 255, 0.05);" title="Chỉnh Sửa">✏️</a>
                            <a href="/admin/plans/delete?id=<?= $plan['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa gói cước này?');" style="text-decoration: none; display: inline-block; padding: 0.3rem 0.5rem; border-radius: var(--radius-sm); background: rgba(255, 59, 48, 0.1);" title="Xóa">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" style="padding: 2.5rem; text-align: center; color: var(--ios-text-secondary);">Chưa có gói cước nào được tạo trong hệ thống.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>