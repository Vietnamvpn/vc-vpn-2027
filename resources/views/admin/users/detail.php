<?php
$pageTitle = "Chi Tiết Người Dùng - Quản Trị Hệ Thống";
$activeMenu = "users";

ob_start();
?>

<div style="margin-bottom: 1rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.5rem;">
    <div>
        <a href="/admin/users" style="color: var(--ios-blue); text-decoration: none; font-weight: 600;">&larr; Quay lại danh sách</a>
        <h1 style="font-size: 1.5rem; font-weight: 700; margin-top: 0.5rem;">Hồ Sơ: <?= htmlspecialchars($user['username']) ?></h1>
    </div>
    <a href="/admin/users/edit?id=<?= $user['id'] ?>" class="glass-btn" style="text-decoration: none;">✏️ Chỉnh Sửa</a>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
    <!-- Thẻ Thông Tin Cá Nhân -->
    <div class="glass-card" style="padding: 1.25rem;">
        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.75rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem;">Thông Tin Tài Khoản</h2>
        
        <div style="display: flex; flex-direction: column; gap: 0.6rem; font-size: 0.9rem;">
            <div><strong>ID:</strong> #<?= $user['id'] ?></div>
            <div><strong>Username:</strong> <?= htmlspecialchars($user['username']) ?></div>
            <div><strong>Email:</strong> <?= htmlspecialchars($user['email']) ?></div>
            <div><strong>Họ và tên:</strong> <?= htmlspecialchars($user['full_name'] ?? 'Chưa cập nhật') ?></div>
            <div><strong>Số điện thoại:</strong> <?= htmlspecialchars($user['phone'] ?? 'Chưa cập nhật') ?></div>
            <div>
                <strong>Vai trò:</strong> 
                <span style="font-weight: 700; text-transform: uppercase;"><?= htmlspecialchars($user['role']) ?></span>
            </div>
            <div>
                <strong>Trạng thái:</strong> 
                <span style="font-weight: 700; text-transform: uppercase;"><?= htmlspecialchars($user['status']) ?></span>
            </div>
        </div>
    </div>

    <!-- Thẻ Tài Chính & Giới Thiệu -->
    <div class="glass-card" style="padding: 1.25rem;">
        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.75rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem;">Ví & Hoa Hồng</h2>
        
        <div style="display: flex; flex-direction: column; gap: 0.6rem; font-size: 0.9rem;">
            <div><strong>Số dư tài khoản:</strong> <span style="color: var(--ios-success); font-weight: 700; font-size: 1.1rem;"><?= number_format($user['balance'], 0, ',', '.') ?> đ</span></div>
            <div><strong>Số dư hoa hồng:</strong> <span style="color: var(--ios-warning); font-weight: 700;"><?= number_format($user['commission_balance'], 0, ',', '.') ?> đ</span></div>
            <div><strong>Mã giới thiệu (Ref Code):</strong> <code style="background: rgba(0,122,255,0.1); padding: 0.2rem 0.4rem; border-radius: var(--radius-sm); font-weight: 700;"><?= htmlspecialchars($user['ref_code'] ?? 'N/A') ?></code></div>
            <div><strong>Đăng ký IP:</strong> <?= htmlspecialchars($user['register_ip'] ?? 'N/A') ?></div>
            <div><strong>Đăng nhập cuối IP:</strong> <?= htmlspecialchars($user['last_login_ip'] ?? 'N/A') ?></div>
            <div><strong>Đăng nhập cuối lúc:</strong> <?= !empty($user['last_login_time']) ? date('d/m/Y H:i:s', strtotime($user['last_login_time'])) : 'Chưa ghi nhận' ?></div>
            <div><strong>Ngày tạo tài khoản:</strong> <?= date('d/m/Y H:i:s', strtotime($user['created_at'])) ?></div>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>