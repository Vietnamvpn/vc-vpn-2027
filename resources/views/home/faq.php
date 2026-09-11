<?php
$pageTitle = "Hướng Dẫn & Câu Hỏi Thường Gặp - " . ($settings['site_title'] ?? 'VC VPN 2027');

// Nhóm các bài viết theo Thể Loại (type)
$groupedPosts = [];
if (!empty($posts) && is_array($posts)) {
    foreach ($posts as $post) {
        $type = !empty($post['type']) ? strtoupper($post['type']) : 'HƯỚNG DẪN CHUNG';
        $groupedPosts[$type][] = $post;
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

/* Khung phân vùng theo nhóm thể loại */
.faq-group-section {
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

.faq-group-header {
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

.faq-card {
    padding: 1.5rem;
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
.faq-card:hover {
    transform: translateY(-6px) scale(1.01);
    border-color: var(--ios-blue, #007aff);
    box-shadow: 0 12px 30px rgba(0, 122, 255, 0.25), 
                0 0 20px rgba(0, 122, 255, 0.2);
}

/* Tối ưu hóa Responsive cho màn hình nhỏ (Mobile & Tablet) */
@media (max-width: 768px) {
    .faq-group-section {
        padding: 1rem;
        margin-bottom: 1.5rem;
        border-radius: 14px;
    }
    .faq-group-header {
        font-size: 1.15rem;
        margin-bottom: 1rem;
    }
    .faq-card {
        padding: 1.25rem !important;
    }
}
</style>

<div style="text-align: center; margin-bottom: 2.5rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">Hướng Dẫn & Câu Hỏi Thường Gặp</h1>
    <p style="color: var(--ios-text-secondary); margin-top: 0.5rem;">Giải đáp các thắc mắc và hướng dẫn chi tiết cách sử dụng dịch vụ VPN</p>
</div>

<!-- Đã bỏ max-width: 900px, chuyển sang rộng linh hoạt toàn màn hình (width: 100%) -->
<div style="width: 100%; margin: 0 auto;">
    <?php if (!empty($groupedPosts)): ?>
        <?php 
        $cardIndex = 0;
        foreach ($groupedPosts as $typeGroup => $groupPosts): 
        ?>
            <!-- Phân vùng hiển thị riêng cho từng Thể Loại Bài Viết -->
            <div class="faq-group-section">
                <div class="faq-group-header">
                    <span>📌</span> <?= htmlspecialchars($typeGroup) ?>
                </div>

                <div style="display: flex; flex-direction: column; gap: 1.25rem;">
                    <?php foreach ($groupPosts as $itemIndex => $post): ?>
                        <?php
                        $cardIndex++;
                        $animationDelay = number_format($cardIndex * 0.08, 2);
                        ?>
                        <div class="glass-card faq-card" style="animation-delay: <?= $animationDelay ?>s;">
                            <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap;">
                                <div style="flex: 1; min-width: 250px;">
                                    <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--ios-blue);">
                                        <a href="/post-detail?slug=<?= urlencode($post['slug']) ?>" style="color: inherit; text-decoration: none;">
                                            <?= ($itemIndex + 1) ?>. <?= htmlspecialchars($post['title']) ?>
                                        </a>
                                    </h3>
                                    <p style="color: var(--ios-text-secondary); font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                                        <?= htmlspecialchars(strip_tags($post['content'])) ?>
                                    </p>
                                </div>
                                <a href="/post-detail?slug=<?= urlencode($post['slug']) ?>" class="glass-btn" style="white-space: nowrap; font-size: 0.85rem; padding: 0.5rem 1rem; text-decoration: none; box-sizing: border-box;">
                                    Xem Chi Tiết ➔
                                </a>
                            </div>
                            <div style="display: flex; gap: 1rem; font-size: 0.78rem; color: var(--ios-text-secondary); border-top: 1px solid var(--glass-border); padding-top: 0.75rem; margin-top: 0.5rem; flex-wrap: wrap;">
                                <span>📅 Cập nhật: <?= date('d/m/Y', strtotime($post['created_at'])) ?></span>
                                <span>🏷️ Chuyên mục: <?= htmlspecialchars($typeGroup) ?></span>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        <?php endforeach; ?>
    <?php else: ?>
        <div class="glass-card" style="text-align: center; padding: 3rem; color: var(--ios-text-secondary);">
            <div style="font-size: 2.5rem; margin-bottom: 0.5rem;">📑</div>
            <p style="font-size: 1rem; margin-bottom: 0;">Hiện chưa có bài viết hướng dẫn nào được xuất bản.</p>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>