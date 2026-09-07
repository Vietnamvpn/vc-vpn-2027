<?php
$pageTitle = "Sửa Người Dùng - Quản Trị Hệ Thống";
$activeMenu = "users";

ob_start();
?>

<div style="margin-bottom: 1rem;">
    <a href="/admin/users" style="color: var(--ios-blue); text-decoration: none; font-weight: 600;">&larr; Quay lại danh sách</a>
    <h1 style="font-size: 1.5rem; font-weight: 700; margin-top: 0.5rem;">Chỉnh Sửa: #<?= htmlspecialchars($user['username']) ?></h1>
</div>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="glass-card" style="padding: 1rem 1.25rem; margin-bottom: 1rem; border-left: 4px solid var(--ios-danger);">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<div class="glass-card" style="padding: 1.5rem; max-width: 600px;">
    <form method="POST" action="/admin/users/edit?id=<?= $user['id'] ?>" style="display: flex; flex-direction: column; gap: 1rem;">
        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Tên Đăng Nhập</label>
            <input type="text" class="glass-input" value="<?= htmlspecialchars($user['username']) ?>" disabled style="opacity: 0.7;">
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Email</label>
            <input type="email" class="glass-input" value="<?= htmlspecialchars($user['email']) ?>" disabled style="opacity: 0.7;">
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Mật Khẩu Mới (Để trống nếu không đổi)</label>
            <input type="password" name="new_password" class="glass-input" placeholder="Nhập mật khẩu mới...">
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Họ Và Tên</label>
            <input type="text" name="full_name" class="glass-input" value="<?= htmlspecialchars($user['full_name'] ?? '') ?>">
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Số Điện Thoại</label>
            <input type="text" name="phone" class="glass-input" value="<?= htmlspecialchars($user['phone'] ?? '') ?>">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Vai Trò</label>
                <select name="role" class="glass-input">
                    <option value="user" <?= $user['role'] === 'user' ? 'selected' : '' ?>>User</option>
                    <option value="staff" <?= $user['role'] === 'staff' ? 'selected' : '' ?>>Staff</option>
                    <option value="admin" <?= $user['role'] === 'admin' ? 'selected' : '' ?>>Admin</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Trạng Thái</label>
                <select name="status" class="glass-input">
                    <option value="active" <?= $user['status'] === 'active' ? 'selected' : '' ?>>Active</option>
                    <option value="inactive" <?= $user['status'] === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    <option value="banned" <?= $user['status'] === 'banned' ? 'selected' : '' ?>>Banned</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Số Dư Chính (VNĐ)</label>
                <input type="number" name="balance" class="glass-input" value="<?= (float)$user['balance'] ?>" step="1000">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Số Dư Hoa Hồng (VNĐ)</label>
                <input type="number" name="commission_balance" class="glass-input" value="<?= (float)$user['commission_balance'] ?>" step="1000">
            </div>
        </div>

        <button type="submit" class="glass-btn" style="margin-top: 0.5rem; justify-content: center;">💾 Cập Nhật Thông Tin</button>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>