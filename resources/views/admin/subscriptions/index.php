<?php
$pageTitle = "Quản Lý Gói Đăng Ký - Quản Trị Hệ Thống";
$activeMenu = "subscriptions";

ob_start();
?>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1rem; border-left: 4px solid <?= ($_SESSION['flash_type'] ?? '') === 'success' ? 'var(--ios-success)' : 'var(--ios-danger)' ?>; display: flex; justify-content: space-between; align-items: center; width: 100%; box-sizing: border-box;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<?php if (isset($_SESSION['error'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1rem; border-left: 4px solid var(--ios-danger); display: flex; justify-content: space-between; align-items: center; width: 100%; box-sizing: border-box;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['error']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['error']); ?>
    </div>
<?php endif; ?>

<div style="margin-bottom: 1rem; width: 100%; box-sizing: border-box; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 0.75rem;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; word-break: break-word;">Quản Lý Gói Đăng Ký VPN</h1>
        <p style="color: var(--ios-text-secondary); font-size: 0.85rem;">
            <?= !empty($filterUser) ? 'Danh sách gói đăng ký của người dùng: <strong>' . htmlspecialchars($filterUser['username']) . '</strong> (ID #' . $filterUser['id'] . ')' : 'Danh sách tài khoản VPN đang kích hoạt và theo dõi lưu lượng kết nối' ?>
        </p>
    </div>
    <?php if (!empty($userId)): ?>
        <div>
            <a href="/admin/subscriptions" class="glass-btn" style="text-decoration: none; white-space: nowrap; background: rgba(255, 59, 48, 0.1); color: var(--ios-danger);">✕ Xóa lọc tài khoản</a>
        </div>
    <?php endif; ?>
</div>

<!-- Bảng Đăng Ký VPN -->
<div class="glass-card" style="padding: 1.25rem; width: 100%; box-sizing: border-box;">
    <div class="table-responsive">
        <table class="glass-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Khách Hàng</th>
                    <th>Gói Cước</th>
                    <th style="text-align: center;">Online</th>
                    <th>Lưu Lượng Dùng</th>
                    <th>Ngày Bắt Đầu</th>
                    <th>Ngày Hết Hạn</th>
                    <th style="text-align: center;">Trạng Thái</th>
                    <th style="text-align: right;">Thao Tác</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($subscriptions)): ?>
                    <?php foreach ($subscriptions as $sub): ?>
                        <?php
                        $usedBytes = ($sub['upload'] ?? 0) + ($sub['download'] ?? 0);
                        $usedGB = round($usedBytes / (1024 * 1024 * 1024), 2);
                        $totalGB = round(($sub['transfer_enable'] ?? 0) / (1024 * 1024 * 1024), 2);
                        $onlineDevices = (int)($sub['online_devices'] ?? 0);
                        ?>
                        <tr>
                            <td style="font-weight: 700;">#<?= $sub['id'] ?></td>
                            <td>
                                <div style="font-weight: 700; font-size: 0.85rem;"><?= htmlspecialchars($sub['username'] ?? 'N/A') ?></div>
                                <div style="font-size: 0.78rem; color: var(--ios-text-secondary);"><?= htmlspecialchars($sub['email'] ?? '') ?></div>
                            </td>
                            <td style="font-weight: 600; font-size: 0.85rem; color: var(--ios-text);">
                                <?= htmlspecialchars($sub['plan_name'] ?? ('Gói #' . $sub['plan_id'])) ?>
                            </td>
                            <td style="text-align: center;">
                                <span style="padding: 0.15rem 0.5rem; border-radius: var(--radius-sm); font-size: 0.78rem; font-weight: 700; <?= $onlineDevices > 0 ? 'background: rgba(52, 199, 89, 0.15); color: var(--ios-success);' : 'background: rgba(142, 142, 147, 0.12); color: var(--ios-text-secondary);' ?>">
                                    📱 <?= $onlineDevices ?>
                                </span>
                            </td>
                            <td style="font-size: 0.85rem;">
                                <span style="font-weight: 700; color: var(--ios-blue);"><?= $usedGB ?> GB</span>
                                <span style="color: var(--ios-text-secondary);">/ <?= $totalGB > 0 ? $totalGB . ' GB' : '∞' ?></span>
                            </td>
                            <td style="font-size: 0.8rem; color: var(--ios-text-secondary);">
                                <?= date('d/m/Y', strtotime($sub['start_date'])) ?>
                            </td>
                            <td style="font-size: 0.8rem; color: var(--ios-text-secondary);">
                                <?= date('d/m/Y', strtotime($sub['end_date'])) ?>
                            </td>
                            <td style="text-align: center;">
                                <?php
                                $statusBadge = [
                                    'active'    => 'background: rgba(52, 199, 89, 0.15); color: var(--ios-success);',
                                    'expired'   => 'background: rgba(255, 149, 0, 0.15); color: var(--ios-warning);',
                                    'suspended' => 'background: rgba(255, 59, 48, 0.15); color: var(--ios-danger);',
                                    'cancelled' => 'background: rgba(142, 142, 147, 0.15); color: var(--ios-text-secondary);'
                                ];
                                ?>
                                <span style="padding: 0.2rem 0.5rem; border-radius: var(--radius-sm); font-size: 0.75rem; font-weight: 700; <?= $statusBadge[$sub['status'] ?? 'active'] ?? '' ?>">
                                    <?= strtoupper($sub['status'] ?? 'active') ?>
                                </span>
                            </td>
                            <td style="text-align: right;">
                                <div class="action-dropdown">
                                    <button type="button" class="action-btn" title="Thao tác">⋮</button>
                                    <div class="action-menu" style="min-width: 185px; white-space: nowrap;">
                                        <a href="/admin/subscriptions/detail?id=<?= $sub['id'] ?>" class="action-item" style="white-space: nowrap; display: flex; align-items: center; gap: 0.5rem;">
                                            <span>👁️</span> Xem chi tiết
                                        </a>
                                        <a href="javascript:void(0)" onclick="copySubLink('<?= htmlspecialchars($sub['uuid']) ?>')" class="action-item" style="white-space: nowrap; display: flex; align-items: center; gap: 0.5rem;">
                                            <span>📋</span> Sao chép Link
                                        </a>
                                        <a href="javascript:void(0)" onclick="openQrModal('<?= htmlspecialchars($sub['uuid']) ?>')" class="action-item" style="white-space: nowrap; display: flex; align-items: center; gap: 0.5rem;">
                                            <span>📱</span> Mã QR
                                        </a>

                                        <div style="border-top: 1px solid rgba(0, 0, 0, 0.08); margin: 0.25rem 0;"></div>

                                        <!-- Reset Token (UUID) -->
                                        <a href="/admin/subscriptions/reset-token?id=<?= $sub['id'] ?><?= !empty($userId) ? '&user_id=' . $userId : '' ?>" onclick="return confirm('Xác nhận đổi mã Token (UUID) mới cho gói này? Liên kết đăng ký cũ sẽ ngắt kết nối!');" class="action-item" style="white-space: nowrap; display: flex; align-items: center; gap: 0.5rem; color: #FF9500;">
                                            <span>🔑</span> Reset Token
                                        </a>

                                        <!-- Gia hạn gói -->
                                        <a href="/admin/subscriptions/renew?id=<?= $sub['id'] ?><?= !empty($userId) ? '&user_id=' . $userId : '' ?>" onclick="return confirm('Xác nhận gia hạn thêm thời hạn sử dụng cho gói đăng ký này?');" class="action-item" style="white-space: nowrap; display: flex; align-items: center; gap: 0.5rem; color: var(--ios-blue);">
                                            <span>🔄</span> Gia hạn gói
                                        </a>

                                        <!-- Reset lưu lượng -->
                                        <a href="/admin/subscriptions/reset-traffic?id=<?= $sub['id'] ?><?= !empty($userId) ? '&user_id=' . $userId : '' ?>" onclick="return confirm('Xác nhận đặt lại dung lượng đã sử dụng (Upload & Download) về 0 GB?');" class="action-item" style="white-space: nowrap; display: flex; align-items: center; gap: 0.5rem; color: #5856D6;">
                                            <span>⚡</span> Reset lưu lượng
                                        </a>

                                        <!-- Thay đổi trạng thái -->
                                        <?php if (($sub['status'] ?? '') !== 'active'): ?>
                                            <a href="/admin/subscriptions/update-status?id=<?= $sub['id'] ?>&status=active<?= !empty($userId) ? '&user_id=' . $userId : '' ?>" onclick="return confirm('Kích hoạt lại gói đăng ký này?');" class="action-item" style="white-space: nowrap; display: flex; align-items: center; gap: 0.5rem; color: var(--ios-success);">
                                                <span>✅</span> Kích hoạt gói
                                            </a>
                                        <?php endif; ?>

                                        <?php if (($sub['status'] ?? '') === 'active'): ?>
                                            <a href="/admin/subscriptions/update-status?id=<?= $sub['id'] ?>&status=suspended<?= !empty($userId) ? '&user_id=' . $userId : '' ?>" onclick="return confirm('Tạm dừng gói đăng ký này?');" class="action-item" style="white-space: nowrap; display: flex; align-items: center; gap: 0.5rem; color: var(--ios-warning);">
                                                <span>⏸️</span> Tạm dừng gói
                                            </a>
                                        <?php endif; ?>

                                        <?php if (($sub['status'] ?? '') !== 'cancelled'): ?>
                                            <a href="/admin/subscriptions/update-status?id=<?= $sub['id'] ?>&status=cancelled<?= !empty($userId) ? '&user_id=' . $userId : '' ?>" onclick="return confirm('Hủy gói đăng ký này?');" class="action-item" style="white-space: nowrap; display: flex; align-items: center; gap: 0.5rem; color: var(--ios-danger);">
                                                <span>❌</span> Hủy đăng ký
                                            </a>
                                        <?php endif; ?>

                                        <div style="border-top: 1px solid rgba(0, 0, 0, 0.08); margin: 0.25rem 0;"></div>

                                        <!-- Xóa gói đăng ký -->
                                        <a href="/admin/subscriptions/delete?id=<?= $sub['id'] ?><?= !empty($userId) ? '&user_id=' . $userId : '' ?>" onclick="return confirm('Bạn có chắc chắn muốn xóa vĩnh viễn gói đăng ký này khỏi hệ thống?');" class="action-item delete" style="white-space: nowrap; display: flex; align-items: center; gap: 0.5rem; color: var(--ios-danger);">
                                            <span>🗑️</span> Xóa gói
                                        </a>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <td colspan="9" style="text-align: center; padding: 2rem; color: var(--ios-text-secondary);">Chưa có tài khoản đăng ký VPN nào.</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Modal Hiển Thị Mã QR -->
<div id="qrModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.5); backdrop-filter: blur(5px); z-index: 9999; align-items: center; justify-content: center;">
    <div class="glass-card" style="padding: 1.5rem; max-width: 320px; width: 90%; text-align: center; position: relative; background: rgba(255, 255, 255, 0.95);">
        <h3 style="margin-top: 0; font-size: 1.1rem; font-weight: 700;">Quét Mã QR Đăng Ký</h3>
        <div style="margin: 1rem 0; padding: 0.75rem; background: #fff; border-radius: var(--radius-sm); display: inline-block;">
            <img id="qrCodeImg" src="" alt="QR Code" style="width: 200px; height: 200px; display: block;">
        </div>
        <div>
            <button type="button" onclick="closeQrModal()" class="glass-btn" style="width: 100%; padding: 0.5rem; font-weight: 600;">Đóng</button>
        </div>
    </div>
</div>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>