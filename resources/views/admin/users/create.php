<?php
$pageTitle = "Thêm Người Dùng Mới - Quản Trị Hệ Thống";
$activeMenu = "users";

ob_start();
?>

<div style="margin-bottom: 1.25rem;">
    <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Thêm Thành Viên Mới</h1>
</div>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="glass-card" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-danger);">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<div class="glass-card" style="padding: 1.75rem; width: 100%;">
    <form method="POST" action="/admin/users/create" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Đăng Nhập (*)</label>
                <input type="text" name="username" class="glass-input" required placeholder="Nhập username..." style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Email (*)</label>
                <input type="email" name="email" class="glass-input" required placeholder="Nhập địa chỉ email..." style="width: 100%;">
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Mật Khẩu (*)</label>
            <input type="password" name="password" class="glass-input" required placeholder="Tạo mật khẩu..." style="width: 100%;">
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Họ Và Tên</label>
                <input type="text" name="full_name" class="glass-input" placeholder="Nhập họ và tên..." style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Số Điện Thoại</label>
                <input type="text" name="phone" class="glass-input" placeholder="Nhập số điện thoại..." style="width: 100%;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Vai Trò</label>
                <select name="role" class="glass-input" style="width: 100%; cursor: pointer;">
                    <option value="user">User (Thành viên)</option>
                    <option value="staff">Staff (Nhân viên)</option>
                    <option value="admin">Admin (Quản trị viên)</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Trạng Thái</label>
                <select name="status" class="glass-input" style="width: 100%; cursor: pointer;">
                    <option value="active">Active (Hoạt động)</option>
                    <option value="inactive">Inactive (Tắt)</option>
                    <option value="banned">Banned (Khóa)</option>
                </select>
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Số Dư Ban Đầu (VNĐ)</label>
            <input type="number" name="balance" class="glass-input" value="0" min="0" step="1000" style="width: 100%;">
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.65rem 1.75rem; font-size: 0.9rem;">➕ Tạo Người Dùng</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>