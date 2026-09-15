<?php
// Bắt đầu lưu bộ đệm nội dung
ob_start();

// Tính toán số lượng gói đang hoạt động an toàn
$activeSubCount = 0;
if (!empty($subscriptions) && is_array($subscriptions)) {
    foreach ($subscriptions as $sub) {
        if (isset($sub['status']) && $sub['status'] === 'active') {
            $activeSubCount++;
        }
    }
}

// Lấy ID nhóm máy chủ đầu tiên làm mặc định
$firstGroupId = (!empty($serverGroups) && is_array($serverGroups)) ? ($serverGroups[0]['id'] ?? 'all') : 'all';
?>

<!-- Phần 1: Tiêu đề chào mừng căn giữa -->
<div class="dashboard-header-welcome">
    <h1>Chào mừng trở lại, <?= htmlspecialchars($user['username'] ?? 'Thành viên') ?>! 👋</h1>
    <p>Quản lý dịch vụ VPN và theo dõi tài khoản của bạn</p>
</div>

<!-- Phần 2: Slide bài viết / hướng dẫn -->
<?php if (!empty($posts) && is_array($posts)): ?>
<div class="glass-card tutorial-slider-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="font-size: 1.05rem; font-weight: 600; margin: 0;">📢 Bài viết & Hướng dẫn</h3>
    </div>
    <div class="tutorial-slider-wrapper">
        <div class="tutorial-slider" id="tutorialSlider">
            <?php foreach ($posts as $index => $post): 
                // Tự động tìm đường dẫn ảnh đại diện đã tải lên trong nội dung bài viết
                $thumbUrl = '/assets/images/logo.png';
                if (!empty($post['content'])) {
                    preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $post['content'], $matches);
                    if (!empty($matches[1])) {
                        $thumbUrl = $matches[1];
                    }
                }
            ?>
                <div class="tutorial-card" data-index="<?= $index ?>">
                    <img src="<?= htmlspecialchars($thumbUrl) ?>" alt="Thumbnail" class="tutorial-thumb" onerror="this.src='/assets/images/logo.png'">
                    <div class="tutorial-content">
                        <div>
                            <span class="tutorial-badge"><?= htmlspecialchars(strtoupper($post['type'] ?? 'TUTORIAL')) ?></span>
                            <h4 class="tutorial-title"><?= htmlspecialchars($post['title'] ?? '') ?></h4>
                            <div class="tutorial-desc"><?= htmlspecialchars(strip_tags($post['content'] ?? '')) ?></div>
                        </div>
                        <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 0.5rem;">
                            <span style="font-size: 0.75rem; color: var(--ios-text-secondary);">
                                <?= isset($post['created_at']) ? date('d/m/Y', strtotime($post['created_at'])) : '' ?>
                            </span>
                            <a href="/post-detail?id=<?= (int)($post['id'] ?? 0) ?>" class="glass-btn" style="padding: 0.4rem 0.9rem; font-size: 0.8rem; text-decoration: none;">Xem chi tiết &rarr;</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    
    <div class="tutorial-dots" id="tutorialDots">
        <?php foreach ($posts as $index => $post): ?>
            <span class="tutorial-dot <?= $index === 0 ? 'active' : '' ?>" onclick="goToSlide(<?= $index ?>)"></span>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Phần 3: 4 thẻ nhỏ hiển thị số lượng gói đang chạy, đơn hàng, ticket, số dư -->
<div class="dashboard-grid-4">
    <div class="glass-card stat-card-item">
        <div>
            <div class="stat-label">Gói đang chạy</div>
            <div class="stat-value" style="color: var(--ios-success);"><?= $activeSubCount ?></div>
        </div>
        <a href="/subscriptions" class="stat-link">Xem chi tiết &rarr;</a>
    </div>
    <div class="glass-card stat-card-item">
        <div>
            <div class="stat-label">Số lượng đơn hàng</div>
            <div class="stat-value"><?= is_array($orders ?? null) ? count($orders) : 0 ?></div>
        </div>
        <a href="/orders" class="stat-link">Xem chi tiết &rarr;</a>
    </div>
    <div class="glass-card stat-card-item">
        <div>
            <div class="stat-label">Ticket hỗ trợ</div>
            <div class="stat-value"><?= is_array($tickets ?? null) ? count($tickets) : 0 ?></div>
        </div>
        <a href="/tickets" class="stat-link">Xem chi tiết &rarr;</a>
    </div>
    <div class="glass-card stat-card-item">
        <div>
            <div class="stat-label">Số dư tài khoản</div>
            <div class="stat-value"><?= isset($formatMoney) ? $formatMoney($user['balance'] ?? 0) : number_format($user['balance'] ?? 0, 2) ?></div>
        </div>
        <a href="/wallet" class="stat-link">Xem chi tiết &rarr;</a>
    </div>
</div>

<!-- Phần 4: Bảng giá các gói cước phân loại nhóm theo tab ngang -->
<div class="glass-card" style="margin-top: 1.5rem;">
    <h3 style="font-size: 1.05rem; font-weight: 600; margin: 0 0 1rem 0;">Bảng giá gói dịch vụ</h3>
    
    <div class="group-tabs">
        <?php if (!empty($serverGroups) && is_array($serverGroups)): ?>
            <?php foreach ($serverGroups as $index => $group): ?>
                <button class="group-tab-btn <?= $index === 0 ? 'active' : '' ?>" data-group-id="<?= htmlspecialchars($group['id'] ?? '') ?>" onclick="switchGroupTab('<?= htmlspecialchars($group['id'] ?? '') ?>', this)">
                    <?= htmlspecialchars($group['name'] ?? '') ?>
                </button>
            <?php endforeach; ?>
        <?php else: ?>
            <button class="group-tab-btn active" data-group-id="all" onclick="switchGroupTab('all', this)">Tất cả nhóm</button>
        <?php endif; ?>
    </div>

    <div class="plans-grid" id="plansGrid">
        <?php if (!empty($plans) && is_array($plans)): ?>
            <?php foreach ($plans as $plan): 
                $groupIds = [];
                if (!empty($plan['group_id'])) {
                    if (is_array($plan['group_id'])) {
                        $groupIds = $plan['group_id'];
                    } else {
                        $decoded = json_decode($plan['group_id'], true);
                        if (is_array($decoded)) $groupIds = $decoded;
                    }
                }
                $groupsStr = implode(',', $groupIds);
            ?>
                <div class="plan-item-card glass-card" data-groups="<?= htmlspecialchars($groupsStr) ?>">
                    <div>
                        <div class="plan-name"><?= htmlspecialchars($plan['name'] ?? '') ?></div>
                        <div class="plan-price">
                            <?= isset($formatMoney) ? $formatMoney($plan['price'] ?? 0) : number_format($plan['price'] ?? 0, 2) ?>
                            <span>/ <?= (int)($plan['duration_days'] ?? 30) ?> ngày</span>
                        </div>
                        <ul class="info-list">
                            <li>
                                <span>Lưu lượng:</span>
                                <strong><?= ((int)($plan['bandwidth_limit_gb'] ?? 0) > 0) ? (int)$plan['bandwidth_limit_gb'] . ' GB' : 'Không giới hạn' ?></strong>
                            </li>
                            <li>
                                <span>Thiết bị tối đa:</span>
                                <strong><?= (int)($plan['max_devices'] ?? 1) ?> thiết bị</strong>
                            </li>
                        </ul>
                    </div>
                    <a href="/checkout?id=<?= (int)($plan['id'] ?? 0) ?>" class="glass-btn" style="width: 100%; text-align: center; text-decoration: none;">Đăng ký ngay</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: var(--ios-text-secondary); text-align: center; grid-column: 1 / -1; padding: 2rem 0;">Hiện chưa có gói dịch vụ nào.</p>
        <?php endif; ?>
    </div>

    <div class="shop-banner">
        <div class="shop-banner-text">💡 Bạn muốn tham khảo thêm nhiều gói cước với tính năng nâng cao hơn?</div>
        <a href="/user/plans" class="glass-btn" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.85rem;">Truy cập Cửa Hàng &rarr;</a>
    </div>
</div>

<?php
// Kết thúc bộ đệm nội dung
$content = ob_get_clean();

// Nạp layout chính
$showSidebar = true;
require_once __DIR__ . '/../layouts/app.php';
?>