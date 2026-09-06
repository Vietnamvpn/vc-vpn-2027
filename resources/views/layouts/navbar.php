<nav class="glass-card navbar-container" style="margin: 0; padding: 0.875rem 1.5rem; border-radius: 0; border-top: none; border-left: none; border-right: none; display: flex; align-items: center; justify-content: space-between; flex-shrink: 0; width: 100%; z-index: 100;">
    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <!-- Nút Toggle Sidebar (Hiện trên Mobile/Tablet < 992px) -->
        <button id="sidebar-toggle" type="button" aria-label="Toggle Sidebar" style="background: transparent; border: none; font-size: 1.3rem; color: var(--ios-text); cursor: pointer; padding: 0.25rem 0.5rem; display: flex; align-items: center; justify-content: center; border-radius: var(--radius-sm);" class="mobile-only-btn">
            ☰
        </button>
        <span style="font-weight: 600; font-size: 0.95rem; color: var(--ios-text-secondary);" class="mobile-only-btn">
            VC VPN 2027
        </span>
    </div>

    <div style="display: flex; align-items: center; gap: 0.75rem;">
        <?php if (isset($_SESSION['user_id'])): ?>
            <div class="profile-dropdown-wrapper" style="position: relative;">
                <button type="button" id="profile-dropdown-btn" class="profile-trigger" style="display: flex; align-items: center; gap: 0.5rem; background: rgba(255, 255, 255, 0.25); border: 1px solid var(--glass-border); padding: 0.4rem 0.8rem; border-radius: 9999px; cursor: pointer; color: var(--ios-text); font-weight: 600; font-size: 0.85rem;">
                    <span style="width: 24px; height: 24px; border-radius: 50%; background: var(--ios-blue); color: #fff; display: flex; align-items: center; justify-content: center; font-size: 0.75rem; font-weight: 700;">
                        <?= strtoupper(substr($_SESSION['username'] ?? 'U', 0, 1)) ?>
                    </span>
                    <span><?= htmlspecialchars($_SESSION['username'] ?? 'Tài khoản') ?></span>
                    <span style="font-size: 0.7rem; color: var(--ios-text-secondary);">▼</span>
                </button>

                <div id="profile-dropdown-menu" class="profile-menu glass-card">
                    <div style="border-bottom: 1px solid var(--glass-border); padding-bottom: 0.75rem;">
                        <div style="font-weight: 700; font-size: 0.95rem; color: var(--ios-text);">
                            <?= htmlspecialchars($_SESSION['full_name'] ?? $_SESSION['username'] ?? 'N/A') ?>
                        </div>
                        <div style="font-size: 0.75rem; color: var(--ios-text-secondary); margin-top: 0.15rem; word-break: break-all;">
                            <?= htmlspecialchars($_SESSION['email'] ?? 'Chưa cập nhật email') ?>
                        </div>
                    </div>

                    <div style="display: flex; flex-direction: column; gap: 0.4rem; font-size: 0.825rem; margin-top: 0.5rem;">
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--ios-text-secondary);">Số dư:</span>
                            <span style="font-weight: 700; color: var(--ios-success);"><?= number_format($_SESSION['balance'] ?? 0, 0, ',', '.') ?> đ</span>
                        </div>
                        <div style="display: flex; justify-content: space-between;">
                            <span style="color: var(--ios-text-secondary);">Đăng ký:</span>
                            <span style="font-weight: 500; color: var(--ios-text);"><?= !empty($_SESSION['created_at']) ? date('d/m/Y', strtotime($_SESSION['created_at'])) : 'N/A' ?></span>
                        </div>
                    </div>

                    <div style="border-top: 1px solid var(--glass-border); margin-top: 0.75rem; padding-top: 0.75rem;">
                        <a href="/logout" style="display: flex; align-items: center; justify-content: center; gap: 0.4rem; width: 100%; color: var(--ios-danger); text-decoration: none; font-size: 0.85rem; font-weight: 700; padding: 0.5rem; background: rgba(255, 59, 48, 0.1); border-radius: var(--radius-sm); transition: var(--transition);">
                            🚪 Đăng xuất
                        </a>
                    </div>
                </div>
            </div>
        <?php else: ?>
            <a href="/auth/login" style="color: var(--ios-text); text-decoration: none; font-size: 0.85rem; font-weight: 500;">Đăng nhập</a>
            <a href="/auth/register" class="glass-btn" style="padding: 0.45rem 0.85rem; font-size: 0.85rem;">Đăng ký</a>
        <?php endif; ?>
    </div>
</nav>