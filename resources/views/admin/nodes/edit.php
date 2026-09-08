<?php
$pageTitle = "Chỉnh Sửa Nút Kết Nối - Quản Trị Hệ Thống";
$activeMenu = "nodes";

ob_start();
?>

<div style="margin-bottom: 1.25rem;">
    <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Chỉnh Sửa Nút Kết Nối #<?= $node['id'] ?></h1>
</div>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-danger); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; font-size: 0.9rem; color: var(--ios-danger);"><?= htmlspecialchars($_SESSION['error']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div class="glass-card" style="padding: 1.75rem; width: 100%;">
    <form action="/admin/nodes/edit?id=<?= $node['id'] ?>" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Máy Chủ (*)</label>
                <select id="server_id" name="server_id" class="glass-input" required style="width: 100%; cursor: pointer;">
                    <option value="">-- Chọn Máy Chủ --</option>
                    <?php if (!empty($servers)): ?>
                        <?php foreach ($servers as $server): ?>
                            <option value="<?= $server['id'] ?>" <?= ($node['server_id'] ?? 0) == $server['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($server['name']) ?> (<?= htmlspecialchars($server['ip_address']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Cổng Kết Nối (Port) (*)</label>
                <input type="number" id="port" name="port" class="glass-input" value="<?= htmlspecialchars($node['port'] ?? '') ?>" required min="1" max="65535" style="width: 100%;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Giao Thức (Protocol) (*)</label>
                <select id="protocol" name="protocol" class="glass-input" required style="width: 100%; cursor: pointer;">
                    <?php 
                    $protocols = ['vmess', 'vless', 'trojan', 'shadowsocks', 'wireguard', 'hy2', 'tuic'];
                    foreach ($protocols as $proto):
                    ?>
                        <option value="<?= $proto ?>" <?= ($node['protocol'] ?? '') === $proto ? 'selected' : '' ?>><?= strtoupper($proto) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Mạng Truyền Tải (Network) (*)</label>
                <select id="network" name="network" class="glass-input" required style="width: 100%; cursor: pointer;">
                    <?php 
                    $networks = ['tcp', 'ws', 'grpc', 'udp', 'quic'];
                    foreach ($networks as $net):
                    ?>
                        <option value="<?= $net ?>" <?= ($node['network'] ?? '') === $net ? 'selected' : '' ?>><?= strtoupper($net) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Mã Hóa TLS</label>
                <select id="tls" name="tls" class="glass-input" style="width: 100%; cursor: pointer;">
                    <option value="1" <?= ($node['tls'] ?? 1) == 1 ? 'selected' : '' ?>>Bật TLS (1)</option>
                    <option value="0" <?= ($node['tls'] ?? 1) == 0 ? 'selected' : '' ?>>Tắt TLS (0)</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Miền SNI</label>
                <input type="text" id="sni" name="sni" class="glass-input" value="<?= htmlspecialchars($node['sni'] ?? '') ?>" style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Host HTTP</label>
                <input type="text" id="host" name="host" class="glass-input" value="<?= htmlspecialchars($node['host'] ?? '') ?>" style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Đường Dẫn (Path)</label>
                <input type="text" id="path" name="path" class="glass-input" value="<?= htmlspecialchars($node['path'] ?? '') ?>" style="width: 100%;">
            </div>
        </div>

        <div>
            <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Trạng Thái</label>
            <select id="status" name="status" class="glass-input" style="width: 100%; cursor: pointer;">
                <option value="active" <?= ($node['status'] ?? 'active') === 'active' ? 'selected' : '' ?>>Hoạt động (Active)</option>
                <option value="inactive" <?= ($node['status'] ?? '') === 'inactive' ? 'selected' : '' ?>>Tắt (Inactive)</option>
            </select>
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.65rem 1.75rem; font-size: 0.9rem;">💾 Cập Nhật Nút Kết Nối</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>