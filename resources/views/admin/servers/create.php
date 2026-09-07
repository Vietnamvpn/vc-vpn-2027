<?php
$pageTitle = "Thêm Máy Chủ Mới - Quản Trị Hệ Thống";
$activeMenu = "servers";

ob_start();
?>

<div style="margin-bottom: 1.5rem; text-align: center;">
    <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Thêm Máy Chủ Mới</h1>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.875rem; border: 1px solid rgba(255, 59, 48, 0.3); margin-bottom: 1.25rem; max-width: 700px; margin-left: auto; margin-right: auto;">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="glass-card" style="padding: 1.5rem; max-width: 700px; margin: 0 auto;">
    <form action="/admin/servers/create" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="name" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Tên Máy Chủ <span style="color: var(--ios-danger);">*</span></label>
                <input type="text" id="name" name="name" class="glass-input" placeholder="Ví dụ: SG-VIP-Node-01" required autofocus style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="group_id" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Nhóm Máy Chủ <span style="color: var(--ios-danger);">*</span></label>
                <select id="group_id" name="group_id" class="glass-input" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
                    <option value="" style="background: #1e293b; color: #fff;">-- Chọn Nhóm --</option>
                    <?php if (!empty($groups)): ?>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?= $group['id'] ?>" style="background: #1e293b; color: #fff;"><?= htmlspecialchars($group['name']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="country_code" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Mã Quốc Gia (Country Code) <span style="color: var(--ios-danger);">*</span></label>
                <input type="text" id="country_code" name="country_code" class="glass-input" placeholder="VN, SG, JP, US..." maxlength="10" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text); text-transform: uppercase;">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="location" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Vị Trí (Location) <span style="color: var(--ios-danger);">*</span></label>
                <input type="text" id="location" name="location" class="glass-input" placeholder="Ví dụ: Singapore, Hồ Chí Minh" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="ip_address" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Địa Chỉ IP <span style="color: var(--ios-danger);">*</span></label>
                <input type="text" id="ip_address" name="ip_address" class="glass-input" placeholder="103.x.x.x" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="api_port" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Cổng API (API Port)</label>
                <input type="number" id="api_port" name="api_port" class="glass-input" value="80" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="status" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Trạng Thái</label>
                <select id="status" name="status" class="glass-input" style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
                    <option value="active" selected style="background: #1e293b; color: #fff;">Hoạt động (Active)</option>
                    <option value="maintenance" style="background: #1e293b; color: #fff;">Bảo trì (Maintenance)</option>
                    <option value="offline" style="background: #1e293b; color: #fff;">Ngoại tuyến (Offline)</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
            <label for="api_token" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">API Token Kết Nối (Nếu có)</label>
            <input type="text" id="api_token" name="api_token" class="glass-input" placeholder="Nhập token bảo mật kết nối với Node API..." style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text); font-family: monospace;">
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.75rem 1.5rem; font-weight: 600; background: var(--ios-blue); color: #fff; border: none; cursor: pointer; border-radius: var(--radius-md);">Lưu Máy Chủ</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>