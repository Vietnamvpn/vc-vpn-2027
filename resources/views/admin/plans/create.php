<?php
$pageTitle = "Thêm Gói Cước Mới - Quản Trị Hệ Thống";
$activeMenu = "plans";

ob_start();
?>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-danger); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; font-size: 0.9rem; color: var(--ios-danger);"><?= htmlspecialchars($_SESSION['error']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div style="margin-bottom: 0.75rem;">
    <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px; margin: 0;">Thêm Gói Cước Mới</h1>
    <p style="font-size: 0.875rem; color: var(--ios-text-secondary); margin: 0.25rem 0 0 0;">Thiết lập thông tin gói dịch vụ VPN mới cho hệ thống</p>
</div>

<hr style="border: none; border-top: 1px solid var(--glass-border); margin: 0 0 1.25rem 0;">

<div class="glass-card" style="padding: 1.75rem; width: 100%;">
    <form action="/admin/plans/create" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Gói Cước (*)</label>
                <input type="text" id="name" name="name" class="glass-input" placeholder="Ví dụ: Gói VIP 1 Tháng" required autofocus style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Mã Gói Cước (Code) (*)</label>
                <input type="text" id="code" name="code" class="glass-input" placeholder="VIP1M, BASIC30..." required style="width: 100%; text-transform: uppercase;">
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
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Giới Hạn Dung Lượng (GB)</label>
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
                <option value="active" selected>Hoạt động (Active)</option>
                <option value="inactive">Tắt (Inactive)</option>
            </select>
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.65rem 1.75rem; font-size: 0.9rem;">💾 Lưu Gói Cước</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>