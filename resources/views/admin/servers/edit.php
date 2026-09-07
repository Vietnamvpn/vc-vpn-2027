<?php
$pageTitle = "Chỉnh Sửa Máy Chủ - Quản Trị Hệ Thống";
$activeMenu = "servers";

ob_start();
?>

<div style="margin-bottom: 1.5rem; display: flex; justify-content: space-between; align-items: center; gap: 1rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; margin: 0;">Chỉnh Sửa Máy Chủ: <?= htmlspecialchars($server['name'] ?? '') ?></h1>
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
    <form action="/admin/servers/edit?id=<?= $server['id'] ?>" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="name" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Tên Máy Chủ <span style="color: var(--ios-danger);">*</span></label>
                <input type="text" id="name" name="name" class="glass-input" value="<?= htmlspecialchars($server['name'] ?? '') ?>" required autofocus style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="server_group_id" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Nhóm Máy Chủ <span style="color: var(--ios-danger);">*</span></label>
                <select id="server_group_id" name="server_group_id" class="glass-input" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
                    <option value="" style="background: #1e293b; color: #fff;">-- Chọn Nhóm --</option>
                    <?php if (!empty($groups)): ?>
                        <?php foreach ($groups as $group): ?>
                            <option value="<?= $group['id'] ?>" <?= ($server['server_group_id'] ?? '') == $group['id'] ? 'selected' : '' ?> style="background: #1e293b; color: #fff;"><?= htmlspecialchars($group['name']) ?></option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="ip_address" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">IP / Domain <span style="color: var(--ios-danger);">*</span></label>
                <input type="text" id="ip_address" name="ip_address" class="glass-input" value="<?= htmlspecialchars($server['ip_address'] ?? '') ?>" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="port" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Cổng (Port) <span style="color: var(--ios-danger);">*</span></label>
                <input type="number" id="port" name="port" class="glass-input" value="<?= htmlspecialchars($server['port'] ?? '443') ?>" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="rate" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Hệ Số Tính Dung Lượng</label>
                <input type="number" step="0.1" id="rate" name="rate" class="glass-input" value="<?= htmlspecialchars($server['rate'] ?? '1.0') ?>" required style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="type" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Giao Thức / Loại</label>
                <select id="type" name="type" class="glass-input" style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
                    <option value="sing-box" <?= ($server['type'] ?? '') === 'sing-box' ? 'selected' : '' ?> style="background: #1e293b; color: #fff;">Sing-Box</option>
                    <option value="xray" <?= ($server['type'] ?? '') === 'xray' ? 'selected' : '' ?> style="background: #1e293b; color: #fff;">Xray / V2Ray</option>
                    <option value="trojan" <?= ($server['type'] ?? '') === 'trojan' ? 'selected' : '' ?> style="background: #1e293b; color: #fff;">Trojan</option>
                    <option value="vless" <?= ($server['type'] ?? '') === 'vless' ? 'selected' : '' ?> style="background: #1e293b; color: #fff;">VLESS</option>
                    <option value="vmess" <?= ($server['type'] ?? '') === 'vmess' ? 'selected' : '' ?> style="background: #1e293b; color: #fff;">VMess</option>
                </select>
            </div>

            <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
                <label for="status" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Trạng Thái</label>
                <select id="status" name="status" class="glass-input" style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text);">
                    <option value="active" <?= ($server['status'] ?? '') === 'active' ? 'selected' : '' ?> style="background: #1e293b; color: #fff;">Hoạt động (Active)</option>
                    <option value="maintenance" <?= ($server['status'] ?? '') === 'maintenance' ? 'selected' : '' ?> style="background: #1e293b; color: #fff;">Bảo trì (Maintenance)</option>
                    <option value="inactive" <?= ($server['status'] ?? '') === 'inactive' ? 'selected' : '' ?> style="background: #1e293b; color: #fff;">Tắt (Inactive)</option>
                </select>
            </div>
        </div>

        <div class="form-group" style="display: flex; flex-direction: column; gap: 0.4rem;">
            <label for="description" style="font-weight: 600; font-size: 0.875rem; color: var(--ios-text-secondary);">Ghi Chú / Mô Tả</label>
            <textarea id="description" name="description" rows="3" class="glass-input" style="padding: 0.75rem; border-radius: var(--radius-md); border: 1px solid var(--glass-border); background: rgba(255, 255, 255, 0.05); color: var(--ios-text); resize: vertical;"><?= htmlspecialchars($server['description'] ?? '') ?></textarea>
        </div>

        <div style="display: flex; gap: 1rem; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.75rem 1.5rem; font-weight: 600; background: var(--ios-blue); color: #fff; border: none; cursor: pointer;">Cập Nhật</button>
            <a href="/admin/servers" class="glass-btn" style="padding: 0.75rem 1.5rem; font-weight: 600; text-decoration: none; text-align: center;">Hủy</a>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>