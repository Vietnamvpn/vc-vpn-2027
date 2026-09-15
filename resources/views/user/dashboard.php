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
?>

<style>
/* CSS Layout Dashboard & Tab System */
.dashboard-header-welcome { text-align: center; margin-bottom: 2rem; }
.dashboard-header-welcome h1 { font-size: 1.8rem; font-weight: 700; color: var(--ios-text); margin-bottom: 0.4rem; }
.dashboard-header-welcome p { font-size: 0.95rem; color: var(--ios-text-secondary); margin: 0; }

.dashboard-grid-4 { display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.2rem; margin-bottom: 1.5rem; }
.stat-label { font-size: 0.75rem; font-weight: 700; color: var(--ios-text-secondary); text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 0.4rem; }
.stat-value { font-size: 1.6rem; font-weight: 700; color: var(--ios-text); }

/* Slider Bài hướng dẫn */
.tutorial-slider-container { margin-bottom: 1.5rem; overflow: hidden; }
.tutorial-slider { display: flex; gap: 1rem; overflow-x: auto; padding-bottom: 0.75rem; scroll-behavior: smooth; }
.tutorial-slider::-webkit-scrollbar { height: 4px; }
.tutorial-slider::-webkit-scrollbar-thumb { background: rgba(0, 122, 255, 0.3); border-radius: 4px; }
.tutorial-card { min-width: 280px; flex: 0 0 calc(33.333% - 0.7rem); background: rgba(255, 255, 255, 0.03); border: 1px solid var(--glass-border); border-radius: var(--radius-md); padding: 1.2rem; display: flex; flex-direction: column; justify-content: space-between; }
@media (max-width: 768px) { .tutorial-card { flex: 0 0 85%; } }

.tutorial-badge { display: inline-block; font-size: 0.7rem; font-weight: 700; text-transform: uppercase; padding: 3px 8px; border-radius: 4px; background: rgba(0, 122, 255, 0.15); color: var(--ios-blue); margin-bottom: 0.5rem; width: fit-content; }
.tutorial-title { font-size: 1rem; font-weight: 600; color: var(--ios-text); margin: 0 0 0.5rem 0; text-overflow: ellipsis; overflow: hidden; white-space: nowrap; }
.tutorial-desc { font-size: 0.85rem; color: var(--ios-text-secondary); line-height: 1.4; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; margin-bottom: 0.8rem; }

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
</style>

<!-- 1. Tiêu đề chào mừng căn giữa -->
<div class="dashboard-header-welcome">
    <h1>Chào mừng trở lại, <?= htmlspecialchars($user['username'] ?? 'Thành viên') ?>! 👋</h1>
    <p>Quản lý dịch vụ VPN và theo dõi tài khoản của bạn</p>
</div>

<!-- 2. Slide bài viết / hướng dẫn (nếu trong SQL có) -->
<?php if (!empty($posts) && is_array($posts)): ?>
<div class="glass-card tutorial-slider-container">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1rem;">
        <h3 style="font-size: 1.05rem; font-weight: 600; margin: 0;">📢 Bài viết & Hướng dẫn</h3>
    </div>
    <div class="tutorial-slider">
        <?php foreach ($posts as $post): ?>
            <div class="tutorial-card">
                <div>
                    <span class="tutorial-badge"><?= htmlspecialchars(strtoupper($post['type'] ?? 'TUTORIAL')) ?></span>
                    <h4 class="tutorial-title"><?= htmlspecialchars($post['title'] ?? '') ?></h4>
                    <div class="tutorial-desc"><?= htmlspecialchars(strip_tags($post['content'] ?? '')) ?></div>
                </div>
                <div style="font-size: 0.75rem; color: var(--ios-text-secondary);">
                    <?= isset($post['created_at']) ? date('d/m/Y', strtotime($post['created_at'])) : '' ?>
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</div>
<?php endif; ?>

<!-- 3. 4 thẻ nhỏ hiển thị số lượng gói đang chạy, đơn hàng, ticket, số dư -->
<div class="dashboard-grid-4">
    <div class="glass-card">
        <div class="stat-label">Gói đang chạy</div>
        <div class="stat-value" style="color: var(--ios-success);"><?= $activeSubCount ?></div>
    </div>
    <div class="glass-card">
        <div class="stat-label">Số lượng đơn hàng</div>
        <div class="stat-value"><?= count($orders ?? []) ?></div>
    </div>
    <div class="glass-card">
        <div class="stat-label">Ticket hỗ trợ</div>
        <div class="stat-value"><?= count($tickets ?? []) ?></div>
    </div>
    <div class="glass-card">
        <div class="stat-label">Số dư tài khoản</div>
        <div class="stat-value"><?= $formatMoney($user['balance'] ?? 0) ?></div>
    </div>
</div>

<!-- 4. Bảng giá các gói, phân loại nhóm theo tab ngang -->
<div class="glass-card" style="margin-top: 1.5rem;">
    <h3 style="font-size: 1.05rem; font-weight: 600; margin: 0 0 1rem 0;">Bảng giá gói dịch vụ</h3>
    
    <!-- Tab ngang nhóm máy chủ -->
    <div class="group-tabs">
        <button class="group-tab-btn active" onclick="switchGroupTab('all', this)">Tất cả nhóm</button>
        <?php if (!empty($serverGroups) && is_array($serverGroups)): ?>
            <?php foreach ($serverGroups as $group): ?>
                <button class="group-tab-btn" onclick="switchGroupTab('<?= $group['id'] ?>', this)">
                    <?= htmlspecialchars($group['name'] ?? '') ?>
                </button>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>

    <!-- Bảng danh sách gói -->
    <div class="plans-grid">
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
                    <a href="/user/plans/checkout?id=<?= (int)($plan['id'] ?? 0) ?>" class="glass-btn" style="width: 100%; text-align: center; text-decoration: none;">Đăng ký ngay</a>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p style="color: var(--ios-text-secondary); text-align: center; grid-column: 1 / -1; padding: 2rem 0;">Hiện chưa có gói dịch vụ nào.</p>
        <?php endif; ?>
    </div>
</div>

<script>
function switchGroupTab(groupId, btnElement) {
    document.querySelectorAll('.group-tab-btn').forEach(btn => btn.classList.remove('active'));
    btnElement.classList.add('active');

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
</script>

<?php
// Kết thúc bộ đệm và gán vào biến $content
$content = ob_get_clean();

// Gọi layout chính của app
$showSidebar = true;
require_once __DIR__ . '/../layouts/app.php';
?>