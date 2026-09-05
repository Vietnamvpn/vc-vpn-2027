<nav class="glass-card" style="margin: 1rem; padding: 0.75rem 1.5rem; display: flex; align-items: center; justify-content: space-between; border-radius: var(--radius-md);">
    <a href="/" style="display: flex; align-items: center; gap: 0.75rem; text-decoration: none; color: var(--ios-text); font-weight: 700; font-size: 1.1rem;">
        <img src="/assets/images/logo.png" alt="Logo" style="height: 32px; width: 32px; border-radius: 8px;">
        <span>VC VPN 2027</span>
    </a>
    <div style="display: flex; align-items: center; gap: 1rem;">
        <?php if (isset($_SESSION['user_id'])): ?>
            <a href="/user/dashboard" class="glass-btn" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Dashboard</a>
            <a href="/logout" style="color: var(--ios-danger); text-decoration: none; font-size: 0.85rem; font-weight: 500;">Đăng xuất</a>
        <?php else: ?>
            <a href="/auth/login" style="color: var(--ios-text); text-decoration: none; font-size: 0.85rem; font-weight: 500;">Đăng nhập</a>
            <a href="/auth/register" class="glass-btn" style="padding: 0.5rem 1rem; font-size: 0.85rem;">Đăng ký</a>
        <?php endif; ?>
    </div>
</nav>