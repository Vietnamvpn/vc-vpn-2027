<?php
$pageTitle = "Gói Dịch Vụ - " . ($settings['site_name'] ?? 'VC VPN 2027');

$currencySymbol = $settings['currency_symbol'] ?? 'đ';
$currencyCode   = $settings['currency'] ?? 'VND';

// Kiểm tra trạng thái đăng nhập của người dùng
$isLoggedIn = !empty($_SESSION['user']) || !empty($_SESSION['user_id']);

// Nhóm các gói dịch vụ linh hoạt theo Nhóm Máy Chủ từ database
$groupedPlans = [];
if (!empty($plans) && is_array($plans)) {
    foreach ($plans as $plan) {
        $groupName = !empty($plan['group_name']) 
            ? $plan['group_name'] 
            : (!empty($plan['server_group_name']) 
                ? $plan['server_group_name'] 
                : (!empty($plan['group_id']) || !empty($plan['server_group_id']) 
                    ? 'Nhóm Máy Chủ #' . ($plan['group_id'] ?? $plan['server_group_id']) 
                    : 'Gói Tiêu Chuẩn'));
                    
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
        transform: translateY(35px) scale(0.93);
        filter: blur(6px);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
        filter: blur(0);
    }
}

/* Khung phân vùng theo nhóm */
.plan-group-section {
    background: rgba(255, 255, 255, 0.03);
    border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.12));
    border-radius: 20px;
    padding: 1.75rem;
    margin-bottom: 2.5rem;
    backdrop-filter: blur(12px);
    -webkit-backdrop-filter: blur(12px);
    box-sizing: border-box;
    width: 100%;
}

.plan-group-header {
    font-size: 1.35rem;
    font-weight: 700;
    margin-bottom: 1.5rem;
    display: flex;
    align-items: center;
    gap: 0.6rem;
    color: var(--ios-text, #ffffff);
    border-bottom: 1px solid var(--glass-border, rgba(255, 255, 255, 0.1));
    padding-bottom: 0.75rem;
    word-break: break-word;
}

.plans-grid {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
    gap: 1.5rem;
    width: 100%;
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
    box-sizing: border-box;
    word-break: break-word;
}

/* Hiệu ứng di chuột: Nhô nhẹ lên & viền phát sáng */
.plan-card:hover {
    transform: translateY(-8px) scale(1.02);
    border-color: var(--ios-blue, #007aff);
    box-shadow: 0 12px 30px rgba(0, 122, 255, 0.25), 
                0 0 20px rgba(0, 122, 255, 0.2);
}

/* Tối ưu hóa cho màn hình nhỏ (Mobile & Tablet) */
@media (max-width: 768px) {
    .plan-group-section {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 14px;
    }
    .plan-group-header {
        font-size: 1.15rem;
        margin-bottom: 1rem;
    }
    .plans-grid {
        grid-template-columns: 1fr;
        gap: 1rem;
    }
    .plan-card {
        padding: 1.25rem !important;
    }
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
        <!-- Phân vùng hiển thị riêng cho từng Nhóm Máy Chủ -->
        <div class="plan-group-section">
            <div class="plan-group-header">
                <span>⚡</span> <?= htmlspecialchars($groupName) ?>
            </div>

            <div class="plans-grid">
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

                    // Đi qua lớp xác thực: nếu chưa đăng nhập sẽ tới trang /login kèm tham số quay lại /checkout
                    $targetCheckout = '/checkout?id=' . (int)$plan['id'];
                    $registerUrl    = $isLoggedIn 
                        ? $targetCheckout 
                        : '/login?redirect=' . urlencode($targetCheckout);
                    ?>
                    <div class="glass-card plan-card" style="animation-delay: <?= $animationDelay ?>s;">
                        <div>
                            <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;"><?= htmlspecialchars($plan['name']) ?></h3>
                            <div style="font-size: 1.8rem; font-weight: 800; color: var(--ios-blue); margin-bottom: 1rem; flex-wrap: wrap;">
                                <?= isset($formatMoney) ? $formatMoney($plan['price']) : number_format($plan['price'], 2) ?>
                                <span style="font-size: 0.85rem; font-weight: 400; color: var(--ios-text-secondary);">/ <?= (int)$plan['duration_days'] ?> ngày</span>
                            </div>
                            <ul style="list-style: none; padding: 0; margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                                <li style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="color: var(--ios-success);">✓</span> Dung lượng: <strong><?= $bandwidthText ?></strong>
                                </li>
                                <li style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="color: var(--ios-success);">✓</span> Số thiết bị tối đa: <strong><?= (int)($plan['max_devices'] ?? 1) ?> thiết bị</strong>
                                </li>
                                <li style="display: flex; align-items: center; gap: 0.5rem;">
                                    <span style="color: var(--ios-success);">✓</span> Nhóm máy chủ: <strong><?= htmlspecialchars($groupName) ?></strong>
                                </li>
                                <?php if (!empty($plan['description'])): ?>
                                    <li style="display: flex; align-items: flex-start; gap: 0.5rem; color: var(--ios-text-secondary); font-size: 0.85rem; line-height: 1.4;">
                                        <span style="color: var(--ios-blue);">ℹ</span> <?= nl2br(htmlspecialchars($plan['description'])) ?>
                                    </li>
                                <?php endif; ?>
                            </ul>
                        </div>
                        <a href="<?= $registerUrl ?>" class="glass-btn" style="width: 100%; text-align: center; text-decoration: none; box-sizing: border-box;">Đăng Ký Ngay</a>
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