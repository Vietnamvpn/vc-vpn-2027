<nav class="glass-card navbar-container" style="margin: 0.75rem 1rem 0 1rem; padding: 0.75rem 1.25rem; display: flex; align-items: center; justify-content: space-between; border-radius: var(--radius-md); flex-shrink: 0;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <!-- Nút Toggle Sidebar (Chỉ hiện trên Mobile/Tablet) -->
        <button id="sidebar-toggle" aria-label="Toggle Sidebar" style="background: transparent; border: none; font-size: 1.3rem; color: var(--ios-text); cursor: pointer; padding: 0.25rem; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-sm);" class="mobile-only-btn">
            ☰
        </button>

        <a href="/" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: var(--ios-text); font-weight: 700; font-size: 1.1rem;">
            <img src="/assets/images/logo.png" alt="Logo" style="height: 32px; width: 32px; border-radius: 8px;">
            <span>VC VPN 2027</span>
        </a>
    </div>

    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <?php if (isset($_SESSION['user_id'])): ?>
            <!-- Nút chuyển đổi nhanh giao diện cho Admin -->
            <?php if (($_SESSION['role'] ?? '') === 'admin'): ?>
                <?php if (str_starts_with($_SERVER['REQUEST_URI'] ?? '', '/admin')): ?>
                    <a href="/user/dashboard" class="glass-btn" style="padding: 0.45rem 0.85rem; font-size: 0.8rem; background: rgba(52, 199, 89, 0.2); color: var(--ios-success); border-color: rgba(52, 199, 89, 0.3);">
                        👤 Trang User
                    </a>
                <?php else: ?>
                    <a href="/admin/dashboard" class="glass-btn" style="padding: 0.45rem 0.85rem; font-size: 0.8rem; background: rgba(0, 122, 255, 0.2); color: var(--ios-blue); border-color: rgba(0, 122, 255, 0.3);">
                        ⚙️ Trang Admin
                    </a>
                <?php endif; ?>
            <?php else: ?>
                <a href="/user/dashboard" class="glass-btn" style="padding: 0.45rem 0.85rem; font-size: 0.8rem;">Dashboard</a>
            <?php endif; ?>

            <a href="/logout" style="color: var(--ios-danger); text-decoration: none; font-size: 0.85rem; font-weight: 600; padding: 0.45rem 0.5rem;">Đăng xuất</a>
        <?php else: ?>
            <a href="/auth/login" style="color: var(--ios-text); text-decoration: none; font-size: 0.85rem; font-weight: 500;">Đăng nhập</a>
            <a href="/auth/register" class="glass-btn" style="padding: 0.45rem 0.85rem; font-size: 0.85rem;">Đăng ký</a>
        <?php endif; ?>
    </div>
</nav>