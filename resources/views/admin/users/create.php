<?php
$pageTitle = "Thêm Người Dùng Mới - Quản Trị Hệ Thống";
$activeMenu = "users";

ob_start();
?>

<div style="margin-bottom: 1rem;">
    <a href="/admin/users" style="color: var(--ios-blue); text-decoration: none; font-weight: 600;">&larr; Quay lại danh sách</a>
    <h1 style="font-size: 1.5rem; font-weight: 700; margin-top: 0.5rem;">Thêm Thành Viên Mới</h1>
</div>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="glass-card" style="padding: 1rem 1.25rem; margin-bottom: 1rem; border-left: 4px solid var(--ios-danger);">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<div class="glass-card" style="padding: 1.5rem; max-width: 600px;">
    <form method="POST" action="/admin/users/create" style="display: flex; flex-direction: column; gap: 1rem;">
        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Tên Đăng Nhập (*)</label>
            <input type="text" name="username" class="glass-input" required placeholder="Nhập username...">
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Email (*)</label>
            <input type="email" name="email" class="glass-input" required placeholder="Nhập địa chỉ email...">
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Mật Khẩu (*)</label>
            <input type="password" name="password" class="glass-input" required placeholder="Tạo mật khẩu...">
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Họ Và Tên</label>
            <input type="text" name="full_name" class="glass-input" placeholder="Nhập họ và tên...">
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Số Điện Thoại</label>
            <input type="text" name="phone" class="glass-input" placeholder="Nhập số điện thoại...">
        </div>

        <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Vai Trò</label>
                <select name="role" class="glass-input">
                    <option value="user">User (Thành viên)</option>
                    <option value="staff">Staff (Nhân viên)</option>
                    <option value="admin">Admin (Quản trị viên)</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Trạng Thái</label>
                <select name="status" class="glass-input">
                    <option value="active">Active (Hoạt động)</option>
                    <option value="inactive">Inactive (Tắt)</option>
                    <option value="banned">Banned (Khóa)</option>
                </select>
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.35rem;">Số Dư Ban Đầu (VNĐ)</label>
            <input type="number" name="balance" class="glass-input" value="0" min="0" step="1000">
        </div>

        <button type="submit" class="glass-btn" style="margin-top: 0.5rem; justify-content: center;">➕ Tạo Người Dùng</button>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>