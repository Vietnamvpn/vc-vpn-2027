<?php
$pageTitle = "Gói Dịch Vụ - " . ($settings['site_name'] ?? 'VC VPN 2027');

$currencySymbol = $settings['currency_symbol'] ?? 'đ';
$currencyCode   = $settings['currency'] ?? 'VND';

ob_start();
?>

<div style="text-align: center; margin-bottom: 2.5rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">Bảng Giá Dịch Vụ</h1>
    <p style="color: var(--ios-text-secondary); margin-top: 0.5rem;">Lựa chọn gói VPN phù hợp nhất với nhu cầu sử dụng của bạn</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
    <?php if (!empty($plans) && is_array($plans)): ?>
        <?php foreach ($plans as $plan): ?>
            <?php
            $bandwidthGB = (int)($plan['bandwidth_limit_gb'] ?? 0);
            if ($bandwidthGB <= 0) {
                $bandwidthText = 'Không giới hạn';
            } elseif ($bandwidthGB < 1) {
                $bandwidthText = round($bandwidthGB * 1024, 0) . ' MB';
            } else {
                $bandwidthText = $bandwidthGB . ' GB';
            }
            ?>
            <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;"><?= htmlspecialchars($plan['name']) ?></h3>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--ios-blue); margin-bottom: 1rem;">
                        <?= isset($formatMoney) ? $formatMoney($plan['price']) : number_format($plan['price'], 2) ?>
                        <span style="font-size: 0.9rem; font-weight: 400; color: var(--ios-text-secondary);">/ <?= (int)$plan['duration_days'] ?> ngày</span>
                    </div>
                    <ul style="list-style: none; padding: 0; margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                        <li style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--ios-success);">✓</span> Dung lượng: <strong><?= $bandwidthText ?></strong>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--ios-success);">✓</span> Số thiết bị tối đa: <strong><?= (int)$plan['max_devices'] ?> thiết bị</strong>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--ios-success);">✓</span> Nhóm máy chủ: <strong><?= htmlspecialchars($plan['group_name'] ?? 'Tiêu chuẩn') ?></strong>
                        </li>
                        <?php if (!empty($plan['description'])): ?>
                            <li style="display: flex; align-items: flex-start; gap: 0.5rem; color: var(--ios-text-secondary); font-size: 0.85rem; line-height: 1.4;">
                                <span style="color: var(--ios-blue);">ℹ</span> <?= nl2br(htmlspecialchars($plan['description'])) ?>
                            </li>
                        <?php endif; ?>
                    </ul>
                </div>
                <a href="/user/plans/checkout?id=<?= $plan['id'] ?>" class="glass-btn" style="width: 100%; text-align: center; text-decoration: none;">Đăng Ký Ngay</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="glass-card" style="text-align: center; padding: 3rem; grid-column: 1 / -1; color: var(--ios-text-secondary);">
            <p style="font-size: 1.1rem; margin-bottom: 1rem;">Hiện chưa có gói dịch vụ nào mở bán.</p>
            <a href="/" class="glass-btn" style="text-decoration: none;">Quay Về Trang Chủ</a>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>