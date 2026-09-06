<?php
$pageTitle = "Chỉnh Sửa Người Dùng - Admin";
$activeMenu = "users";

ob_start();
?>

<div style="max-width: 800px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem;">
    <div style="display: flex; justify-content: space-between; align-items: center;">
        <div>
            <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Sửa: <?= htmlspecialchars($user['username'] ?? '') ?></h1>
            <p style="color: var(--ios-text-secondary); font-size: 0.875rem;">Cập nhật thông tin tài khoản #<?= $user['id'] ?? '' ?></p>
        </div>
        <a href="/admin/users" style="color: var(--ios-text-secondary); text-decoration: none; font-size: 0.875rem; font-weight: 500;">&larr; Quay lại</a>
    </div>

    <form action="/admin/users/edit?id=<?= $user['id'] ?>" method="POST" class="glass-card" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Username</label>
                <input type="text" disabled class="glass-input" value="<?= htmlspecialchars($user['username'] ?? '') ?>" style="opacity: 0.6; cursor: not-allowed;">
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Email (*)</label>
                <input type="email" name="email" class="glass-input" required value="<?= htmlspecialchars($user['email'] ?? '') ?>">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Đổi Mật Khẩu (Để trống nếu giữ nguyên)</label>
                <input type="password" name="password" class="glass-input" placeholder="••••••••">
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Họ Và Tên</label>
                <input type="text" name="full_name" class="glass-input" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 1rem;">
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Số Điện Thoại</label>
                <input type="text" name="phone" class="glass-input" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Vai Trò</label>
                <select name="role" class="glass-input">
                    <option value="user" <?= ($user['role'] ?? '') === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="staff" <?= ($user['role'] ?? '') === 'staff' ? 'selected' : '' ?>>Staff</option>
                    <option value="admin" <?= ($user['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Trạng Thái</label>
                <select name="status" class="glass-input">
                    <option value="active" <?= ($user['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= ($user['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="banned" <?= ($user['status'] ?? '') === 'banned' ? 'selected' : '' ?>>Banned</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Số Dư Ví Chính (VNĐ)</label>
                <input type="number" step="1000" name="balance" class="glass-input" value="<?= $user['balance'] ?? 0 ?>">
            </div>
            <div class="form-group">
                <label style="font-size: 0.85rem; font-weight: 600; color: var(--ios-text-secondary);">Số Dư Hoa Hồng (VNĐ)</label>
                <input type="number" step="1000" name="commission_balance" class="glass-input" value="<?= $user['commission_balance'] ?? 0 ?>">
            </div>
        </div>

        <div style="text-align: right; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="background: var(--ios-success); border: none; width: 100%; max-width: 200px;">Cập Nhật</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>