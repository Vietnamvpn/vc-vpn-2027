<footer style="margin-top: auto; padding: 2.5rem 1rem 1.5rem; color: var(--ios-text-secondary); font-size: 0.85rem; border-top: 1px solid var(--glass-border, rgba(255, 255, 255, 0.08)); background: rgba(255, 255, 255, 0.02); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px);">
    
    <!-- Khai báo CSS xử lý Responsive Grid 3 cột / 2 cột -->
    <style>
        .vc-footer-grid {
            display: grid;
            grid-template-columns: repeat(3, 1fr);
            gap: 2rem;
            width: 100%;
        }
        .vc-footer-support {
            text-align: left;
            align-items: flex-start;
        }
        .vc-footer-brand {
            text-align: center;
            align-items: center;
        }
        .vc-footer-policies {
            text-align: right;
            align-items: flex-end;
        }
        
        /* Mobile & Tablet */
        @media (max-width: 768px) {
            .vc-footer-grid {
                grid-template-columns: repeat(2, 1fr);
            }
            .vc-footer-brand {
                grid-column: span 2;
                order: -1; /* Đưa Tên website lên trên cùng ở mobile */
                margin-bottom: 0.5rem;
            }
            .vc-footer-support {
                order: 1; /* Nằm dưới, cột trái */
            }
            .vc-footer-policies {
                order: 2; /* Nằm dưới, cột phải */
            }
        }
    </style>

    <div class="container" style="max-width: 1100px; margin: 0 auto; display: flex; flex-direction: column; gap: 2rem;">
        
        <div class="vc-footer-grid">
            
            <!-- CỘT 1 (Bên Trái): Thông tin hỗ trợ -->
            <div class="vc-footer-support" style="display: flex; flex-direction: column; gap: 1rem;">
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

            <!-- CỘT 2 (Ở Giữa): Tên Website -->
            <div class="vc-footer-brand" style="display: flex; flex-direction: column; justify-content: flex-start;">
                <h3 style="font-size: 1.5rem; font-weight: 700; color: #ffffff; margin: 0; letter-spacing: -0.3px;">
                    <?= htmlspecialchars($settings['site_title'] ?? 'VC VPN 2027') ?>
                </h3>
            </div>

            <!-- CỘT 3 (Bên Phải): Chính sách -->
            <div class="vc-footer-policies" style="display: flex; flex-direction: column; gap: 1rem;">
                <h4 style="font-size: 0.85rem; font-weight: 700; color: #ffffff; margin: 0; text-transform: uppercase; letter-spacing: 0.5px; opacity: 0.9;">
                    Chính Sách
                </h4>
                <div class="footer-links" style="display: flex; flex-direction: column; gap: 0.8rem; font-size: 0.85rem; font-weight: 500;">
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