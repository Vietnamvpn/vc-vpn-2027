<?php
$pageTitle = "Hướng Dẫn & Câu Hỏi Thường Gặp - " . ($settings['site_title'] ?? 'VC VPN 2027');
ob_start();
?>

<div style="text-align: center; margin-bottom: 2.5rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">Hướng Dẫn & Câu Hỏi Thường Gặp</h1>
    <p style="color: var(--ios-text-secondary); margin-top: 0.5rem;">Giải đáp các thắc mắc và hướng dẫn chi tiết cách sử dụng dịch vụ VPN</p>
</div>

<div style="display: flex; flex-direction: column; gap: 1.25rem; max-width: 850px; margin: 0 auto;">
    <?php if (!empty($posts) && is_array($posts)): ?>
        <?php foreach ($posts as $index => $post): ?>
            <div class="glass-card" style="padding: 1.5rem; transition: transform 0.2s ease, box-shadow 0.2s ease;">
                <div style="display: flex; justify-content: space-between; align-items: flex-start; gap: 1rem; flex-wrap: wrap;">
                    <div style="flex: 1; min-width: 250px;">
                        <h3 style="font-size: 1.2rem; font-weight: 700; margin-bottom: 0.5rem; color: var(--ios-blue);">
                            <a href="/home/post?slug=<?= urlencode($post['slug']) ?>" style="color: inherit; text-decoration: none;">
                                <?= ($index + 1) ?>. <?= htmlspecialchars($post['title']) ?>
                            </a>
                        </h3>
                        <p style="color: var(--ios-text-secondary); font-size: 0.9rem; margin-bottom: 1rem; line-height: 1.5; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden;">
                            <?= htmlspecialchars(strip_tags($post['content'])) ?>
                        </p>
                    </div>
                    <a href="/home/post?slug=<?= urlencode($post['slug']) ?>" class="glass-btn" style="white-space: nowrap; font-size: 0.85rem; padding: 0.5rem 1rem; text-decoration: none;">
                        Xem Chi Tiết ➔
                    </a>
                </div>
                <div style="display: flex; gap: 1rem; font-size: 0.78rem; color: var(--ios-text-secondary); border-top: 1px solid var(--glass-border); padding-top: 0.75rem; margin-top: 0.5rem;">
                    <span>📅 Cập nhật: <?= date('d/m/Y', strtotime($post['created_at'])) ?></span>
                    <span>📌 Thể loại: <?= strtoupper(htmlspecialchars($post['type'] ?? 'FAQ')) ?></span>
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