<?php
$pageTitle = "Danh Sách Người Dùng - Quản Trị Hệ Thống";
$activeMenu = "users";

ob_start();
?>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="glass-card" style="padding: 1rem 1.25rem; margin-bottom: 1rem; border-left: 4px solid <?= ($_SESSION['flash_type'] ?? '') === 'success' ? 'var(--ios-success)' : 'var(--ios-danger)' ?>;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; flex-wrap: wrap; gap: 0.75rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700;">Quản Lý Người Dùng</h1>
        <p style="color: var(--ios-text-secondary); font-size: 0.85rem;">Danh sách tất cả tài khoản thành viên trong hệ thống</p>
    </div>
    <a href="/admin/users/create" class="glass-btn" style="text-decoration: none;">+ Thêm Người Dùng</a>
</div>

<!-- Bộ Lọc & Tìm Kiếm -->
<div class="glass-card" style="padding: 1rem; margin-bottom: 1.25rem;">
    <form method="GET" action="/admin/users" style="display: flex; gap: 0.75rem; flex-wrap: wrap; align-items: center;">
        <input type="text" name="search" class="glass-input" placeholder="Tìm theo tên, email, SĐT..." value="<?= htmlspecialchars($search ?? '') ?>" style="flex: 1; min-width: 200px;">
        
        <select name="role" class="glass-input" style="width: auto; min-width: 130px; cursor: pointer;">
            <option value="">-- Vai trò --</option>
            <option value="admin" <?= ($role ?? '') === 'admin' ? 'selected' : '' ?>>Admin</option>
            <option value="staff" <?= ($role ?? '') === 'staff' ? 'selected' : '' ?>>Staff</option>
            <option value="user" <?= ($role ?? '') === 'user' ? 'selected' : '' ?>>User</option>
        </select>

        <select name="status" class="glass-input" style="width: auto; min-width: 140px; cursor: pointer;">
            <option value="">-- Trạng thái --</option>
            <option value="active" <?= ($status ?? '') === 'active' ? 'selected' : '' ?>>Hoạt động</option>
            <option value="inactive" <?= ($status ?? '') === 'inactive' ? 'selected' : '' ?>>Chưa kích hoạt</option>
            <option value="banned" <?= ($status ?? '') === 'banned' ? 'selected' : '' ?>>Khóa (Banned)</option>
        </select>

        <button type="submit" class="glass-btn">🔍 Tìm kiếm</button>
        <?php if (!empty($search) || !empty($role) || !empty($status)): ?>
            <a href="/admin/users" style="color: var(--ios-danger); font-size: 0.85rem; text-decoration: none; font-weight: 600;">Xóa lọc</a>
        <?php endif; ?>
    </form>
</div>

<!-- Bảng Người Dùng -->
<div class="glass-card" style="padding: 1.25rem;">
    <div class="table-responsive">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Người Dùng</th>
                    <th>IP Đăng Nhập</th>
                    <th>Vai Trò</th>
                    <th>Số Dư</th>
                    <th>Hoa Hồng</th>
                    <th>Trạng Thái</th>
                    <th>Ngày Tạo</th>
                    <th style="text-align: right;">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($users)): ?>
                    <?php foreach ($users as $u): ?>
                        <tr>
                            <td style="font-weight: 700;">#<?= $u['id'] ?></td>
                            <td>
                                <div style="font-weight: 700; font-size: 0.9rem;"><?= htmlspecialchars($u['username']) ?></div>
                                <div style="font-size: 0.78rem; color: var(--ios-text-secondary);"><?= htmlspecialchars($u['email']) ?></div>
                            </td>
                            <td style="font-size: 0.85rem;">
                                <code style="background: rgba(0, 122, 255, 0.08); padding: 0.2rem 0.4rem; border-radius: var(--radius-sm); font-weight: 600; color: var(--ios-text);">
                                    <?= htmlspecialchars($u['last_login_ip'] ?? 'Chưa ghi nhận') ?>
                                </code>
                            </td>
                            <td>
                                <?php
                                $roleBadge = [
                                    'admin' => 'background: rgba(255, 45, 85, 0.15); color: #ff2d55;',
                                    'staff' => 'background: rgba(255, 149, 0, 0.15); color: var(--ios-warning);',
                                    'user'  => 'background: rgba(0, 122, 255, 0.15); color: var(--ios-blue);'
                                ];
                                ?>
                                <span style="padding: 0.2rem 0.5rem; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 700; <?= $roleBadge[$u['role']] ?? '' ?>">
                                    <?= strtoupper($u['role']) ?>
                                </span>
                            </td>
                            <td style="font-weight: 700; color: var(--ios-success);">
                                <?= number_format($u['balance'], 0, ',', '.') ?> đ
                            </td>
                            <td style="font-weight: 700; color: var(--ios-warning);">
                                <?= number_format($u['commission_balance'], 0, ',', '.') ?> đ
                            </td>
                            <td>
                                <?php
                                $statusBadge = [
                                    'active'   => 'background: rgba(52, 199, 89, 0.15); color: var(--ios-success);',
                                    'inactive' => 'background: rgba(142, 142, 147, 0.15); color: var(--ios-text-secondary);',
                                    'banned'   => 'background: rgba(255, 59, 48, 0.15); color: var(--ios-danger);'
                                ];
                                ?>
                                <span style="padding: 0.2rem 0.5rem; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 700; <?= $statusBadge[$u['status']] ?? '' ?>">
                                    <?= strtoupper($u['status']) ?>
                                </span>
                            </td>
                            <td style="font-size: 0.8rem; color: var(--ios-text-secondary);">
                                <?= date('d/m/Y H:i', strtotime($u['created_at'])) ?>
                            </td>
                            <td style="text-align: right;">
                                <div class="action-dropdown">
                                    <button type="button" class="action-btn" title="Thao tác">⋮</button>
                                    <div class="action-menu">
                                        <a href="/admin/users/detail?id=<?= $u['id'] ?>" class="action-item">
                                            <span>👁️</span> Xem chi tiết
                                        </a>
                                        <a href="/admin/users/edit?id=<?= $u['id'] ?>" class="action-item">
                                            <span>✏️</span> Chỉnh sửa
                                        </a>
                                        <?php if ($u['role'] !== 'admin'): ?>
                                            <a href="/admin/users/delete?id=<?= $u['id'] ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa thành viên này?');" class="action-item delete" style="color: var(--ios-danger);">
                                                <span>🗑️</span> Xóa tài khoản
                                            </a>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 2rem; color: var(--ios-text-secondary);">Không tìm thấy thành viên nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>