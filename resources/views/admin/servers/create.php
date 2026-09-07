<?php
$pageTitle = "Thêm Máy Chủ Mới - Quản Trị Hệ Thống";
$activeMenu = "servers";

ob_start();
?>

<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Thêm Máy Chủ Mới</h1>
    </div>
    <a href="/admin/servers" class="glass-btn" style="text-decoration: none; font-weight: 600;">⬅️ Quay Lại</a>
</div>

<?php if (isset($_SESSION['error'])): ?>
    <div style="background: rgba(255, 59, 48, 0.15); color: var(--ios-danger); padding: 0.75rem 1rem; border-radius: var(--radius-md); font-size: 0.875rem; border: 1px solid rgba(255, 59, 48, 0.3); margin-bottom: 1.25rem;">
        <?= htmlspecialchars($_SESSION['error']) ?>
    </div>
    <?php unset($_SESSION['error']); ?>
<?php endif; ?>

<div class="glass-card" style="padding: 1.5rem; max-width: 700px;">
    <form action="/admin/servers/create" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="name" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Tên Máy Chủ <span style="color: var(--ios-danger);">*</span></label>
                <input type="text" id="name" name="name" class="glass-input" placeholder="Ví dụ: Singapore 01 VIP" required autofocus style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="server_group_id" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Nhóm Máy Chủ <span style="color: var(--ios-danger);">*</span></label>
                <select id="server_group_id" name="server_group_id" class="glass-input" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
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
                <label for="ip_address" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">IP / Domain <span style="color: var(--ios-danger);">*</span></label>
                <input type="text" id="ip_address" name="ip_address" class="glass-input" placeholder="103.x.x.x hoặc sg1.node.com" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="port" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Cổng (Port) <span style="color: var(--ios-danger);">*</span></label>
                <input type="number" id="port" name="port" class="glass-input" value="443" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="rate" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Hệ Số Tính Dung Lượng</label>
                <input type="number" step="0.1" id="rate" name="rate" class="glass-input" value="1.0" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="type" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Giao Thức / Loại</label>
                <select id="type" name="type" class="glass-input" style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
                    <option value="sing-box" style="background: #1e293b; color: #fff;">Sing-Box</option>
                    <option value="xray" style="background: #1e293b; color: #fff;">Xray / V2Ray</option>
                    <option value="trojan" style="background: #1e293b; color: #fff;">Trojan</option>
                    <option value="vless" style="background: #1e293b; color: #fff;">VLESS</option>
                    <option value="vmess" style="background: #1e293b; color: #fff;">VMess</option>
                </select>
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="status" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Trạng Thái</label>
                <select id="status" name="status" class="glass-input" style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
                    <option value="active" selected style="background: #1e293b; color: #fff;">Hoạt động (Active)</option>
                    <option value="maintenance" style="background: #1e293b; color: #fff;">Bảo trì (Maintenance)</option>
                    <option value="inactive" style="background: #1e293b; color: #fff;">Tắt (Inactive)</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
            <label for="description" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Ghi Chú / Mô Tả</label>
            <textarea id="description" name="description" rows="3" class="glass-input" placeholder="Thông tin ghi chú về máy chủ..." style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text); resize: vertical;"></textarea>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.75rem 1.5rem; font-weight: 600; background: var(--ios-blue); color: #fff; border: none; cursor: pointer;">Lưu Máy Chủ</button>
            <a href="/admin/servers" class="glass-btn" style="padding: 0.75rem 1.5rem; font-weight: 600; text-decoration: none; text-align: center;">Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>