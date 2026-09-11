<?php
$pageTitle = htmlspecialchars($post['title'] ?? 'Chi Tiết Hướng Dẫn') . " - " . ($settings['site_title'] ?? 'VC VPN 2027');
ob_start();
?>

<style>
/* Hiệu ứng lắp ráp khi mở trang (Assembly Entrance) */
@keyframes assembleIn {
    0% {
        opacity: 0;
        transform: translateY(35px) scale(0.95);
        filter: blur(6px);
    }
    100% {
        opacity: 1;
        transform: translateY(0) scale(1);
        filter: blur(0);
    }
}

.post-detail-wrapper {
    width: 100%;
    margin: 0 auto;
    box-sizing: border-box;
}

.post-detail-card {
    padding: 2rem;
    opacity: 0;
    animation: assembleIn 0.6s cubic-bezier(0.16, 1, 0.3, 1) forwards;
    transition: transform 0.35s cubic-bezier(0.16, 1, 0.3, 1), 
                box-shadow 0.35s ease, 
                border-color 0.35s ease;
    border: 1px solid var(--glass-border, rgba(255, 255, 255, 0.15));
    box-sizing: border-box;
    word-break: break-word;
}

/* Hiệu ứng di chuột: Nhô nhẹ lên & viền phát sáng */
.post-detail-card:hover {
    transform: translateY(-4px);
    border-color: var(--ios-blue, #007aff);
    box-shadow: 0 12px 30px rgba(0, 122, 255, 0.2), 
                0 0 15px rgba(0, 122, 255, 0.15);
}

/* Tối ưu hóa Responsive cho màn hình nhỏ (Mobile & Tablet) */
@media (max-width: 768px) {
    .post-detail-card {
        padding: 1.25rem !important;
        border-radius: 14px;
    }
    .post-title {
        font-size: 1.4rem !important;
    }
    .post-meta {
        gap: 0.75rem !important;
        font-size: 0.75rem !important;
    }
}
</style>

<div class="post-detail-wrapper">

    <?php if (!empty($post)): ?>
        <article class="glass-card post-detail-card">
            <!-- Tiêu đề bài viết -->
            <h1 class="post-title" style="font-size: 1.8rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.3; color: var(--ios-text);">
                <?= htmlspecialchars($post['title']) ?>
            </h1>

            <!-- Thông tin bổ sung -->
            <div class="post-meta" style="display: flex; gap: 1.25rem; font-size: 0.82rem; color: var(--ios-text-secondary); border-bottom: 1px solid var(--glass-border); padding-bottom: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
                <span>📅 Ngày đăng: <?= date('d/m/Y H:i', strtotime($post['created_at'])) ?></span>
                <span>👤 Tác giả: <?= htmlspecialchars($post['author_name'] ?? 'Ban Quản Trị') ?></span>
                <span>🏷️ Chuyên mục: <strong style="color: var(--ios-blue);"><?= strtoupper(htmlspecialchars($post['type'] ?? 'news')) ?></strong></span>
            </div>

            <!-- Nội dung chi tiết bài viết -->
            <div class="post-content" style="font-size: 1rem; line-height: 1.7; color: var(--ios-text); word-break: break-word;">
                <?= $post['content'] ?>
            </div>
        </article>
    <?php else: ?>
        <div class="glass-card" style="text-align: center; padding: 3rem; color: var(--ios-text-secondary);">
            <div style="font-size: 3rem; margin-bottom: 0.5rem;">⚠️</div>
            <h2 style="font-size: 1.25rem; font-weight: 700; margin-bottom: 0.5rem;">Không Tìm Thấy Bài Viết</h2>
            <p style="font-size: 0.9rem; margin-bottom: 1.5rem;">Bài viết hướng dẫn này không tồn tại hoặc đã bị ẩn khỏi hệ thống.</p>
            <a href="/faq" class="glass-btn" style="text-decoration: none;">Xem Các Hướng Dẫn Khác</a>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>