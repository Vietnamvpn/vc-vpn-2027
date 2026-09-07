<?php
$pageTitle = "Chỉnh Sửa Nhóm Máy Chủ - Quản Trị Hệ Thống";
$activeMenu = "server-groups";

ob_start();
?>

<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Chỉnh Sửa Nhóm: <?= htmlspecialchars($group['name'] ?? '') ?></h1>
    </div>
    <a href="/admin/server-groups" class="glass-btn" style="text-decoration: none; font-weight: 600;">⬅️ Quay Lại</a>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.875rem; border: 1px solid rgba(255, 59, 48, 0.3); margin-bottom: 1.25rem;">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="glass-card" style="padding: 1.5rem; max-width: 600px;">
    <form action="/admin/server-groups/edit?id=<?= $group['id'] ?>" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
            <label for="name" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Tên Nhóm Máy Chủ <span style="color: var(--ios-danger);">*</span></label>
            <input type="text" id="name" name="name" class="glass-input" value="<?= htmlspecialchars($group['name'] ?? '') ?>" required autofocus style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
        </div>

        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
            <label for="description" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Mô Tả</label>
            <textarea id="description" name="description" rows="4" class="glass-input" style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text); resize: vertical;"><?= htmlspecialchars($group['description'] ?? '') ?></textarea>
        </div>

        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
            <label for="status" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Trạng Thái</label>
            <select id="status" name="status" class="glass-input" style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
                <option value="active" <?= ($group['status'] ?? '') === 'active' ? 'selected' : '' ?> style="background: #1e293b; color: #fff;">Hoạt động (Active)</option>
                <option value="inactive" <?= ($group['status'] ?? '') === 'inactive' ? 'selected' : '' ?> style="background: #1e293b; color: #fff;">Khóa (Inactive)</option>
            </select>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.75rem 1.5rem; font-weight: 600; background: var(--ios-blue); color: #fff; border: none; cursor: pointer;">Cập Nhật</button>
            <a href="/admin/server-groups" class="glass-btn" style="padding: 0.75rem 1.5rem; font-weight: 600; text-decoration: none; text-align: center;">Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>