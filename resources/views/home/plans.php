<?php
$pageTitle = "Gói Dịch Vụ - VC VPN 2027";
ob_start();
?>

<div style="text-align: center; margin-bottom: 2.5rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">Bảng Giá Dịch Vụ</h1>
    <p style="color: var(--ios-text-secondary); margin-top: 0.5rem;">Lựa chọn gói VPN phù hợp nhất với nhu cầu sử dụng của bạn</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 1.5rem;">
    <?php if (!empty($plans) && is_array($plans)): ?>
        <?php foreach ($plans as $plan): ?>
            <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between;">
                <div>
                    <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;"><?= htmlspecialchars($plan['name']) ?></h3>
                    <div style="font-size: 2rem; font-weight: 800; color: var(--ios-blue); margin-bottom: 1rem;">
                        <?= number_format($plan['price'], 0, ',', '.') ?> <span style="font-size: 0.9rem; font-weight: 400; color: var(--ios-text-secondary);">VNĐ / <?= $plan['duration_days'] ?> ngày</span>
                    </div>
                    <ul style="list-style: none; padding: 0; margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                        <li style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--ios-success);">✓</span> Dung lượng: <strong><?= $plan['bandwidth_limit_gb'] > 0 ? $plan['bandwidth_limit_gb'] . ' GB' : 'Không giới hạn' ?></strong>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--ios-success);">✓</span> Số thiết bị tối đa: <strong><?= $plan['max_devices'] ?> thiết bị</strong>
                        </li>
                        <li style="display: flex; align-items: center; gap: 0.5rem;">
                            <span style="color: var(--ios-success);">✓</span> Băng thông tốc độ cao
                        </li>
                    </ul>
                </div>
                <a href="/user/plans/checkout?id=<?= $plan['id'] ?>" class="glass-btn" style="width: 100%; text-align: center;">Đăng Ký Ngay</a>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="glass-card" style="display: flex; flex-direction: column; justify-content: space-between;">
            <div>
                <h3 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Gói Cơ Bản</h3>
                <div style="font-size: 2rem; font-weight: 800; color: var(--ios-blue); margin-bottom: 1rem;">
                    50.000 <span style="font-size: 0.9rem; font-weight: 400; color: var(--ios-text-secondary);">VNĐ / 30 ngày</span>
                </div>
                <ul style="list-style: none; padding: 0; margin-bottom: 1.5rem; display: flex; flex-direction: column; gap: 0.75rem; font-size: 0.9rem;">
                    <li style="display: flex; align-items: center; gap: 0.5rem;"><span style="color: var(--ios-success);">✓</span> Dung lượng: 100 GB</li>
                    <li style="display: flex; align-items: center; gap: 0.5rem;"><span style="color: var(--ios-success);">✓</span> Số thiết bị: 2 thiết bị</li>
                    <li style="display: flex; align-items: center; gap: 0.5rem;"><span style="color: var(--ios-success);">✓</span> Băng thông tốc độ cao</li>
                </ul>
            </div>
            <a href="/auth/register" class="glass-btn" style="width: 100%; text-align: center;">Mua Ngay</a>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>