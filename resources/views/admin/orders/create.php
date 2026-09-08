<?php
$pageTitle = "Tạo Đơn Hàng Thủ Công - Quản Trị Hệ Thống";
$activeMenu = "orders";

ob_start();
?>

<div style="margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center;">
    <div>
        <h1 style="font-size: 1.6rem; font-weight: 700; letter-spacing: -0.5px;">Tạo Đơn Hàng Thủ Công</h1>
        <p style="color: var(--ios-text-secondary); font-size: 0.85rem;">Khởi tạo đơn hàng và tự động cấp gói cước cho thành viên</p>
    </div>
    <a href="/admin/users" class="glass-btn" style="text-decoration: none; white-space: nowrap;">← Quay lại</a>
</div>

<?php if (!empty($_SESSION['flash_message'])): ?>
    <div class="glass-card glass-alert" style="padding: 1rem 1.25rem; margin-bottom: 1.25rem; border-left: 4px solid var(--ios-danger); display: flex; justify-content: space-between; align-items: center;">
        <span style="font-weight: 500; font-size: 0.9rem;"><?= htmlspecialchars($_SESSION['flash_message']) ?></span>
        <button type="button" class="alert-close" style="background: none; border: none; color: var(--ios-text-secondary); font-size: 1.25rem; cursor: pointer; padding: 0 0.25rem; line-height: 1;" title="Đóng">&times;</button>
        <?php unset($_SESSION['flash_message'], $_SESSION['flash_type']); ?>
    </div>
<?php endif; ?>

<div class="glass-card" style="padding: 1.75rem; width: 100%;">
    <form method="POST" action="/admin/orders/create" style="display: flex; flex-direction: column; gap: 1.25rem;">
        
        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <!-- Chọn Người Dùng -->
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Người Dùng (*)</label>
                <select name="user_id" class="glass-input" required style="width: 100%; cursor: pointer;">
                    <option value="">-- Chọn thành viên --</option>
                    <?php if (!empty($users)): ?>
                        <?php foreach ($users as $u): ?>
                            <option value="<?= $u['id'] ?>" <?= $selectedUserId === (int)$u['id'] ? 'selected' : '' ?>>
                                #<?= $u['id'] ?> - <?= htmlspecialchars($u['username']) ?> (<?= htmlspecialchars($u['email']) ?>)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>

            <!-- Chọn Gói Cước -->
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Gói Cước (*)</label>
                <select name="plan_id" id="plan_select" class="glass-input" required style="width: 100%; cursor: pointer;" onchange="updatePriceHint(this)">
                    <option value="">-- Chọn gói cước --</option>
                    <?php if (!empty($plans)): ?>
                        <?php foreach ($plans as $p): ?>
                            <option value="<?= $p['id'] ?>" data-price="<?= (float)$p['price'] ?>">
                                <?= htmlspecialchars($p['name']) ?> (<?= number_format($p['price'], 0, ',', '.') ?> đ / <?= $p['duration_days'] ?> ngày)
                            </option>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </select>
            </div>
        </div>

        <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
            <!-- Số Tiền -->
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Số Tiền Thanh Toán (VNĐ)</label>
                <input type="number" name="amount" id="amount_input" class="glass-input" placeholder="Để trống để dùng giá mặc định của gói" step="1000" min="0" style="width: 100%;">
            </div>

            <!-- Trạng Thái Thanh Toán -->
            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Trạng Thái Đơn Hàng (*)</label>
                <select name="payment_status" class="glass-input" required style="width: 100%; cursor: pointer;">
                    <option value="completed" selected>Completed (Đã thanh toán & Cấp gói VPN)</option>
                    <option value="pending">Pending (Chờ thanh toán)</option>
                    <option value="failed">Failed (Thất bại)</option>
                    <option value="cancelled">Cancelled (Đã hủy)</option>
                </select>
            </div>
        </div>

        <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
            <button type="submit" class="glass-btn" style="padding: 0.65rem 1.75rem; font-size: 0.9rem;">🛒 Khởi Tạo Đơn Hàng</button>
        </div>
    </form>
</div>

<script>
function updatePriceHint(selectEl) {
    const selectedOption = selectEl.options[selectEl.selectedIndex];
    const price = selectedOption.getAttribute('data-price');
    const amountInput = document.getElementById('amount_input');
    if (price && amountInput) {
        amountInput.value = price;
    }
}
</script>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>