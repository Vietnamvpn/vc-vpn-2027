<?php
$pageTitle = "Quản Lý Gói Cước - Quản Trị Hệ Thống";
$activeMenu = "plans";

ob_start();
?>

<?php if (isset($_SESSION['success']) || !empty($_SESSION['flash_message'])): ?>
    <div class="glass-card glass-alert alert-success">
        <span class="font-semibold">✓ <?= htmlspecialchars($_SESSION['success'] ?? $_SESSION['flash_message']) ?></span>
        <button type="button" class="alert-close" title="Đóng">&times;</button>
        <?php unset($_SESSION['success'], $_SESSION['flash_message']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="glass-card glass-alert alert-danger">
        <span class="font-semibold">✕ <?= htmlspecialchars($_SESSION['error']) ?></span>
        <button type="button" class="alert-close" title="Đóng">&times;</button>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div class="page-header">
    <h1 class="page-title">Danh Sách Gói Cước VPN</h1>
    <p class="page-subtitle">Quản lý các gói dịch vụ, giá bán, thời hạn và giới hạn lưu lượng tài khoản</p>
</div>

<div class="divider-line"></div>

<div class="action-bar">
    <a href="/admin/plans/create" class="glass-btn" style="background: var(--ios-blue); color: #fff; border: none; box-shadow: 0 4px 12px rgba(0, 122, 255, 0.25);">
        ➕ Thêm Gói Cước Mới
    </a>
</div>

<div class="glass-card table-responsive">
    <table class="glass-table">
        <thead>
            <tr>
                <th style="width: 50px;">ID</th>
                <th>Tên Gói Cước</th>
                <th>Mã Code</th>
                <th>Nhóm Server</th>
                <th>Giá Bán</th>
                <th class="text-center">Thời Hạn</th>
                <th class="text-center">Dung Lượng</th>
                <th class="text-center">Thiết Bị</th>
                <th class="text-center">Trạng Thái</th>
                <th class="text-right" style="width: 100px;">Thao Tác</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($plans)): ?>
                <?php foreach ($plans as $plan): ?>
                    <tr>
                        <td class="font-bold text-muted">#<?= $plan['id'] ?></td>
                        <td class="font-semibold"><?= htmlspecialchars($plan['name']) ?></td>
                        <td><span class="badge-code"><?= htmlspecialchars($plan['code']) ?></span></td>
                        <td class="text-muted"><?= htmlspecialchars($plan['group_name'] ?? 'Chưa phân nhóm') ?></td>
                        <td class="font-bold text-success"><?= number_format($plan['price'], 0, ',', '.') ?>đ</td>
                        <td class="text-center font-semibold"><?= htmlspecialchars($plan['duration_days']) ?> Ngày</td>
                        <td class="text-center font-semibold">
                            <?= ($plan['bandwidth_limit_gb'] > 0) ? htmlspecialchars($plan['bandwidth_limit_gb']) . ' GB' : '<span class="badge-unlimited">Vô hạn</span>' ?>
                        </td>
                        <td class="text-center font-semibold"><?= htmlspecialchars($plan['max_devices']) ?> Thiết bị</td>
                        <td class="text-center">
                            <?php if (($plan['status'] ?? 'active') === 'active'): ?>
                                <span class="badge-status active">HOẠT ĐỘNG</span>
                            <?php else: ?>
                                <span class="badge-status inactive">TẮT</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-right nowrap">
                            <a href="/admin/plans/edit?id=<?= $plan['id'] ?>" class="btn-icon" title="Chỉnh Sửa">✏️</a>
                            <a href="/admin/plans/delete?id=<?= $plan['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa gói cước này?');" class="btn-icon btn-delete" title="Xóa">🗑️</a>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else: ?>
                <tr>
                    <td colspan="10" class="text-center text-muted" style="padding: 2.5rem;">Chưa có gói cước nào được tạo trong hệ thống.</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>