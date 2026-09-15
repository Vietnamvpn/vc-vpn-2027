<?php
$pageTitle = "Thêm Bài Viết Mới - Quản Trị Hệ Thống";
$activeMenu = "posts";

ob_start();
?>

<!-- Thư viện Summernote Lite & jQuery miễn phí -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>

<style>
/* Sửa lỗi z-index làm tối đen màn hình của Summernote modal */
.note-modal-backdrop { display: none !important; }
.note-modal { z-index: 10000 !important; background: rgba(0, 0, 0, 0.5) !important; }
.note-modal .modal-dialog { margin-top: 80px !important; }
.note-modal .modal-content { background: #ffffff !important; color: #1c1c1e !important; border-radius: 10px !important; box-shadow: 0 10px 30px rgba(0,0,0,0.3) !important; }

/* Ép hiển thị ảnh và video nhúng YouTube trong khung soạn thảo */
.note-editable { background: #ffffff !important; color: #1c1c1e !important; }
.note-editable img { max-width: 100% !important; height: auto !important; display: inline-block !important; }
.note-editable iframe { width: 100% !important; height: 350px !important; display: block !important; border: 0 !important; }
</style>

<div style="margin-bottom: 1.25rem;">
    <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Thêm Bài Viết Mới</h1>
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
    <form method="POST" action="/admin/posts/create" enctype="multipart/form-data" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tiêu Đề Bài Viết (*)</label>
            <input type="text" name="title" class="glass-input" required placeholder="Nhập tiêu đề bài viết..." autofocus style="width: 100%;">
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tải Ảnh Đại Diện Từ Máy Tính (Thumbnail)</label>
            <input type="file" name="thumbnail" accept="image/*" class="glass-input" style="width: 100%; padding: 0.4rem;">
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Đường Dẫn Tĩnh (Slug)</label>
                <input type="text" name="slug" class="glass-input" placeholder="Tự động tạo nếu để trống (vi-du-duong-dan)" style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Phân Loại (*)</label>
                <select name="type" class="glass-input" style="width: 100%; cursor: pointer;">
                    <option value="tutorial" selected>Hướng dẫn (Tutorial)</option>
                    <option value="faq">Thông báo (Notice)</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Trạng Thái (*)</label>
                <select name="status" class="glass-input" style="width: 100%; cursor: pointer;">
                    <option value="published" selected>Xuất bản (Published)</option>
                    <option value="draft">Bản nháp (Draft)</option>
                    <option value="hidden">Ẩn bài viết (Hidden)</option>
                </select>
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Nội Dung Bài Viết (*)</label>
            <textarea id="post_content" name="content" rows="12" class="glass-input" required placeholder="Soạn thảo nội dung bài viết ở đây..." style="width: 100%; resize: vertical; line-height: 1.5;"></textarea>
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.65rem 1.75rem; font-size: 0.9rem;">➕ Tạo Bài Viết</button>
        </div>
    </form>
</div>

<script>
$(document).ready(function() {
    $('#post_content').summernote({
        placeholder: 'Soạn thảo nội dung bài viết, chèn hình ảnh hoặc dán link YouTube...',
        tabsize: 2,
        height: 380,
        dialogsInBody: true,
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