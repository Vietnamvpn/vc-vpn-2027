<?php
// Layout: resources/views/user/dashboard.php
// Bắt đầu lưu bộ đệm nội dung
ob_start();

// Lấy gói dịch vụ đang hoạt động (nếu có)
$activeSubscription = null;
if (!empty($subscriptions) && is_array($subscriptions)) {
    foreach ($subscriptions as $sub) {
        if (isset($sub['status']) && $sub['status'] === 'active') {
            $activeSubscription = $sub;
            break;
        }
    }
}
?>

<div class="container-fluid py-4">
    <!-- Thống kê chung -->
    <div class="row">
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Số dư tài khoản</p>
                                <h5 class="font-weight-bolder mb-0">
                                    <?= $formatMoney($user['balance'] ?? 0) ?>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-primary shadow text-center border-radius-md">
                                <i class="ni ni-money-coins text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Hoa hồng giới thiệu</p>
                                <h5 class="font-weight-bolder mb-0">
                                    <?= $formatMoney($user['commission_balance'] ?? 0) ?>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-success shadow text-center border-radius-md">
                                <i class="ni ni-paper-diploma text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Gói dịch vụ</p>
                                <h5 class="font-weight-bolder mb-0">
                                    <?= $activeSubscription ? htmlspecialchars($activeSubscription['plan_name'] ?? 'Đang hoạt động') : 'Chưa có' ?>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-info shadow text-center border-radius-md">
                                <i class="ni ni-world text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xl-3 col-sm-6">
            <div class="card">
                <div class="card-body p-3">
                    <div class="row">
                        <div class="col-8">
                            <div class="numbers">
                                <p class="text-sm mb-0 text-capitalize font-weight-bold">Trạng thái</p>
                                <h5 class="font-weight-bolder mb-0 text-<?= (($user['status'] ?? '') === 'active') ? 'success' : 'danger' ?>">
                                    <?= ucfirst($user['status'] ?? 'unknown') ?>
                                </h5>
                            </div>
                        </div>
                        <div class="col-4 text-end">
                            <div class="icon icon-shape bg-gradient-warning shadow text-center border-radius-md">
                                <i class="ni ni-check-bold text-lg opacity-10" aria-hidden="true"></i>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Chi tiết gói & Mã giới thiệu -->
    <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
            <div class="card">
                <div class="card-header pb-0 p-3">
                    <div class="d-flex justify-content-between">
                        <h6 class="mb-2">Gói dịch vụ đang hoạt động</h6>
                        <a href="/user/subscriptions" class="text-primary text-sm font-weight-bold">Xem tất cả</a>
                    </div>
                </div>
                <div class="card-body p-3">
                    <?php if($activeSubscription): ?>
                        <ul class="list-group">
                            <li class="list-group-item border-0 d-flex justify-content-between ps-0 mb-2 border-radius-lg">
                                <div class="d-flex align-items-center">
                                    <div class="icon icon-shape icon-sm me-3 bg-gradient-dark shadow text-center">
                                        <i class="ni ni-laptop text-white opacity-10"></i>
                                    </div>
                                    <div class="d-flex flex-column">
                                        <h6 class="mb-1 text-dark text-sm">Lưu lượng đã dùng</h6>
                                        <span class="text-xs">
                                            <?= number_format((($activeSubscription['upload'] ?? 0) + ($activeSubscription['download'] ?? 0)) / 1073741824, 2) ?> GB
                                        </span>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center text-dark text-sm font-weight-bold">
                                    Hết hạn: <?= isset($activeSubscription['end_date']) ? date('d/m/Y', strtotime($activeSubscription['end_date'])) : 'N/A' ?>
                                </div>
                            </li>
                        </ul>
                        <div class="mt-3">
                            <a href="/user/subscriptions/connect?id=<?= $activeSubscription['id'] ?? 0 ?>" class="btn btn-primary w-100">Kết nối VPN ngay</a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <p class="text-sm text-secondary mb-3">Bạn chưa có gói dịch vụ nào đang hoạt động.</p>
                            <a href="/user/plans" class="btn btn-outline-primary">Mua gói ngay</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
        <div class="col-lg-5">
            <div class="card h-100">
                <div class="card-header pb-0 p-3">
                    <h6 class="mb-0">Mã giới thiệu của bạn</h6>
                </div>
                <div class="card-body p-3">
                    <div class="border-dashed border-1 border-secondary border-radius-md p-3 text-center mb-3">
                        <h4 class="text-primary tracking-wide mb-0" id="refCode"><?= htmlspecialchars($user['ref_code'] ?? 'Chưa có') ?></h4>
                    </div>
                    <p class="text-sm">Chia sẻ mã này để nhận <strong class="text-dark"><?= htmlspecialchars($settings['referral_commission_rate'] ?? '10') ?>%</strong> hoa hồng mỗi khi người được giới thiệu thanh toán đơn hàng.</p>
                    <button class="btn btn-sm btn-dark w-100 mb-0" onclick="copyRefCode()">Sao chép liên kết</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function copyRefCode() {
    const refCode = document.getElementById('refCode').innerText;
    if (refCode === 'Chưa có') return;
    const link = window.location.origin + '/register?ref=' + refCode;
    navigator.clipboard.writeText(link).then(() => {
        alert('Đã sao chép liên kết giới thiệu!');
    });
}
</script>

<?php
// Kết thúc bộ đệm và gán vào biến $content
$content = ob_get_clean();

// Gọi layout chính của app
$showSidebar = true; // Bật Sidebar
$extraCss = 'app';   // Sử dụng CSS cho user/app
$extraJs = 'app';    // Sử dụng JS cho user/app
require_once __DIR__ . '/../layouts/app.php';
?>