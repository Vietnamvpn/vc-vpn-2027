<?php
// Layout: resources/views/user/profile/index.php
// Bắt đầu lưu bộ đệm nội dung
ob_start();
?>

<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <!-- Form Đổi Mật Khẩu & Thông Tin -->
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Thông tin cá nhân & Đổi mật khẩu</p>
                    </div>
                </div>
                <div class="card-body">
                    <?php if (isset($_SESSION['success'])): ?>
                        <div class="alert alert-success text-white">
                            <?= htmlspecialchars($_SESSION['success']) ?>
                        </div>
                        <?php unset($_SESSION['success']); ?>
                    <?php endif; ?>
                    
                    <form action="/user/profile/update" method="POST">
                        <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($csrf_token ?? '') ?>">
                        
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username" class="form-control-label">Tên đăng nhập</label>
                                    <input class="form-control" type="text" id="username" value="<?= htmlspecialchars($user['username'] ?? '') ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-control-label">Địa chỉ Email</label>
                                    <input class="form-control" type="email" id="email" value="<?= htmlspecialchars($user['email'] ?? '') ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Ngày tham gia</label>
                                    <input class="form-control" type="text" value="<?= isset($user['created_at']) ? date('d/m/Y H:i', strtotime($user['created_at'])) : 'N/A' ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Liên kết Google</label>
                                    <input class="form-control" type="text" value="<?= !empty($user['google_id']) ? 'Đã liên kết' : 'Chưa liên kết' ?>" disabled>
                                </div>
                            </div>
                        </div>

                        <hr class="horizontal dark mt-4">
                        <p class="text-uppercase text-sm">Đổi mật khẩu mới</p>
                        <div class="row">
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label for="new_password" class="form-control-label">Mật khẩu mới (Để trống nếu không muốn đổi)</label>
                                    <input class="form-control" type="password" id="new_password" name="new_password" minlength="6" placeholder="Nhập mật khẩu mới">
                                </div>
                            </div>
                        </div>
                        
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary btn-sm ms-auto">Cập nhật mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        
        <div class="col-md-4">
            <!-- Thẻ User bên cạnh -->
            <div class="card card-profile">
                <div class="card-body pt-0">
                    <div class="text-center mt-4">
                        <h5>
                            <?= htmlspecialchars($user['username'] ?? 'Người dùng') ?>
                        </h5>
                        <div class="h6 font-weight-300">
                            <i class="ni location_pin mr-2"></i><?= htmlspecialchars($user['email'] ?? '') ?>
                        </div>
                        <div class="h6 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>Thành viên <?= ucfirst($user['role'] ?? 'user') ?>
                        </div>
                        <div class="mt-4 text-start">
                            <ul class="list-group">
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Số dư:</strong> <?= $formatMoney($user['balance'] ?? 0) ?></li>
                                <li class="list-group-item border-0 ps-0 text-sm"><strong class="text-dark">Hoa hồng:</strong> <?= $formatMoney($user['commission_balance'] ?? 0) ?></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
// Kết thúc bộ đệm và gán vào biến $content
$content = ob_get_clean();

// Gọi layout chính của app
$showSidebar = true;
$extraCss = 'app';
$extraJs = 'app';
require_once __DIR__ . '/../../layouts/app.php';
?>