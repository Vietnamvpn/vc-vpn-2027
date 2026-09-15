<?php
// Bắt đầu lưu bộ đệm nội dung
ob_start();

// Đếm số lượng gói đang hoạt động
$activeSubCount = 0;
if (!empty($subscriptions) && is_array($subscriptions)) {
    foreach ($subscriptions as $sub) {
        if (isset($sub['status']) && $sub['status'] === 'active') {
            $activeSubCount++;
        }
    }
}

// Lấy ID nhóm máy chủ đầu tiên để làm mặc định
$firstGroupId = (!empty($serverGroups) && is_array($serverGroups)) ? ($serverGroups[0]['id'] ?? 'all') : 'all';
?>

<style>
/* CSS Layout Dashboard & Tab System */
.dashboard-header-welcome { text-align: center; margin-bottom: 2rem; }
.dashboard-header-welcome h1 { font-size: 1.8rem; font-weight: 700; color: var(--ios-text); margin-bottom: 0.4rem; }
.dashboard-header-welcome p { font-size: 0.95rem; color: var(--ios-text-secondary); margin: 0; }

/* Thẻ thống kê 4 ô */
.dashboard-grid-4 { display: grid; grid-template-columns: repeat(auto-fit, minmax(220px, 1fr)); gap: 1.2rem; margin-bottom: 1.5rem; }
.stat-card-item { display: flex; flex-direction: column; justify-content: space-between; position: relative; }
.stat-label { font-size: 0.75rem; font-weight: 700; color: var(--ios-text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.4rem; }
.stat-value { font-size: 1.6rem; font-weight: 700; color: var(--ios-text); margin-bottom: 0.8rem; }
.stat-link { font-size: 0.8rem; font-weight: 600; color: var(--ios-blue); text-decoration: none; display: inline-flex; align-items: center; gap: 4px; transition: opacity 0.2s ease; }
.stat-link:hover { opacity: 0.8; text-decoration: underline; }

/* Slider Bài hướng dẫn từng bài */
.tutorial-slider-container { margin-bottom: 1.5rem; overflow: hidden; position: relative; }
.tutorial-slider-wrapper { width: 100%; overflow: hidden; }
.tutorial-slider { display: flex; scroll-snap-type: x mandatory; scroll-behavior: smooth; overflow-x: auto; -webkit-overflow-scrolling: touch; }
.tutorial-slider::-webkit-scrollbar { display: none; }
.tutorial-card { flex: 0 0 100%; scroll-snap-align: start; display: flex; gap: 1.2rem; align-items: center; box-sizing: border-box; }
@media (max-width: 650px) {
    .tutorial-card { flex-direction: column; align-items: flex-start; }
    .tutorial-thumb { width: 100% !important; height: 160px !important; }
}

.tutorial-thumb { width: 200px; height: 125px; object-fit: cover; border-radius: var(--radius-sm); border: 1px solid var(--glass-border); flex-shrink: 0; background: rgba(0, 122, 255, 0.05); }
.tutorial-content { flex: 1; display: flex; flex-direction: column; justify-content: center; }
.tutorial-badge { display: inline-block; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; padding: 3px 8px; border-radius: 4px; background: rgba(0, 122, 255, 0.15); color: var(--ios-blue); margin-bottom: 0.5rem; width: fit-content; }
.tutorial-title { font-size: 1.1rem; font-weight: 700; color: var(--ios-text); margin: 0 0 0.4rem 0; line-height: 1.3; }
.tutorial-desc { font-size: 0.85rem; color: var(--ios-text-secondary); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0.8rem; }

/* Chấm indicator cho slider */
.tutorial-dots { display: flex; justify-content: center; align-items: center; gap: 8px; margin-top: 1rem; }
.tutorial-dot { width: 8px; height: 8px; border-radius: 50%; background: rgba(255, 255, 255, 0.25); cursor: pointer; transition: all 0.3s ease; }
.tutorial-dot.active { width: 22px; border-radius: 10px; background: var(--ios-blue); }

/* Bảng giá & Tabs */
.group-tabs { display: flex; gap: 0.5rem; overflow-x: auto; padding-bottom: 0.75rem; margin-bottom: 1.5rem; border-bottom: 1px solid var(--glass-border); }
.group-tab-btn { padding: 0.5rem 1.2rem; border-radius: 20px; border: 1px solid var(--glass-border); background: transparent; color: var(--ios-text-secondary); font-weight: 600; font-size: 0.85rem; cursor: pointer; transition: all 0.2s ease; white-space: nowrap; }
.group-tab-btn.active, .group-tab-btn:hover { background: var(--ios-blue); color: #ffffff; border-color: var(--ios-blue); }

.plans-grid { display: grid; grid-template-columns: repeat(auto-fit, minmax(260px, 1fr)); gap: 1.2rem; }
.plan-item-card { border: 1px solid var(--glass-border); border-radius: var(--radius-md); padding: 1.5rem; display: flex; flex-direction: column; justify-content: space-between; transition: transform 0.2s ease; }
.plan-item-card:hover { transform: translateY(-3px); }
.plan-name { font-size: 1.2rem; font-weight: 700; color: var(--ios-text); margin-bottom: 0.5rem; }
.plan-price { font-size: 1.6rem; font-weight: 800; color: var(--ios-blue); margin-bottom: 1rem; }
.plan-price span { font-size: 0.85rem; font-weight: 400; color: var(--ios-text-secondary); }

.info-list { list-style: none; padding: 0; margin: 0 0 1.2rem 0; }
.info-list li { padding: 0.6rem 0; border-bottom: 1px solid var(--glass-border); display: flex; justify-content: space-between; font-size: 0.85rem; color: var(--ios-text-secondary); }
.info-list li strong { color: var(--ios-text); }
.info-list li:last-child { border-bottom: none; }

/* Banner gợi ý vào cửa hàng */
.shop-banner { display: flex; justify-content: space-between; align-items: center; background: rgba(0, 122, 255, 0.08); border: 1px solid rgba(0, 122, 255, 0.2); border-radius: var(--radius-md); padding: 1rem 1.2rem; margin-top: 1.5rem; flex-wrap: wrap; gap: 1rem; }
.shop-banner-text { font-size: 0.9rem; color: var(--ios-text); font-weight: 500; }
</style>

<!-- 1. Tiêu đề chào mừng căn giữa -->
<div class="dashboard-header-welcome">
    <h1>Chào mừng trở lại, <?= htmlspecialchars($user['username'] ?? 'Thành viên') ?>! 👋</h1>
    <p>Quản lý dịch vụ VPN và theo dõi tài khoản của bạn</p>
</div>

<!-- 2. Slide bài viết / hướng dẫn -->
<?php if (!empty($posts) && is_array($posts)): ?>
<div class="glass-card tutorial-slider-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="font-size: 1.05rem; font-weight: 600; margin: 0;">📢 Bài viết & Hướng dẫn</h3>
    </div>
    <div class="tutorial-slider-wrapper">
        <div class="tutorial-slider" id="tutorialSlider">
            <?php foreach ($posts as $index => $post): 
                $thumbUrl = !empty($post['thumbnail']) ? $post['thumbnail'] : '/assets/images/logo.png';
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
    
    <!-- Các chấm dưới chân (dots) -->
    <div class="tutorial-dots" id="tutorialDots">
        <?php foreach ($posts as $index => $post): ?>
            <span class="tutorial-dot <?= $index === 0 ? 'active' : '' ?>" onclick="goToSlide(<?= $index ?>)"></span>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- 3. 4 thẻ nhỏ thống kê kèm nút xem chi tiết khớp với routes/web.php -->
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
            <div class="stat-value"><?= count($orders ?? []) ?></div>
        </div>
        <a href="/orders" class="stat-link">Xem chi tiết &rarr;</a>
    </div>
    <div class="glass-card stat-card-item">
        <div>
            <div class="stat-label">Ticket hỗ trợ</div>
            <div class="stat-value"><?= count($tickets ?? []) ?></div>
        </div>
        <a href="/tickets" class="stat-link">Xem chi tiết &rarr;</a>
    </div>
    <div class="glass-card stat-card-item">
        <div>
            <div class="stat-label">Số dư tài khoản</div>
            <div class="stat-value"><?= $formatMoney($user['balance'] ?? 0) ?></div>
        </div>
        <a href="/wallet" class="stat-link">Xem chi tiết &rarr;</a>
    </div>
</div>

<!-- 4. Bảng giá các gói (mặc định hiển thị theo nhóm đầu tiên) -->
<div class="glass-card" style="margin-top: 1.5rem;">
    <h3 style="font-size: 1.05rem; font-weight: 600; margin: 0 0 1rem 0;">Bảng giá gói dịch vụ</h3>
    
    <!-- Tab ngang nhóm máy chủ -->
    <div class="group-tabs">
        <?php if (!empty($serverGroups) && is_array($serverGroups)): ?>
            <?php foreach ($serverGroups as $index => $group): ?>
                <button class="group-tab-btn <?= $index === 0 ? 'active' : '' ?>" onclick="switchGroupTab('<?= $group['id'] ?>', this)">
                    <?= htmlspecialchars($group['name'] ?? '') ?>
                </button>
            <?php endforeach; ?>
        <?php else: ?>
            <button class="group-tab-btn active" onclick="switchGroupTab('all', this)">Tất cả nhóm</button>
        <?php endif; ?>
    </div>

    <!-- Danh sách các gói -->
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
                            <?= $formatMoney($plan['price'] ?? 0) ?>
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

    <!-- Gợi ý tham khảo cửa hàng -->
    <div class="shop-banner">
        <div class="shop-banner-text">💡 Bạn muốn tham khảo thêm nhiều gói cước với tính năng nâng cao hơn?</div>
        <a href="/user/plans" class="glass-btn" style="text-decoration: none; padding: 0.5rem 1rem; font-size: 0.85rem;">Truy cập Cửa Hàng &rarr;</a>
    </div>
</div>

<script>
// Xử lý chuyển Slide bài hướng dẫn an toàn
const slider = document.getElementById('tutorialSlider');
const dots = document.querySelectorAll('.tutorial-dot');

if (slider && dots.length > 0) {
    slider.addEventListener('scroll', () => {
        const slideWidth = slider.clientWidth;
        if (slideWidth > 0) {
            const activeIndex = Math.round(slider.scrollLeft / slideWidth);
            dots.forEach((dot, idx) => {
                if (idx === activeIndex) {
                    dot.classList.add('active');
                } else {
                    dot.classList.remove('active');
                }
            });
        }
    });
}

function goToSlide(index) {
    if (!slider) return;
    const slideWidth = slider.clientWidth;
    if (slideWidth > 0) {
        slider.scrollTo({
            left: slideWidth * index,
            behavior: 'smooth'
        });
    }
}

// Xử lý Chuyển Tab nhóm máy chủ
function switchGroupTab(groupId, btnElement) {
    document.querySelectorAll('.group-tab-btn').forEach(btn => btn.classList.remove('active'));
    if (btnElement) btnElement.classList.add('active');

    const planCards = document.querySelectorAll('.plan-item-card');
    planCards.forEach(card => {
        if (groupId === 'all') {
            card.style.display = 'flex';
        } else {
            const groupsAttr = card.getAttribute('data-groups') || '';
            const groupsArray = groupsAttr.split(',').map(g => g.trim());
            
            if (groupsArray.includes(groupId.toString()) || groupsAttr === '') {
                card.style.display = 'flex';
            } else {
                card.style.display = 'none';
            }
        }
    });
}

// Khởi tạo lọc gói cước theo nhóm đầu tiên sau khi load trang
document.addEventListener('DOMContentLoaded', () => {
    const firstTabBtn = document.querySelector('.group-tab-btn.active');
    if (firstTabBtn) {
        const defaultGroupId = '<?= $firstGroupId ?>';
        switchGroupTab(defaultGroupId, firstTabBtn);
    }
});
</script>

<?php
// Kết thúc bộ đệm và gán vào biến $content
$content = ob_get_clean();

// Gọi layout chính của app
$showSidebar = true;
require_once __DIR__ . '/../layouts/app.php';
?>