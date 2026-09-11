<?php
$pageTitle = "Gói Dịch Vụ - " . ($settings['site_name'] ?? 'VC VPN 2027');

$currencySymbol = $settings['currency_symbol'] ?? 'đ';
$currencyCode   = $settings['currency'] ?? 'VND';

// Kiểm tra trạng thái đăng nhập của người dùng
$isLoggedIn = !empty($_SESSION['user']) || !empty($_SESSION['user_id']);

// Nhóm các gói dịch vụ theo Nhóm Máy Chủ (group_name)
$groupedPlans = [];
if (!empty($plans) && is_array($plans)) {
    foreach ($plans as $plan) {
        $groupName = !empty($plan['group_name']) ? $plan['group_name'] : 'Gói Tiêu Chuẩn';
        $groupedPlans[$groupName][] = $plan;
    }
}

ob_start();
?>

<style>
/* Hiệu ứng lắp ráp khi mở trang (Assembly Entrance) */
@keyframes assembleIn {
    0% {
        opacity: 0;
        transform: translateY(40px) scale(0.92);
        filter: blur(5px);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
        filter: blur(0);
    }
}

.plan-card {
    display: flex;
    flex-direction: column;
    justify-content: space-between;
    opacity: 0;
    animation: assembleIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), 
                box-shadow 0.35s ease, 
                border-color 0.35s ease;
    border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.15));
    position: relative;
    overflow: hidden;
}

/* Hiệu ứng di chuột: Nhô nhẹ lên & viền phát sáng */
.plan-card:hover {
    transform: translateY(-8px) scale(1.02);
    border-color: var(--ios-blue, #007aff);
    box-shadow: 0 12px 30px rgba(0, 122, 255, 0.25), 
                0 0 20px rgba(0, 122, 255, 0.2);
}

.plan-group-title {
    font-size: 1.35rem;
    font-weight: 700;
    margin-bottom: 1.25rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    color: var(--ios-text, #ffffff);
    border-bottom: 2px solid var(--glass-border, rgba(255, 255, 255, 0.1));
    padding-bottom: 0.5rem;
}
</style>

<div style="text-align: center; margin-bottom: 2.5rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">Bảng Giá Dịch Vụ</h1>
    <p style="color: var(--ios-text-secondary); margin-top: 0.5rem;">Lựa chọn gói VPN phù hợp nhất với nhu cầu sử dụng của bạn</p>
</div>

<?php if (!empty($groupedPlans)): ?>
    <?php 
    $cardIndex = 0; 
    foreach ($groupedPlans as $groupName => $groupPlans): 
    ?>
        <div style="margin-bottom: 3rem;">
            <div class="plan-group-title">
                <span>⚡</span> <?= htmlspecialchars($groupName) ?>
            </div>
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
                <?php foreach ($groupPlans as $plan): ?>
                    <?php
                    $cardIndex++;
                    $animationDelay = number_format($cardIndex * 0.08, 2);
                    
                    $bandwidthGB = (int)($plan['bandwidth_limit_gb'] ?? 0);
                    if ($bandwidthGB <= 0) {
                        $bandwidthText = 'Không giới hạn';
                    } elseif ($bandwidthGB < 1) {
                        $bandwidthText = round($bandwidthGB * 1024, 0) . ' MB';
                    } else {
                        $bandwidthText = $bandwidthGB . ' GB';
                    }

                    // Đi qua lớp xác thực: nếu chưa đăng nhập sẽ chuyển hướng sang trang Đăng nhập kèm link quay lại
                    $registerUrl = $isLoggedIn 
                        ? '/checkout?id=' . (int)$plan['id'] 
                        : '/login?redirect=' . urlencode('/checkout?id=' . (int)$plan['id']);
                    ?>
                    <div class="glass-card plan-card" style="animation-delay: <?= $animationDelay ?>s;">
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
                        <a href="<?= $registerUrl ?>" class="glass-btn" style="width: 100%; text-align: center; text-decoration: none;">Đăng Ký Ngay</a>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    <?php endforeach; ?>
<?php else: ?>
    <div class="glass-card" style="text-align: center; padding: 3rem; color: var(--ios-text-secondary);">
        <p style="font-size: 1.1rem; margin-bottom: 1rem;">Hiện chưa có gói dịch vụ nào mở bán.</p>
        <a href="/" class="glass-btn" style="text-decoration: none;">Quay Về Trang Chủ</a>
    </div>
<?php endif; ?>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>