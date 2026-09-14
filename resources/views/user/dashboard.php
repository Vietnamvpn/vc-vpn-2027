<?php
// Bắt đầu lưu bộ đệm nội dung
ob_start();

// Lấy gói dịch vụ đang hoạt động (nếu có)
$activeSubscription = null;
if (!empty($subscriptions) && is_array($subscriptions)) {
    foreach ($subscriptions as $sub) {
        if (isset($sub['status']) && $sub['status'] === 'active') {
            $activeSubscription = $sub;
            break;
        }
    }
}
?>

<style>
/* CSS Layout riêng cho Dashboard - Đồng bộ với biến màu iOS trong app.css */
.dashboard-grid-4 { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.2rem; margin-bottom: 1.5rem; }
.dashboard-grid-2 { display: grid; grid-template-columns: 1.5fr 1fr; gap: 1.2rem; }
@media (max-width: 768px) { .dashboard-grid-2 { grid-template-columns: 1fr; } }

.stat-label { font-size: 0.75rem; font-weight: 700; color: var(--ios-text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.4rem; }
.stat-value { font-size: 1.6rem; font-weight: 700; color: var(--ios-text); }

.status-active { color: var(--ios-success); }
.status-inactive { color: var(--ios-danger); }

.ref-box { padding: 1.5rem; border: 2px dashed var(--glass-border); border-radius: var(--radius-md); text-align: center; margin: 1rem 0; background: rgba(0, 122, 255, 0.05); }
.ref-code { font-size: 1.5rem; font-weight: 800; color: var(--ios-blue); margin: 0; letter-spacing: 1px; }

.info-list { list-style: none; padding: 0; margin: 0 0 1rem 0; }
.info-list li { padding: 0.85rem 0; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; font-size: 0.9rem; }
.info-list li:last-child { border-bottom: none; }
</style>

<div class="dashboard-grid-4">
    <div class="glass-card">
        <div class="stat-label">Số dư tài khoản</div>
        <div class="stat-value"><?= $formatMoney($user['balance'] ?? 0) ?></div>
    </div>
    <div class="glass-card">
        <div class="stat-label">Hoa hồng giới thiệu</div>
        <div class="stat-value"><?= $formatMoney($user['commission_balance'] ?? 0) ?></div>
    </div>
    <div class="glass-card">
        <div class="stat-label">Gói dịch vụ</div>
        <div class="stat-value" style="font-size: 1.2rem; margin-top: 0.4rem;">
            <?= $activeSubscription ? htmlspecialchars($activeSubscription['plan_name'] ?? 'Đang hoạt động') : 'Chưa có' ?>
        </div>
    </div>
    <div class="glass-card">
        <div class="stat-label">Trạng thái</div>
        <div class="stat-value <?= (($user['status'] ?? '') === 'active') ? 'status-active' : 'status-inactive' ?>">
            <?= ucfirst($user['status'] ?? 'unknown') ?>
        </div>
    </div>
</div>

<div class="dashboard-grid-2">
    <!-- Gói dịch vụ -->
    <div class="glass-card">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.85rem;">
            <h3 style="font-size: 1.05rem; font-weight: 600; margin: 0;">Gói dịch vụ đang hoạt động</h3>
            <a href="/user/subscriptions" style="color: var(--ios-blue); text-decoration: none; font-size: 0.85rem; font-weight: 600;">Xem tất cả</a>
        </div>
        
        <?php if($activeSubscription): ?>
            <ul class="info-list">
                <li>
                    <span style="color: var(--ios-text-secondary); font-weight: 600;">Lưu lượng đã dùng</span>
                    <span style="font-weight: 600;"><?= number_format((($activeSubscription['upload'] ?? 0) + ($activeSubscription['download'] ?? 0)) / 1073741824, 2) ?> GB</span>
                </li>
                <li>
                    <span style="color: var(--ios-text-secondary); font-weight: 600;">Ngày hết hạn</span>
                    <span style="font-weight: 600;"><?= isset($activeSubscription['end_date']) ? date('d/m/Y', strtotime($activeSubscription['end_date'])) : 'N/A' ?></span>
                </li>
            </ul>
            <a href="/user/subscriptions/connect?id=<?= $activeSubscription['id'] ?? 0 ?>" class="glass-btn" style="width: 100%; margin-top: 0.5rem;">Kết nối VPN ngay</a>
        <?php else: ?>
            <div style="text-align: center; padding: 2rem 0;">
                <p style="color: var(--ios-text-secondary); margin-bottom: 1rem; font-size: 0.9rem;">Bạn chưa có gói dịch vụ nào đang hoạt động.</p>
                <a href="/user/plans" class="glass-btn">Mua gói ngay</a>
            </div>
        <?php endif; ?>
    </div>

    <!-- Mã giới thiệu -->
    <div class="glass-card">
        <h3 style="font-size: 1.05rem; font-weight: 600; margin: 0 0 0.5rem 0; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.85rem;">Mã giới thiệu của bạn</h3>
        <div class="ref-box">
            <p class="ref-code" id="refCode"><?= htmlspecialchars($user['ref_code'] ?? 'Chưa có') ?></p>
        </div>
        <p style="font-size: 0.85rem; color: var(--ios-text-secondary); line-height: 1.4; margin-bottom: 1rem;">
            Chia sẻ mã này để nhận <strong style="color: var(--ios-text);"><?= htmlspecialchars($settings['referral_commission_rate'] ?? '10') ?>%</strong> hoa hồng mỗi khi người được giới thiệu thanh toán đơn hàng.
        </p>
        <button class="glass-btn" style="width: 100%;" onclick="copyRefCode()">Sao chép liên kết</button>
    </div>
</div>

<script>
function copyRefCode() {
    const refCode = document.getElementById('refCode').innerText;
    if (refCode === 'Chưa có' || refCode.trim() === '') return;
    const link = window.location.origin + '/register?ref=' + refCode;
    navigator.clipboard.writeText(link).then(() => {
        alert('Đã sao chép liên kết giới thiệu!');
    });
}
</script>

<?php
// Kết thúc bộ đệm và gán vào biến $content
$content = ob_get_clean();

// Gọi layout chính của app
$showSidebar = true;
require_once __DIR__ . '/../layouts/app.php';
?>