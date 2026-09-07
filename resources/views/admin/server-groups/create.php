<?php
$pageTitle = "Thêm Nhóm Máy Chủ - Quản Trị Hệ Thống";
$activeMenu = "server-groups";

ob_start();
?>

<div style="margin-bottom: 1.5rem; text-align: center;">
    <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Thêm Nhóm Máy Chủ Mới</h1>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.875rem; border: 1px solid rgba(255, 59, 48, 0.3); margin-bottom: 1.25rem; max-width: 600px; margin-left: auto; margin-right: auto;">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="glass-card" style="padding: 1.5rem; max-width: 600px; margin: 0 auto;">
    <form action="/admin/server-groups/create" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
            <label for="name" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Tên Nhóm Máy Chủ <span style="color: var(--ios-danger);">*</span></label>
            <input type="text" id="name" name="name" class="glass-input" placeholder="Ví dụ: Cụm VIP Việt Nam" required autofocus style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
        </div>

        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
            <label for="description" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Mô Tả</label>
            <textarea id="description" name="description" rows="4" class="glass-input" placeholder="Nhập ghi chú hoặc mô tả nhóm máy chủ..." style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text); resize: vertical;"></textarea>
        </div>

        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
            <label for="status" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Trạng Thái</label>
            <select id="status" name="status" class="glass-input" style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
                <option value="active" selected style="background: #1e293b; color: #fff;">Hoạt động (Active)</option>
                <option value="inactive" style="background: #1e293b; color: #fff;">Khóa (Inactive)</option>
            </select>
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.75rem 1.5rem; font-weight: 600; background: var(--ios-blue); color: #fff; border: none; cursor: pointer; border-radius: var(--radius-md);">Lưu Nhóm</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>