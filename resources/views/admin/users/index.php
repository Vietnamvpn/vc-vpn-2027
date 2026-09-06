<?php
$pageTitle = "Quản Lý Người Dùng - Admin";
$activeMenu = "users";

ob_start();
?>

<div style="display: flex; flex-wrap: wrap; justify-content: space-between; align-items: center; gap: 1rem; margin-bottom: 1rem;">
    <div>
        <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Danh Sách Người Dùng</h1>
        <p style="color: var(--ios-text-secondary); font-size: 0.875rem;">Quản lý tài khoản, phân quyền và số dư hệ thống</p>
    </div>
    <a href="/admin/users/create" class="glass-btn">
        <span style="font-size: 1.1rem; margin-right: 0.4rem;">+</span> Thêm Người Dùng
    </a>
</div>

<!-- Form Lọc Kính Mờ -->
<div class="glass-card" style="padding: 1rem; margin-bottom: 1.5rem;">
    <form method="GET" action="/admin/users" style="display: grid; grid-template-columns: repeat(auto-fit, minmax(180px, 1fr)); gap: 0.75rem; align-items: center;">
        <input type="text" name="keyword" class="glass-input" value="<?= htmlspecialchars($_GET['keyword'] ?? '') ?>" placeholder="Tìm Username, Email...">
        
        <select name="role" class="glass-input">
            <option value="">-- Tất cả Vai trò --</option>
            <option value="admin" <?= ($_GET['role'] ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="staff" <?= ($_GET['role'] ?? '') === 'staff' ? 'selected' : '' ?>>Staff</option>
            <option value="user" <?= ($_GET['role'] ?? '') === 'user' ? 'selected' : '' ?>>User</option>
        </select>

        <select name="status" class="glass-input">
            <option value="">-- Tất cả Trạng thái --</option>
            <option value="active" <?= ($_GET['status'] ?? '') === 'active' ? 'selected' : '' ?>>Active</option>
            <option value="inactive" <?= ($_GET['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Inactive</option>
            <option value="banned" <?= ($_GET['status'] ?? '') === 'banned' ? 'selected' : '' ?>>Banned</option>
        </select>

        <button type="submit" class="glass-btn" style="background: rgba(0, 0, 0, 0.8); border: none;">Lọc Dữ Liệu</button>
    </form>
</div>

<!-- Bảng Dữ Liệu Glassmorphism -->
<div class="glass-card" style="padding: 0; overflow: hidden;">
    <div class="table-responsive">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Tài Khoản</th>
                    <th>Vai Trò</th>
                    <th>Số Dư Ví</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Tạo</th>
                    <th style="text-align: right;">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td style="font-weight: 600; color: var(--ios-text-secondary);">#<?= $u['id'] ?></td>
                            <td>
                                <div style="font-weight: 600; font-size: 0.95rem;"><?= htmlspecialchars($u['username']) ?></div>
                                <div style="font-size: 0.75rem; color: var(--ios-text-secondary);"><?= htmlspecialchars($u['email']) ?></div>
                            </td>
                            <td>
                                <?php
                                $roleStyle = [
                                    'admin' => 'background: rgba(255, 59, 48, 0.15); color: var(--ios-danger);',
                                    'staff' => 'background: rgba(0, 122, 255, 0.15); color: var(--ios-blue);',
                                    'user' => 'background: rgba(142, 142, 147, 0.15); color: var(--ios-text-secondary);'
                                ];
                                ?>
                                <span style="padding: 0.2rem 0.5rem; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 700; <?= $roleStyle[$u['role']] ?? '' ?>">
                                    <?= strtoupper($u['role']) ?>
                                </span>
                            </td>
                            <td>
                                <div style="font-weight: 700; color: var(--ios-success);"><?= number_format($u['balance'], 0, ',', '.') ?> đ</div>
                                <div style="font-size: 0.75rem; color: var(--ios-warning);">Hoa hồng: <?= number_format($u['commission_balance'], 0, ',', '.') ?> đ</div>
                            </td>
                            <td>
                                <?php if ($u['status'] === 'active'): ?>
                                    <span style="color: var(--ios-success); background: rgba(52, 199, 89, 0.15); padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">Active</span>
                                <?php elseif ($u['status'] === 'banned'): ?>
                                    <span style="color: var(--ios-danger); background: rgba(255, 59, 48, 0.15); padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">Banned</span>
                                <?php else: ?>
                                    <span style="color: var(--ios-warning); background: rgba(255, 149, 0, 0.15); padding: 0.2rem 0.6rem; border-radius: 9999px; font-size: 0.75rem; font-weight: 700;">Inactive</span>
                                <?php endif; ?>
                            </td>
                            <td style="color: var(--ios-text-secondary); font-size: 0.8rem;">
                                <?= date('d/m/Y H:i', strtotime($u['created_at'])) ?>
                            </td>
                            <td style="text-align: right;">
                                <a href="/admin/users/detail?id=<?= $u['id'] ?>" style="color: var(--ios-blue); text-decoration: none; margin-right: 0.75rem; font-weight: 600; font-size: 0.85rem;">Chi tiết</a>
                                <a href="/admin/users/edit?id=<?= $u['id'] ?>" style="color: var(--ios-success); text-decoration: none; font-weight: 600; font-size: 0.85rem;">Sửa</a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td colspan="7" style="text-align: center; color: var(--ios-text-secondary); padding: 2rem;">Không tìm thấy người dùng phù hợp</td></tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>