<footer style="margin-top: auto; padding: 2.5rem 1rem 1.5rem; color: var(--ios-text-secondary); font-size: 0.85rem; border-top: 1px solid var(--glass-border, rgba(255, 255, 255, 0.08)); background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
    
    <style>
        /* Bố cục chia 3 cột */
        .vc-footer-links-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            width: 100%;
        }
        
        /* Cột Liên hệ & Mạng xã hội */
        .vc-info-col {
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        /* Cột chính sách ép sang phải và căn chữ lề phải */
        .vc-policy-col {
            display: flex;
            flex-direction: column;
            align-items: flex-end;
            text-align: right;
        }
        
        /* Màn hình nhỏ (Mobile/Tablet) chuyển về 2 cột */
        @media (max-width: 768px) {
            .vc-footer-links-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .vc-policy-col {
                grid-column: span 2; /* Chính sách rớt xuống hàng dưới chiếm 2 cột để giữ lề phải */
            }
        }
    </style>

    <div class="container" style="max-width: 1100px; margin: 0 auto; display: flex; flex-direction: column; gap: 2.5rem;">
        
        <!-- Tên Website ở giữa -->
        <div style="text-align: center;">
            <h3 style="font-size: 1.5rem; font-weight: 700; color: #ffffff; margin: 0; letter-spacing: -0.3px;">
                <?= htmlspecialchars($settings['site_title'] ?? 'VC VPN 2027') ?>
            </h3>
        </div>
        
        <!-- Bố cục lưới 3 cột (Desktop) / 2 cột (Mobile) -->
        <div class="vc-footer-links-grid">
            
            <!-- Cột 1: Liên Hệ Hỗ Trợ -->
            <div class="vc-info-col">
                <h4 style="font-size: 0.85rem; font-weight: 700; color: #ffffff; margin: 0 0 1rem 0; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">
                    Liên Hệ Hỗ Trợ
                </h4>
                <?php if (!empty($settings)): ?>
                    <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                        <?php if (!empty($settings['contact_email'])): ?>
                            <a href="mailto:<?= htmlspecialchars($settings['contact_email']) ?>" style="display: inline-flex; align-items: center; gap: 0.5rem; color: #bf5af2; text-decoration: none; font-size: 0.85rem; font-weight: 500;">
                                <span>📧</span> <?= htmlspecialchars($settings['contact_email']) ?>
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

            <!-- Cột 2: Mạng Xã Hội -->
            <div class="vc-info-col">
                <h4 style="font-size: 0.85rem; font-weight: 700; color: #ffffff; margin: 0 0 1rem 0; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">
                    Mạng Xã Hội
                </h4>
                <?php if (!empty($settings)): ?>
                    <div style="display: flex; flex-direction: column; gap: 0.8rem;">
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
                    </div>
                <?php endif; ?>
            </div>

            <!-- Cột 3: Chính Sách (Sang phải, căn phải) -->
            <div class="vc-policy-col">
                <h4 style="font-size: 0.85rem; font-weight: 700; color: #ffffff; margin: 0 0 1rem 0; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">
                    Chính Sách
                </h4>
                <div style="display: flex; flex-direction: column; gap: 0.8rem; font-size: 0.85rem; font-weight: 500; text-align: right; width: 100%;">
                    <a href="/terms" style="color: #64d2ff; text-decoration: none; transition: opacity 0.2s;">Điều Khoản Dịch Vụ</a>
                    <a href="/privacy" style="color: #30d158; text-decoration: none; transition: opacity 0.2s;">Quyền Riêng Tư</a>
                    <a href="/refund" style="color: #ff9f0a; text-decoration: none; transition: opacity 0.2s;">Chính Sách Hoàn Tiền</a>
                </div>
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