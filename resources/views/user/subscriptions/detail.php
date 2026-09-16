<?php
$pageTitle = 'Chi Tiết Gói Dịch Vụ - ' . ($settings['site_title'] ?? 'VC VPN 2027');
$status = $subscription['status'] ?? 'expired';
$statusLabels = ['active' => 'Đang hoạt động', 'expired' => 'Hết hạn', 'suspended' => 'Tạm dừng', 'cancelled' => 'Đã hủy'];
$usedBytes = (float) ($subscription['upload'] ?? 0) + (float) ($subscription['download'] ?? 0);
$limitBytes = (float) ($subscription['transfer_enable'] ?? 0);
$usagePercent = $limitBytes > 0 ? min(100, ($usedBytes / $limitBytes) * 100) : 0;
ob_start();
?>

<section class="user-subscriptions-page">
	<header class="user-subscriptions-detail-header">
		<p class="user-subscriptions-kicker">CHI TIẾT GÓI DỊCH VỤ</p>
		<h1><?= htmlspecialchars($subscription['plan_name'] ?? ('Gói dịch vụ #' . ($subscription['plan_id'] ?? ''))) ?></h1>
		<span class="user-subscription-status user-subscription-status-<?= htmlspecialchars($status) ?>"><?= htmlspecialchars($statusLabels[$status] ?? ucfirst($status)) ?></span>
	</header>

	<div class="user-subscription-detail-grid">
		<article class="glass-card user-subscription-detail-card">
			<h2>Lưu lượng</h2>
			<div class="user-subscription-detail-traffic"><strong><?= number_format($usedBytes / 1073741824, 2) ?> GB</strong><span>đã sử dụng<?= $limitBytes > 0 ? ' trên ' . number_format($limitBytes / 1073741824, 2) . ' GB' : '' ?></span></div>
			<div class="user-subscription-progress"><span style="width: <?= $usagePercent ?>%"></span></div>
			<dl class="user-subscription-detail-list">
				<div><dt>Đã tải lên</dt><dd><?= number_format((float) ($subscription['upload'] ?? 0) / 1073741824, 2) ?> GB</dd></div>
				<div><dt>Đã tải xuống</dt><dd><?= number_format((float) ($subscription['download'] ?? 0) / 1073741824, 2) ?> GB</dd></div>
				<div><dt>Thiết bị trực tuyến</dt><dd><?= (int) ($subscription['online_devices'] ?? 0) ?><?= !empty($subscription['device_limit']) ? ' / ' . (int) $subscription['device_limit'] : '' ?></dd></div>
			</dl>
		</article>
		<article class="glass-card user-subscription-detail-card">
			<h2>Thông tin dịch vụ</h2>
			<dl class="user-subscription-detail-list">
				<div><dt>Mã gói</dt><dd><?= htmlspecialchars($subscription['plan_code'] ?? '-') ?></dd></div>
				<div><dt>Ngày bắt đầu</dt><dd><?= !empty($subscription['start_date']) ? date('d/m/Y', strtotime($subscription['start_date'])) : '-' ?></dd></div>
				<div><dt>Ngày hết hạn</dt><dd><?= !empty($subscription['end_date']) ? date('d/m/Y', strtotime($subscription['end_date'])) : '-' ?></dd></div>
				<div><dt>IP kết nối cuối</dt><dd><?= htmlspecialchars($subscription['last_used_ip'] ?? 'Chưa kết nối') ?></dd></div>
				<div><dt>Đơn hàng</dt><dd><?= htmlspecialchars($subscription['order_code'] ?? 'Cấp trực tiếp') ?></dd></div>
			</dl>
			<a href="/subscriptions/connect?id=<?= (int) ($subscription['id'] ?? 0) ?>" class="glass-btn user-subscription-connect-link">Kết nối thiết bị</a>
		</article>
	</div>
</section>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
