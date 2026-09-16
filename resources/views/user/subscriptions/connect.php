<?php
$pageTitle = 'Kết Nối Gói Dịch Vụ - ' . ($settings['site_title'] ?? 'VC VPN 2027');
$status = $subscription['status'] ?? 'expired';
$connectionUrl = isset($subscriptionUrl) ? $subscriptionUrl : '';
$canConnect = $status === 'active' && !empty($subscription['end_date']) && strtotime($subscription['end_date']) >= time();
ob_start();
?>

<section class="user-subscriptions-page user-subscription-connect-page">
	<header class="user-subscriptions-detail-header">
		<p class="user-subscriptions-kicker">KẾT NỐI THIẾT BỊ</p>
		<h1><?= htmlspecialchars($subscription['plan_name'] ?? ('Gói dịch vụ #' . ($subscription['plan_id'] ?? ''))) ?></h1>
		<p>Sử dụng liên kết dưới đây để thêm cấu hình vào ứng dụng VPN.</p>
	</header>

	<article class="glass-card user-subscription-connect-card">
		<?php if ($canConnect): ?>
			<label for="subscription-url">Liên kết đăng ký</label>
			<div class="user-subscription-copy-row">
				<input id="subscription-url" type="text" value="<?= htmlspecialchars($connectionUrl) ?>" readonly>
				<button type="button" class="glass-btn subscription-copy-button" data-copy-value="<?= htmlspecialchars($connectionUrl) ?>">Sao chép</button>
			</div>
			<p>Không chia sẻ liên kết này. Bất kỳ ai có liên kết đều có thể sử dụng cấu hình VPN của bạn.</p>
		<?php else: ?>
			<h2>Gói dịch vụ hiện chưa thể kết nối</h2>
			<p>Gói đã hết hạn, bị tạm dừng hoặc đã hủy. Vui lòng gia hạn hoặc liên hệ hỗ trợ để tiếp tục sử dụng.</p>
		<?php endif; ?>
	</article>
</section>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../../layouts/app.php';
?>
