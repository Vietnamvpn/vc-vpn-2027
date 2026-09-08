<?php
$pageTitle = "Cài Đặt Hệ Thống - Quản Trị Hệ Thống";
$activeMenu = "settings";

ob_start();
?>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1rem; border-left: 4px solid <?= ($_SESSION['flash_type'] ?? '') === 'success' ? 'var(--ios-success)' : 'var(--ios-danger)' ?>; display: flex; justify-content: space-between; align-items: center; width: 100%; box-sizing: border-box;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1rem; border-left: 4px solid var(--ios-danger); display: flex; justify-content: space-between; align-items: center; width: 100%; box-sizing: border-box;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['error']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div style="margin-bottom: 1rem; width: 100%; box-sizing: border-box;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; word-break: break-word;">Cài Đặt Hệ Thống</h1>
        <p style="color: var(--ios-text-secondary); font-size: 0.85rem;">Thiết lập các thông số chung, thương hiệu và cấu hình thanh toán</p>
    </div>
</div>

<form method="POST" action="/admin/settings/save" style="display: flex; flex-direction: column; gap: 1.25rem;">
    <!-- Cấu Hình Chung -->
    <div class="glass-card" style="padding: 1.5rem; width: 100%;">
        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem; color: var(--ios-blue);">
            ⚙️ Cấu Hình Website & Thương Hiệu
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Trang Web (Site Title)</label>
                <input type="text" name="settings[site_title]" class="glass-input" value="<?= htmlspecialchars($settings['site_title'] ?? 'VC VPN 2027') ?>" style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Email Hỗ Trợ (Support Email)</label>
                <input type="email" name="settings[contact_email]" class="glass-input" value="<?= htmlspecialchars($settings['contact_email'] ?? 'support@vpn2s.linksub24h.com') ?>" style="width: 100%;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem; margin-top: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Kênh Telegram Hỗ Trợ</label>
                <input type="text" name="settings[telegram_channel]" class="glass-input" value="<?= htmlspecialchars($settings['telegram_channel'] ?? '') ?>" placeholder="https://t.me/..." style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Đường Dẫn Logo (URL)</label>
                <input type="text" name="settings[site_logo]" class="glass-input" value="<?= htmlspecialchars($settings['site_logo'] ?? '/assets/images/logo.png') ?>" style="width: 100%;">
            </div>
        </div>

        <div style="margin-top: 1.25rem;">
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Mô Tả Trang Web (Meta Description)</label>
            <textarea name="settings[site_description]" rows="2" class="glass-input" style="width: 100%; resize: vertical;"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
        </div>
    </div>

    <!-- Cấu Hình Tài Chính & Hoa Hồng -->
    <div class="glass-card" style="padding: 1.5rem; width: 100%;">
        <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem; color: var(--ios-success);">
            💰 Cấu Hình Thanh Toán & Tiếp Thị Liên Kết
        </h2>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tỷ Lệ Hoa Hồng Giới Thiệu (%)</label>
                <input type="number" name="settings[commission_rate]" class="glass-input" value="<?= htmlspecialchars($settings['commission_rate'] ?? '10') ?>" min="0" max="100" step="0.1" style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Số Tiền Nạp Tối Thiểu (VNĐ)</label>
                <input type="number" name="settings[min_deposit]" class="glass-input" value="<?= htmlspecialchars($settings['min_deposit'] ?? '10000') ?>" min="0" step="1000" style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Số Tiền Rút Tối Thiểu (VNĐ)</label>
                <input type="number" name="settings[min_withdrawal]" class="glass-input" value="<?= htmlspecialchars($settings['min_withdrawal'] ?? '50000') ?>" min="0" step="1000" style="width: 100%;">
            </div>
        </div>
    </div>

    <div style="display: flex; justify-content: flex-end;">
        <button type="submit" class="glass-btn" style="padding: 0.75rem 2rem; font-size: 0.95rem; background: var(--ios-blue); color: #fff; border: none; font-weight: 600; cursor: pointer;">
            💾 Lưu Tất Cả Cài Đặt
        </button>
    </div>
</form>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>