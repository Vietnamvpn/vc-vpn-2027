<footer style="margin-top: auto; padding: 2.5rem 1rem 1.5rem; color: var(--ios-text-secondary); font-size: 0.85rem; border-top: 1px solid var(--glass-border, rgba(255, 255, 255, 0.08)); background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
    <div class="container" style="max-width: 1100px; margin: 0 auto; display: flex; flex-direction: column; gap: 1.5rem; align-items: center;">

        <!-- Thông tin liên hệ linh động từ DB ($settings) dạng Badge Glass -->
        <?php if (!empty($settings)): ?>
            <div class="footer-contact-group" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 0.6rem 0.8rem; align-items: center;">
                <?php if (!empty($settings['contact_email'])): ?>
                    <a href="mailto:<?= htmlspecialchars($settings['contact_email']) ?>" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.9rem; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1)); border-radius: 20px; color: inherit; text-decoration: none; font-size: 0.8rem; font-weight: 500; transition: all 0.2s ease;">
                        <span>📧</span> <?= htmlspecialchars($settings['contact_email']) ?>
                    </a>
                <?php endif; ?>

                <?php if (!empty($settings['fanpage_url'])): ?>
                    <a href="<?= htmlspecialchars($settings['fanpage_url']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.9rem; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1)); border-radius: 20px; color: inherit; text-decoration: none; font-size: 0.8rem; font-weight: 500; transition: all 0.2s ease;">
                        <span>🌐</span> Fanpage
                    </a>
                <?php endif; ?>

                <?php if (!empty($settings['zalo_url'])): ?>
                    <a href="<?= htmlspecialchars($settings['zalo_url']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.9rem; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1)); border-radius: 20px; color: inherit; text-decoration: none; font-size: 0.8rem; font-weight: 500; transition: all 0.2s ease;">
                        <span>💬</span> Zalo
                    </a>
                <?php endif; ?>

                <?php if (!empty($settings['youtube_url'])): ?>
                    <a href="<?= htmlspecialchars($settings['youtube_url']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.9rem; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1)); border-radius: 20px; color: inherit; text-decoration: none; font-size: 0.8rem; font-weight: 500; transition: all 0.2s ease;">
                        <span>▶️</span> Youtube
                    </a>
                <?php endif; ?>

                <?php if (!empty($settings['wechat_id'])): ?>
                    <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.9rem; background: rgba(255, 255, 255, 0.04); border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1)); border-radius: 20px; color: inherit; font-size: 0.8rem; font-weight: 500;">
                        <span>💬</span> WeChat: <?= htmlspecialchars($settings['wechat_id']) ?>
                    </span>
                <?php endif; ?>
            </div>
        <?php endif; ?>

        <!-- Các nút Điều khoản, Quyền riêng tư, Chính sách hoàn tiền -->
        <div class="footer-links" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 1.25rem; font-weight: 500; font-size: 0.85rem;">
            <a href="/terms" style="color: inherit; text-decoration: none; opacity: 0.85; transition: opacity 0.2s;">Điều Khoản Dịch Vụ</a>
            <span style="opacity: 0.2;">•</span>
            <a href="/privacy" style="color: inherit; text-decoration: none; opacity: 0.85; transition: opacity 0.2s;">Quyền Riêng Tư</a>
            <span style="opacity: 0.2;">•</span>
            <a href="/refund" style="color: inherit; text-decoration: none; opacity: 0.85; transition: opacity 0.2s;">Chính Sách Hoàn Tiền</a>
        </div>

        <!-- Đường gạch nhẹ phân cách -->
        <div style="border-top: 1px dashed var(--glass-border, rgba(255, 255, 255, 0.08)); width: 100%; max-width: 300px; margin-top: 0.25rem;"></div>

        <!-- Bản quyền -->
        <p style="margin: 0; opacity: 0.65; font-size: 0.8rem;">&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['site_title'] ?? 'VC VPN 2027') ?>. All rights reserved.</p>
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