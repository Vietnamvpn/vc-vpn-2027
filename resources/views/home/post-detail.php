<?php
$pageTitle = htmlspecialchars($post['title'] ?? 'Chi Tiết Hướng Dẫn') . " - " . ($settings['site_title'] ?? 'VC VPN 2027');
ob_start();
?>

<div style="max-width: 850px; margin: 0 auto;">
    <!-- Nút quay lại -->
    <div style="margin-bottom: 1.25rem;">
        <a href="/home/faq" class="glass-btn" style="text-decoration: none; font-size: 0.85rem; display: inline-flex; align-items: center; gap: 0.4rem;">
            ⬅️ Quay lại danh sách hướng dẫn
        </a>
    </div>

    <?php if (!empty($post)): ?>
        <article class="glass-card" style="padding: 2rem;">
            <!-- Tiêu đề bài viết -->
            <h1 style="font-size: 1.8rem; font-weight: 800; margin-bottom: 1rem; line-height: 1.3; color: var(--ios-text);">
                <?= htmlspecialchars($post['title']) ?>
            </h1>

            <!-- Thông tin bổ sung -->
            <div style="display: flex; gap: 1.25rem; font-size: 0.82rem; color: var(--ios-text-secondary); border-bottom: 1px solid var(--glass-border); padding-bottom: 1rem; margin-bottom: 1.5rem; flex-wrap: wrap;">
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
            <a href="/home/faq" class="glass-btn" style="text-decoration: none;">Xem Các Hướng Dẫn Khác</a>
        </div>
    <?php endif; ?>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>