<?php
$pageTitle = "Liên Hệ - " . ($settings['site_title'] ?? 'VC VPN 2027');
ob_start();

$contactEmail = $settings['contact_email'] ?? '';
$fanpageUrl   = $settings['fanpage_url'] ?? '';
$youtubeUrl   = $settings['youtube_url'] ?? '';
$zaloUrl      = $settings['zalo_url'] ?? '';
$wechatId     = $settings['wechat_id'] ?? '';
?>

<div style="text-align: center; margin-bottom: 2.5rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">Liên Hệ Hỗ Trợ</h1>
    <p style="color: var(--ios-text-secondary); margin-top: 0.5rem;">Gửi tin nhắn cho chúng tôi nếu bạn cần giúp đỡ hoặc có thắc mắc</p>
</div>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.5rem; border-left: 4px solid <?= ($_SESSION['flash_type'] ?? '') === 'success' ? 'var(--ios-success)' : 'var(--ios-danger)' ?>; display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <?php if (!empty($contactEmail)): ?>
            <div class="glass-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">📧 Email Hỗ Trợ</h3>
                <p style="color: var(--ios-text-secondary); font-size: 0.95rem;"><?= htmlspecialchars($contactEmail) ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($zaloUrl)): ?>
            <div class="glass-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">💬 Zalo</h3>
                <p style="color: var(--ios-text-secondary); font-size: 0.95rem;">
                    <?php if (str_istr($zaloUrl, 'http')): ?>
                        <a href="<?= htmlspecialchars($zaloUrl) ?>" target="_blank" style="color: var(--ios-blue); text-decoration: none;"><?= htmlspecialchars($zaloUrl) ?></a>
                    <?php else: ?>
                        <?= htmlspecialchars($zaloUrl) ?>
                    <?php endif; ?>
                </p>
            </div>
        <?php endif; ?>

        <?php if (!empty($wechatId)): ?>
            <div class="glass-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">💬 WeChat ID</h3>
                <p style="color: var(--ios-text-secondary); font-size: 0.95rem;"><?= htmlspecialchars($wechatId) ?></p>
            </div>
        <?php endif; ?>

        <?php if (!empty($fanpageUrl)): ?>
            <div class="glass-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">🌐 Fanpage Facebook</h3>
                <p style="color: var(--ios-text-secondary); font-size: 0.95rem;">
                    <a href="<?= htmlspecialchars($fanpageUrl) ?>" target="_blank" style="color: var(--ios-blue); text-decoration: none;">Xem Fanpage</a>
                </p>
            </div>
        <?php endif; ?>

        <?php if (!empty($youtubeUrl)): ?>
            <div class="glass-card">
                <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">▶️ Kênh Youtube</h3>
                <p style="color: var(--ios-text-secondary); font-size: 0.95rem;">
                    <a href="<?= htmlspecialchars($youtubeUrl) ?>" target="_blank" style="color: var(--ios-blue); text-decoration: none;">Xem Youtube</a>
                </p>
            </div>
        <?php endif; ?>
    </div>

    <div class="glass-card">
        <form action="/home/contact" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            <div class="form-group">
                <label for="name" style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Họ và tên</label>
                <input type="text" id="name" name="name" class="glass-input" placeholder="Nhập họ và tên" required style="width: 100%;">
            </div>
            <div class="form-group">
                <label for="email" style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Địa chỉ Email</label>
                <input type="email" id="email" name="email" class="glass-input" placeholder="nhap@email.com" required style="width: 100%;">
            </div>
            <div class="form-group">
                <label for="subject" style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Chủ đề</label>
                <input type="text" id="subject" name="subject" class="glass-input" placeholder="Cần hỗ trợ về..." required style="width: 100%;">
            </div>
            <div class="form-group">
                <label for="message" style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Nội dung tin nhắn</label>
                <textarea id="message" name="message" class="glass-input" rows="4" placeholder="Viết nội dung tin nhắn của bạn ở đây..." required style="width: 100%; resize: vertical; line-height: 1.5;"></textarea>
            </div>
            <button type="submit" class="glass-btn" style="width: 100%; margin-top: 0.5rem;">Gửi Tin Nhắn</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>