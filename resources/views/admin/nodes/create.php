<?php
$pageTitle = "Thêm Nút Kết Nối Mới - Quản Trị Hệ Thống";
$activeMenu = "nodes";

ob_start();
?>

<div style="margin-bottom: 1.25rem;">
    <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Thêm Nút Kết Nối Mới</h1>
</div>

<?php if (!empty($_SESSION['error'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-danger); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; font-size: 0.9rem; color: var(--ios-danger);"><?= htmlspecialchars($_SESSION['error']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div class="glass-card" style="padding: 1.75rem; width: 100%;">
    <form action="/admin/nodes/create" method="POST" style="display: flex; flex-direction: column; gap: 1.25rem;">
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Máy Chủ (*)</label>
                <select id="server_id" name="server_id" class="glass-input" required style="width: 100%; cursor: pointer;">
                    <option value="">-- Chọn Máy Chủ --</option>
                    <?php if (!empty($servers)): ?>
                        <?php foreach ($servers as $server): ?>
                            <option value="<?= $server['id'] ?>"><?= htmlspecialchars($server['name']) ?> (<?= htmlspecialchars($server['ip_address']) ?>)</option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Cổng Kết Nối (Port) (*)</label>
                <input type="number" id="port" name="port" class="glass-input" placeholder="443, 8080, 8443..." required min="1" max="65535" style="width: 100%;">
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Giao Thức (Protocol) (*)</label>
                <select id="protocol" name="protocol" class="glass-input" required style="width: 100%; cursor: pointer;">
                    <option value="vless" selected>VLESS</option>
                    <option value="vmess">VMess</option>
                    <option value="trojan">Trojan</option>
                    <option value="shadowsocks">Shadowsocks</option>
                    <option value="wireguard">WireGuard</option>
                    <option value="hy2">Hysteria 2 (HY2)</option>
                    <option value="tuic">TUIC</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Mạng Truyền Tải (Network) (*)</label>
                <select id="network" name="network" class="glass-input" required style="width: 100%; cursor: pointer;">
                    <option value="tcp" selected>TCP</option>
                    <option value="ws">WebSocket (WS)</option>
                    <option value="grpc">gRPC</option>
                    <option value="udp">UDP</option>
                    <option value="quic">QUIC</option>
                </select>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Mã Hóa TLS</label>
                <select id="tls" name="tls" class="glass-input" style="width: 100%; cursor: pointer;">
                    <option value="1" selected>Bật TLS (1)</option>
                    <option value="0">Tắt TLS (0)</option>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(200px, 1fr)); gap: 1.25rem;">
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Miền SNI</label>
                <input type="text" id="sni" name="sni" class="glass-input" placeholder="sni.domain.com" style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Host HTTP</label>
                <input type="text" id="host" name="host" class="glass-input" placeholder="host.domain.com" style="width: 100%;">
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Đường Dẫn (Path)</label>
                <input type="text" id="path" name="path" class="glass-input" placeholder="/ray hoặc ServiceName" style="width: 100%;">
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
            <button type="submit" class="glass-btn" style="padding: 0.65rem 1.75rem; font-size: 0.9rem;">💾 Lưu Nút Kết Nối</button>
        </div>
    </form>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>