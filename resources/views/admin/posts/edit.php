<?php
$pageTitle = "Chỉnh Sửa Bài Viết - Quản Trị Hệ Thống";
$activeMenu = "posts";

// Kiểm tra xem đã có ảnh đại diện trong nội dung bài viết chưa
$existingThumb = '';
if (!empty($post['content'])) {
    preg_match('/<img[^>]+src=["\']([^"\']+)["\']/i', $post['content'], $matches);
    if (!empty($matches[1])) {
        $existingThumb = $matches[1];
    }
}

ob_start();
?>

<!-- Thư viện Summernote Lite & jQuery miễn phí (Hỗ trợ chèn link YouTube & ảnh) -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<div style="margin-bottom: 1.25rem;">
    <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Chỉnh Sửa Bài Viết #<?= $post['id'] ?></h1>
</div>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-danger); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-danger); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['error']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div class="glass-card" style="padding: 1.75rem; width: 100%;">
    <form method="POST" action="/admin/posts/edit?id=<?= $post['id'] ?>" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tiêu Đề Bài Viết (*)</label>
            <input type="text" name="title" class="glass-input" value="<?= htmlspecialchars($post['title'] ?? '') ?>" required style="width: 100%;">
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Thay Đổi Ảnh Đại Diện Từ Máy Tính (Để trống nếu giữ ảnh hiện tại)</label>
            <input type="file" name="thumbnail" accept="image/*" class="glass-input" style="width: 100%; padding: 0.4rem;">
            <?php if (!empty($existingThumb)): ?>
                <div style="margin-top: 0.5rem; display: flex; align-items: center; gap: 0.5rem;">
                    <span style="font-size: 0.8rem; color: var(--ios-text-secondary);">Ảnh hiện tại:</span>
                    <img src="<?= htmlspecialchars($existingThumb) ?>" alt="Current Thumb" style="height: 40px; border-radius: 4px; border: 1px solid var(--glass-border);">
                </div>
            <?php endif; ?>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Đường Dẫn Tĩnh (Slug)</label>
                <input type="text" name="slug" class="glass-input" value="<?= htmlspecialchars($post['slug'] ?? '') ?>" style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Phân Loại (*)</label>
                <select name="type" class="glass-input" style="width: 100%; cursor: pointer;">
                    <option value="news" <?= ($post['type'] ?? '') === 'news' ? 'selected' : '' ?>>Tin tức (News)</option>
                    <option value="tutorial" <?= ($post['type'] ?? '') === 'tutorial' ? 'selected' : '' ?>>Hướng dẫn (Tutorial)</option>
                    <option value="faq" <?= ($post['type'] ?? '') === 'faq' ? 'selected' : '' ?>>Câu hỏi thường gặp (FAQ)</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Trạng Thái (*)</label>
                <select name="status" class="glass-input" style="width: 100%; cursor: pointer;">
                    <option value="published" <?= ($post['status'] ?? '') === 'published' ? 'selected' : '' ?>>Xuất bản (Published)</option>
                    <option value="draft" <?= ($post['status'] ?? '') === 'draft' ? 'selected' : '' ?>>Bản nháp (Draft)</option>
                    <option value="hidden" <?= ($post['status'] ?? '') === 'hidden' ? 'selected' : '' ?>>Ẩn bài viết (Hidden)</option>
                </select>
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Nội Dung Bài Viết (*)</label>
            <textarea id="post_content" name="content" rows="12" class="glass-input" required style="width: 100%; resize: vertical; line-height: 1.5;"><?= htmlspecialchars($post['content'] ?? '') ?></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.65rem 1.75rem; font-size: 0.9rem;">💾 Cập Nhật Bài Viết</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#post_content').summernote({
        placeholder: 'Soạn thảo nội dung bài viết, chèn hình ảnh hoặc dán link YouTube...',
        tabsize: 2,
        height: 380,
        toolbar: [
            ['style', ['style']],
            ['font', ['bold', 'underline', 'clear']],
            ['color', ['color']],
            ['para', ['ul', 'ol', 'paragraph']],
            ['table', ['table']],
            ['insert', ['link', 'picture', 'video']],
            ['view', ['fullscreen', 'codeview', 'help']]
        ]
    });
});
</script>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>