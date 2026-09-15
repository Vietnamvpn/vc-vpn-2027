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

// 1. Chỉ lọc ra các bài viết thuộc loại THÔNG BÁO (notice / faq)
$noticePosts = [];
if (!empty($posts) && is_array($posts)) {
    foreach ($posts as $p) {
        $type = strtolower($p['type'] ?? '');
        if ($type === 'faq' || $type === 'notice') {
            $noticePosts[] = $p;
        }
    }
}

// 2. Lấy ID nhóm máy chủ đầu tiên & lọc gói thuộc nhóm đầu tiên
$firstGroupId = (!empty($serverGroups) && is_array($serverGroups)) ? ($serverGroups[0]['id'] ?? 'all') : 'all';

$firstGroupPlans = [];
if (!empty($plans) && is_array($plans)) {
    foreach ($plans as $plan) {
        if ($firstGroupId === 'all') {
            $firstGroupPlans[] = $plan;
        } else {
            $groupIds = [];
            if (!empty($plan['group_id'])) {
                if (is_array($plan['group_id'])) {
                    $groupIds = $plan['group_id'];
                } else {
                    $decoded = json_decode($plan['group_id'], true);
                    if (is_array($decoded)) $groupIds = $decoded;
                }
            }
            if (empty($groupIds) || in_array((string)$firstGroupId, array_map('strval', $groupIds))) {
                $firstGroupPlans[] = $plan;
            }
        }
    }
}

// Hàm sinh ảnh đại diện SVG ngẫu nhiên an toàn (Chống giật / chống xoay vô hạn)
function getNoticeFallbackThumb($id) {
    $colors = [
        ['#007aff', '#5856d6'],
        ['#34c759', '#30b0c7'],
        ['#ff9500', '#ff2d55'],
        ['#af52de', '#ff2d55'],
        ['#5856d6', '#007aff']
    ];
    $pair = $colors[(int)$id % count($colors)];
    $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="200" height="125" viewBox="0 0 200 125">'
         . '<defs><linearGradient id="g'.$id.'" x1="0%" y1="0%" x2="100%" y2="100%">'
         . '<stop offset="0%" stop-color="'.$pair[0].'"/>'
         . '<stop offset="100%" stop-color="'.$pair[1].'"/>'
         . '</linearGradient></defs>'
         . '<rect width="100%" height="100%" fill="url(#g'.$id.')"/>'
         . '<text x="50%" y="50%" dominant-baseline="middle" text-anchor="middle" fill="#ffffff" font-family="-apple-system, sans-serif" font-size="20" font-weight="bold">THÔNG BÁO</text>'
         . '</svg>';
    return 'data:image/svg+xml;base64,' . base64_encode($svg);
}
?>

<style>
/* CSS Cấu hình Grid 4 thẻ thống kê hiển thị 2 cột trên màn hình nhỏ & nút xem chi tiết góc phải */
.dashboard-grid-4 {
    display: grid;
    grid-template-columns: repeat(4, 1fr);
    gap: 1rem;
    margin-top: 1.5rem;
}

.stat-card-item {
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 1.25rem;
}

.stat-card-item .stat-link {
    font-size: 0.8rem;
    color: var(--ios-primary, #007aff);
    text-decoration: none;
    white-space: nowrap;
}

@media (max-width: 768px) {
    .dashboard-grid-4 {
        grid-template-columns: repeat(2, 1fr) !important;
        gap: 0.75rem !important;
    }
    .stat-card-item {
        flex-direction: column !important;
        align-items: flex-start !important;
        padding: 0.85rem 1rem !important;
        position: relative;
    }
    .stat-card-item .stat-link {
        align-self: flex-end !important;
        font-size: 0.75rem !important;
        margin-top: 0.25rem;
    }
}
</style>

<!-- Phần 1: Tiêu đề chào mừng căn giữa -->
<div class="dashboard-header-welcome">
    <h1>Chào mừng trở lại, <?= htmlspecialchars($user['username'] ?? 'Thành viên') ?>! 👋</h1>
    <p>Quản lý dịch vụ VPN và theo dõi tài khoản của bạn</p>
</div>

<!-- Phần 2: Slide bài viết thông báo (Tự động chuyển bài lặp đi lặp lại) -->
<?php if (!empty($noticePosts)): ?>
<div class="glass-card tutorial-slider-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="font-size: 1.05rem; font-weight: 600; margin: 0;">📢 Thông Báo Hệ Thống</h3>
    </div>
    <div class="tutorial-slider-wrapper">
        <div class="tutorial-slider" id="tutorialSlider">
            <?php foreach ($noticePosts as $index => $post): 
                $thumbUrl = '';
                
                if (!empty($post['thumbnail'])) {
                    $thumbUrl = $post['thumbnail'];
                } elseif (!empty($post['content'])) {
                    $rawContent = htmlspecialchars_decode($post['content']);
                    if (preg_match('/<!--thumbnail:(.*?)-->/i', $rawContent, $mThumb)) {
                        $thumbUrl = trim($mThumb[1]);
                    } elseif (preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $rawContent, $mImg)) {
                        $thumbUrl = trim($mImg[1]);
                    }
                }
                
                // Nếu không tìm thấy ảnh tải lên -> sinh ảnh SVG ngẫu nhiên lập tức
                if (empty($thumbUrl)) {
                    $thumbUrl = getNoticeFallbackThumb($post['id'] ?? $index);
                }
            ?>
                <div class="tutorial-card" data-index="<?= $index ?>">
                    <img src="<?= htmlspecialchars($thumbUrl) ?>" alt="Thumbnail" class="tutorial-thumb">
                    <div class="tutorial-content">
                        <div>
                            <span class="tutorial-badge">THÔNG BÁO</span>
                            <h4 class="tutorial-title"><?= htmlspecialchars($post['title'] ?? '') ?></h4>
                            <div class="tutorial-desc"><?= htmlspecialchars(strip_tags(htmlspecialchars_decode($post['content'] ?? ''))) ?></div>
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
        <?php foreach ($noticePosts as $index => $post): ?>
            <span class="tutorial-dot <?= $index === 0 ? 'active' : '' ?>" onclick="goToSlide(<?= $index ?>)"></span>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- Phần 3: 4 thẻ thống kê số dư, đơn hàng, ticket, gói chạy -->
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

<!-- Phần 4: Bảng giá mặc định thuộc nhóm đầu tiên (Để tự nhiên theo giao diện, không bọc glass-card ngoài) -->
<div style="margin-top: 1.5rem;">
    <h3 style="font-size: 1.05rem; font-weight: 600; margin: 0 0 0.3rem 0;">Bảng giá gói dịch vụ</h3>
    <div style="font-size: 0.85rem; color: var(--ios-text-secondary); margin-bottom: 1.25rem;">
        💡 Bạn muốn tham khảo thêm nhiều gói cước với tính năng nâng cao hơn?
    </div>

    <div class="plans-grid" id="plansGrid">
        <?php if (!empty($firstGroupPlans)): ?>
            <?php foreach ($firstGroupPlans as $plan): ?>
                <div class="plan-item-card glass-card">
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
            <p style="color: var(--ios-text-secondary); text-align: center; grid-column: 1 / -1; padding: 2rem 0;">Hiện chưa có gói dịch vụ nào cho nhóm này.</p>
        <?php endif; ?>
    </div>
</div>

<script>
// Logic tự động chuyển Slide thông báo lặp đi lặp lại
(function() {
    const slider = document.getElementById('tutorialSlider');
    const dots = document.querySelectorAll('.tutorial-dot');
    if (!slider || dots.length <= 1) return;

    let currentIndex = 0;
    const totalSlides = dots.length;
    let autoTimer = null;

    function scrollToSlide(index) {
        const slideWidth = slider.clientWidth;
        if (slideWidth > 0) {
            slider.scrollTo({
                left: slideWidth * index,
                behavior: 'smooth'
            });
        }
    }

    window.goToSlide = function(index) {
        currentIndex = index;
        scrollToSlide(currentIndex);
        restartTimer();
    };

    slider.addEventListener('scroll', () => {
        const slideWidth = slider.clientWidth;
        if (slideWidth > 0) {
            const activeIndex = Math.round(slider.scrollLeft / slideWidth);
            dots.forEach((dot, idx) => {
                dot.classList.toggle('active', idx === activeIndex);
            });
            currentIndex = activeIndex;
        }
    });

    function startTimer() {
        autoTimer = setInterval(() => {
            currentIndex = (currentIndex + 1) % totalSlides;
            scrollToSlide(currentIndex);
        }, 4000);
    }

    function restartTimer() {
        if (autoTimer) clearInterval(autoTimer);
        startTimer();
    }

    startTimer();
})();
</script>

<?php
// Kết thúc bộ đệm nội dung
$content = ob_get_clean();

// Nạp layout chính
$showSidebar = true;
require_once __DIR__ . '/../layouts/app.php';
?>