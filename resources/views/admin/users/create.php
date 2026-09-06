<?php
$pageTitle = "Thêm Người Dùng Mới - Admin";
$activeMenu = "users";

ob_start();
?>

<div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Thêm Người Dùng Mới</h1>
            <p style="color: var(--ios-text-secondary); font-size: 0.875rem;">Tạo tài khoản quản trị hoặc người dùng thủ công</p>
        </div>
        <a href="/admin/users" style="color: var(--ios-text-secondary); text-decoration: none; font-size: 0.875rem; font-weight: 500;">&larr; Quay lại</a>
    </div>

    <?php if (!empty($errors)): ?>
        <div class="glass-card" style="border-left: 4px solid var(--ios-danger); padding: 1rem; background: rgba(255, 59, 48, 0.1);">
            <ul style="margin: 0; padding-left: 1.25rem; color: var(--ios-danger); font-size: 0.875rem;">
                <?php foreach ($errors as $err): ?>
                    <li><?= htmlspecialchars($err) ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form action="/admin/users/create" method="POST" class="glass-card" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Username (*)</label>
                <input type="text" name="username" class="glass-input" required value="<?= htmlspecialchars($_POST['username'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Email (*)</label>
                <input type="email" name="email" class="glass-input" required value="<?= htmlspecialchars($_POST['email'] ?? '') ?>">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Mật Khẩu (*)</label>
                <input type="password" name="password" class="glass-input" required>
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Họ Và Tên</label>
                <input type="text" name="full_name" class="glass-input" value="<?= htmlspecialchars($_POST['full_name'] ?? '') ?>">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Số Điện Thoại</label>
                <input type="text" name="phone" class="glass-input" value="<?= htmlspecialchars($_POST['phone'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Vai Trò</label>
                <select name="role" class="glass-input">
                    <option value="user">User</option>
                    <option value="staff">Staff</option>
                    <option value="admin">Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Trạng Thái</label>
                <select name="status" class="glass-input">
                    <option value="active">Active</option>
                    <option value="inactive">Inactive</option>
                    <option value="banned">Banned</option>
                </select>
            </div>
        </div>

        <div class="form-group">
            <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Số Dư Ban Đầu (VNĐ)</label>
            <input type="number" step="1000" name="balance" class="glass-input" value="0">
        </div>

        <div style="text-align: right; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="width: 100%; max-width: 200px;">Lưu Người Dùng</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>