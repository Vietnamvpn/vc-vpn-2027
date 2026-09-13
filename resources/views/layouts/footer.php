<footer style="margin-top: auto; padding: 2.5rem 1rem 1.5rem; color: var(--ios-text-secondary); font-size: 0.85rem; border-top: 1px solid var(--glass-border, rgba(255, 255, 255, 0.08)); background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
    <div class="container" style="max-width: 1100px; margin: 0 auto; display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Tên Website ở giữa -->
        <div style="text-align: center;">
            <h3 style="font-size: 1.5rem; font-weight: 700; color: #ffffff; margin: 0; letter-spacing: -0.3px;">
                <?= htmlspecialchars($settings['site_title'] ?? 'VC VPN 2027') ?>
            </h3>
        </div>
        
        <!-- Bố cục 2 cột dọc xuống -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 2rem; max-width: 800px; margin: 0 auto; width: 100%;">
            
            <!-- CỘT 1: Chính sách -->
            <div style="display: flex; flex-direction: column; gap: 1rem; text-align: left;">
                <h4 style="font-size: 0.85rem; font-weight: 700; color: #ffffff; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">
                    Chính Sách
                </h4>
                <div class="footer-links" style="display: flex; flex-direction: column; gap: 0.8rem; font-size: 0.85rem; font-weight: 500;">
                    <a href="/terms" style="color: #64d2ff; text-decoration: none; transition: opacity 0.2s;">Điều Khoản Dịch Vụ</a>
                    <a href="/privacy" style="color: #30d158; text-decoration: none; transition: opacity 0.2s;">Quyền Riêng Tư</a>
                    <a href="/refund" style="color: #ff9f0a; text-decoration: none; transition: opacity 0.2s;">Chính Sách Hoàn Tiền</a>
                </div>
            </div>

            <!-- CỘT 2: Thông tin hỗ trợ -->
            <div style="display: flex; flex-direction: column; gap: 1rem; text-align: left;">
                <h4 style="font-size: 0.85rem; font-weight: 700; color: #ffffff; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">
                    Kênh Hỗ Trợ & Liên Hệ
                </h4>
                
                <?php if (!empty($settings)): ?>
                    <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                        <?php if (!empty($settings['contact_email'])): ?>
                            <a href="mailto:<?= htmlspecialchars($settings['contact_email']) ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #bf5af2; text-decoration: none; font-size: 0.85rem; font-weight: 500;">
                                <span>📧</span> <?= htmlspecialchars($settings['contact_email']) ?>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['fanpage_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['fanpage_url']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #0a84ff; text-decoration: none; font-size: 0.85rem; font-weight: 500;">
                                <span>🌐</span> Fanpage Hỗ Trợ
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['zalo_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['zalo_url']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #30d158; text-decoration: none; font-size: 0.85rem; font-weight: 500;">
                                <span>💬</span> Zalo
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['youtube_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['youtube_url']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #ff453a; text-decoration: none; font-size: 0.85rem; font-weight: 500;">
                                <span>▶️</span> Youtube
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['wechat_id'])): ?>
                            <span style="display: inline-flex; align-items: center; gap: 0.5rem; color: #32d74b; font-size: 0.85rem; font-weight: 500;">
                                <span>💬</span> WeChat: <?= htmlspecialchars($settings['wechat_id']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- Bản quyền & Đường phân cách -->
        <div style="border-top: 1px solid var(--glass-border, rgba(255, 255, 255, 0.08)); padding-top: 1rem; text-align: center;">
            <p style="margin: 0; opacity: 0.6; font-size: 0.78rem;">&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['site_title'] ?? 'VC VPN 2027') ?>. All rights reserved.</p>
        </div>

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