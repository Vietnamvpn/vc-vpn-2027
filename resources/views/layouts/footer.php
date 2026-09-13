<footer style="margin-top: auto; padding: 2.5rem 1rem 1.5rem; color: var(--ios-text-secondary); font-size: 0.85rem; border-top: 1px solid var(--glass-border, rgba(255, 255, 255, 0.08)); background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
    <div class="container" style="max-width: 1100px; margin: 0 auto; display: flex; flex-direction: column; gap: 2rem;">
        
        <!-- Bố cục 2 cột chính -->
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem; align-items: start;">
            
            <!-- CỘT 1: Thương hiệu, Mô tả & Các điều khoản -->
            <div style="display: flex; flex-direction: column; gap: 0.8rem; text-align: left;">
                <h3 style="font-size: 1.15rem; font-weight: 700; color: #ffffff; margin: 0; letter-spacing: -0.3px;">
                    <?= htmlspecialchars($settings['site_title'] ?? 'VC VPN 2027') ?>
                </h3>
                
                <?php if (!empty($settings['site_description'])): ?>
                    <p style="margin: 0; opacity: 0.75; font-size: 0.8rem; line-height: 1.5; max-width: 450px;">
                        <?= htmlspecialchars($settings['site_description']) ?>
                    </p>
                <?php endif; ?>

                <!-- Nút liên kết chính sách với màu sắc nhẹ nhàng -->
                <div class="footer-links" style="display: flex; flex-wrap: wrap; gap: 0.75rem 1rem; margin-top: 0.5rem; font-size: 0.8rem; font-weight: 500;">
                    <a href="/terms" style="color: #64d2ff; text-decoration: none; transition: opacity 0.2s;">Điều Khoản Dịch Vụ</a>
                    <span style="opacity: 0.2; color: #fff;">•</span>
                    <a href="/privacy" style="color: #30d158; text-decoration: none; transition: opacity 0.2s;">Quyền Riêng Tư</a>
                    <span style="opacity: 0.2; color: #fff;">•</span>
                    <a href="/refund" style="color: #ff9f0a; text-decoration: none; transition: opacity 0.2s;">Chính Sách Hoàn Tiền</a>
                </div>
            </div>

            <!-- CỘT 2: Thông tin liên hệ linh động lấy từ SQL ($settings) -->
            <div style="display: flex; flex-direction: column; gap: 0.8rem; text-align: left;">
                <h4 style="font-size: 0.85rem; font-weight: 700; color: #ffffff; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">
                    Kênh Hỗ Trợ & Liên Hệ
                </h4>
                
                <?php if (!empty($settings)): ?>
                    <div style="display: flex; flex-wrap: wrap; gap: 0.5rem 0.6rem;">
                        <?php if (!empty($settings['contact_email'])): ?>
                            <a href="mailto:<?= htmlspecialchars($settings['contact_email']) ?>" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.85rem; background: rgba(175, 82, 222, 0.12); border: 1px solid rgba(175, 82, 222, 0.3); border-radius: 8px; color: #bf5af2; text-decoration: none; font-size: 0.8rem; font-weight: 500;">
                                <span>📧</span> <?= htmlspecialchars($settings['contact_email']) ?>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['fanpage_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['fanpage_url']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.85rem; background: rgba(10, 132, 255, 0.12); border: 1px solid rgba(10, 132, 255, 0.3); border-radius: 8px; color: #0a84ff; text-decoration: none; font-size: 0.8rem; font-weight: 500;">
                                <span>🌐</span> Fanpage Hỗ Trợ
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['zalo_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['zalo_url']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.85rem; background: rgba(48, 209, 88, 0.12); border: 1px solid rgba(48, 209, 88, 0.3); border-radius: 8px; color: #30d158; text-decoration: none; font-size: 0.8rem; font-weight: 500;">
                                <span>💬</span> Zalo
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['youtube_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['youtube_url']) ?>" target="_blank" rel="noopener noreferrer" style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.85rem; background: rgba(255, 69, 58, 0.12); border: 1px solid rgba(255, 69, 58, 0.3); border-radius: 8px; color: #ff453a; text-decoration: none; font-size: 0.8rem; font-weight: 500;">
                                <span>▶️</span> Youtube
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['wechat_id'])): ?>
                            <span style="display: inline-flex; align-items: center; gap: 0.4rem; padding: 0.45rem 0.85rem; background: rgba(52, 199, 89, 0.12); border: 1px solid rgba(52, 199, 89, 0.3); border-radius: 8px; color: #32d74b; font-size: 0.8rem; font-weight: 500;">
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