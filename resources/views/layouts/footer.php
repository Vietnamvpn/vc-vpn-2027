<footer style="margin-top: auto; padding: 2.5rem 1rem 1.5rem; color: #333333; font-size: 0.85rem; border-top: 1px solid rgba(0, 0, 0, 0.1); background: rgba(233, 239, 245, 0.85); backdrop-filter: blur(10px); -webkit-backdrop-filter: blur(10px); width: 100vw; position: relative; left: 50%; transform: translateX(-50%);">
    
    <style>
        /* Bố cục flex để tự động co giãn tối đa, chỉ xuống hàng khi khoảng trống mỗi cột < 160px */
        .vc-footer-links-grid {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            gap: 1.5rem;
            width: 100%;
        }
        
        .vc-footer-col {
            flex: 1 1 auto;
            min-width: 160px; /* Ép xuống hàng khi không đủ 160px */
            display: flex;
            flex-direction: column;
            text-align: left;
        }

        .vc-footer-col h4 {
            font-size: 0.85rem;
            font-weight: 700;
            color: #333333;
            margin: 0 0 1rem 0;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }

        .vc-footer-col a, .vc-footer-col span.wechat-text {
            text-decoration: none;
            font-size: 0.85rem;
            font-weight: 600;
            transition: opacity 0.2s;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .vc-footer-col a:hover {
            opacity: 0.7;
        }
    </style>

    <div class="container" style="max-width: 1100px; margin: 0 auto; display: flex; flex-direction: column; gap: 2.5rem;">
        
        <!-- Tên Website ở giữa -->
        <div style="text-align: center;">
            <h3 style="font-size: 1.5rem; font-weight: 800; color: #007bff; margin: 0; letter-spacing: -0.3px;">
                <?= htmlspecialchars($settings['site_title'] ?? 'VC VPN 2027') ?>
            </h3>
        </div>
        
        <!-- Bố cục tự động co giãn -->
        <div class="vc-footer-links-grid">

            <!-- Cột 1: Mạng Xã Hội -->
            <div class="vc-footer-col">
                <h4>Mạng Xã Hội</h4>
                <?php if (!empty($settings)): ?>
                    <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                        <?php if (!empty($settings['fanpage_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['fanpage_url']) ?>" target="_blank" rel="noopener noreferrer" style="color: #0056b3;">
                                <span>🌐</span> Fanpage Hỗ Trợ
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['zalo_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['zalo_url']) ?>" target="_blank" rel="noopener noreferrer" style="color: #28a745;">
                                <span>💬</span> Zalo
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['youtube_url'])): ?>
                            <a href="<?= htmlspecialchars($settings['youtube_url']) ?>" target="_blank" rel="noopener noreferrer" style="color: #dc3545;">
                                <span>▶️</span> Youtube
                            </a>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

            <!-- Cột 2: Chính Sách -->
            <div class="vc-footer-col">
                <h4>Chính Sách</h4>
                <div style="display: flex; flex-direction: column; gap: 0.8rem; width: 100%;">
                    <a href="/terms" style="color: #0056b3;">Điều Khoản Dịch Vụ</a>
                    <a href="/privacy" style="color: #28a745;">Quyền Riêng Tư</a>
                    <a href="/refund" style="color: #d35400;">Chính Sách Hoàn Tiền</a>
                </div>
            </div>

            <!-- Cột 3: Liên Hệ Hỗ Trợ -->
            <div class="vc-footer-col">
                <h4>Liên Hệ Hỗ Trợ</h4>
                <?php if (!empty($settings)): ?>
                    <div style="display: flex; flex-direction: column; gap: 0.8rem;">
                        <?php if (!empty($settings['contact_email'])): ?>
                            <a href="mailto:<?= htmlspecialchars($settings['contact_email']) ?>" style="color: #6f42c1;">
                                <span>📧</span> <?= htmlspecialchars($settings['contact_email']) ?>
                            </a>
                        <?php endif; ?>

                        <?php if (!empty($settings['wechat_id'])): ?>
                            <span class="wechat-text" style="color: #1e7e34;">
                                <span>💬</span> WeChat: <?= htmlspecialchars($settings['wechat_id']) ?>
                            </span>
                        <?php endif; ?>
                    </div>
                <?php endif; ?>
            </div>

        </div>

        <!-- Bản quyền & Đường phân cách -->
        <div style="border-top: 1px solid rgba(0, 0, 0, 0.1); padding-top: 1rem; text-align: center;">
            <p style="margin: 0; color: #6c757d; font-size: 0.78rem;">&copy; <?= date('Y') ?> <?= htmlspecialchars($settings['site_title'] ?? 'VC VPN 2027') ?>. All rights reserved.</p>
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