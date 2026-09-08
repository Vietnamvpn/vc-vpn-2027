<?php
$pageTitle = "Thêm Gói Cước Mới - Quản Trị Hệ Thống";
$activeMenu = "plans";

ob_start();
?>

<div style="margin-bottom: 1.25rem;">
    <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Thêm Gói Cước Mới</h1>
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
    <form method="POST" action="/admin/plans/create" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Gói Cước (*)</label>
                <input type="text" id="name" name="name" class="glass-input" required placeholder="Ví dụ: Gói VIP 1 Tháng" autofocus style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Mã Gói (Code) (*)</label>
                <input type="text" id="code" name="code" class="glass-input" required placeholder="VIP1M, BASIC30..." style="width: 100%; text-transform: uppercase;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Nhóm Máy Chủ (*)</label>
                <select id="group_id" name="group_id" class="glass-input" required style="width: 100%; cursor: pointer;">
                    <option value="">-- Chọn Nhóm Máy Chủ --</option>
                    <?php if (!empty($groups)): ?>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?= $group['id'] ?>"><?= htmlspecialchars($group['name']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Giá Bán (VNĐ) (*)</label>
                <input type="number" id="price" name="price" class="glass-input" placeholder="50000" min="0" step="1000" required style="width: 100%;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Thời Hạn (Ngày) (*)</label>
                <input type="number" id="duration_days" name="duration_days" class="glass-input" value="30" min="1" required style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Dung Lượng (GB)</label>
                <input type="number" id="bandwidth_limit_gb" name="bandwidth_limit_gb" class="glass-input" value="0" min="0" placeholder="0 = Không giới hạn" style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Số Thiết Bị Tối Đa (*)</label>
                <input type="number" id="max_devices" name="max_devices" class="glass-input" value="1" min="1" required style="width: 100%;">
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Trạng Thái</label>
            <select id="status" name="status" class="glass-input" style="width: 100%; cursor: pointer;">
                <option value="active" selected>Active (Hoạt động)</option>
                <option value="inactive">Inactive (Tắt/Khóa)</option>
            </select>
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.65rem 1.75rem; font-size: 0.9rem;">➕ Tạo Gói Cước</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>