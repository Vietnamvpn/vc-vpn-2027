<footer style="margin-top: auto; padding: 2rem 1rem; text-align: center; color: var(--ios-text-secondary); font-size: 0.85rem; border-top: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1));">
    <div class="container" style="max-width: 1200px; margin: 0 auto; display: flex; flex-direction: column; gap: 1rem; align-items: center;">
        
        <!-- Thông tin liên hệ linh động từ DB ($settings) -->
        <?php if (!empty($settings)): ?>
            <div class="footer-contact" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem 1.5rem; font-weight: 500;">
                <?php if (!empty($settings['contact_email'])): ?>
                    <a href="mailto:<?= htmlspecialchars($settings['contact_email']) ?>" style="color: inherit; text-decoration: none;">📧 <?= htmlspecialchars($settings['contact_email']) ?></a>
                <?php endif; ?>
                <?php if (!empty($settings['fanpage_url'])): ?>
                    <a href="<?= htmlspecialchars($settings['fanpage_url']) ?>" target="_blank" rel="noopener noreferrer" style="color: inherit; text-decoration: none;">🌐 Fanpage</a>
                <?php endif; ?>
                <?php if (!empty($settings['zalo_url'])): ?>
                    <a href="<?= htmlspecialchars($settings['zalo_url']) ?>" target="_blank" rel="noopener noreferrer" style="color: inherit; text-decoration: none;">💬 Zalo</a>
                <?php endif; ?>
                <?php if (!empty($settings['youtube_url'])): ?>
                    <a href="<?= htmlspecialchars($settings['youtube_url']) ?>" target="_blank" rel="noopener noreferrer" style="color: inherit; text-decoration: none;">▶️ Youtube</a>
                <?php endif; ?>
                <?php if (!empty($settings['wechat_id'])): ?>
                    <span>💬 WeChat: <?= htmlspecialchars($settings['wechat_id']) ?></span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Các nút Điều khoản, Quyền riêng tư, Chính sách hoàn tiền -->
        <div class="footer-links" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1rem 1.5rem; font-weight: 500;">
            <a href="/terms" style="color: inherit; text-decoration: none;">Điều Khoản Dịch Vụ</a>
            <span style="opacity: 0.4;">|</span>
            <a href="/privacy" style="color: inherit; text-decoration: none;">Quyền Riêng Tư</a>
            <span style="opacity: 0.4;">|</span>
            <a href="/refund" style="color: inherit; text-decoration: none;">Chính Sách Hoàn Tiền</a>
        </div>

        <!-- Bản quyền -->
        <p style="margin: 0; opacity: 0.8;">&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['site_title'] ?? 'VC VPN 2027') ?>. All rights reserved.</p>
    </div>
</footer>

<!-- Luôn tải app.js với tham số xóa cache -->
<script src="/assets/js/app.js?v=<?= time() ?>"></script>

<!-- Chỉ tải extraJs nếu khác file app.js -->
<?php if (isset($extraJs) && $extraJs !== 'app'): ?>
    <script src="/assets/js/<?= $extraJs ?>.js?v=<?= time() ?>"></script>
<?php endif; ?>
</body>
</html>