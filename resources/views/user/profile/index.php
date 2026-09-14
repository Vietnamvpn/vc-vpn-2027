<?php
// Layout: resources/views/user/profile/index.php
?>
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header pb-0">
                    <div class="d-flex align-items-center">
                        <p class="mb-0">Chỉnh sửa hồ sơ</p>
                    </div>
                </div>
                <div class="card-body">
                    <?php include __DIR__ . '/../../components/alert.php'; ?>
                    <form action="/user/profile/update" method="POST">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="username" class="form-control-label">Tên đăng nhập</label>
                                    <input class="form-control" type="text" id="username" value="<?= htmlspecialchars($user->username) ?>" disabled>
                                    <small class="text-muted">Tên đăng nhập không thể thay đổi.</small>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label for="email" class="form-control-label">Địa chỉ Email</label>
                                    <input class="form-control" type="email" id="email" name="email" value="<?= htmlspecialchars($user->email) ?>" required>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Ngày tham gia</label>
                                    <input class="form-control" type="text" value="<?= date('d/m/Y H:i', strtotime($user->created_at)) ?>" disabled>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="form-control-label">Liên kết Google</label>
                                    <input class="form-control" type="text" value="<?= !empty($user->google_id) ? 'Đã liên kết' : 'Chưa liên kết' ?>" disabled>
                                </div>
                            </div>
                        </div>
                        <hr class="horizontal dark">
                        <button type="submit" class="btn btn-primary btn-sm ms-auto">Cập nhật thông tin</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card card-profile">
                <div class="card-body pt-0">
                    <div class="text-center mt-4">
                        <h5>
                            <?= htmlspecialchars($user->username) ?>
                        </h5>
                        <div class="h6 font-weight-300">
                            <i class="ni location_pin mr-2"></i><?= htmlspecialchars($user->email) ?>
                        </div>
                        <div class="h6 mt-4">
                            <i class="ni business_briefcase-24 mr-2"></i>Thành viên <?= ucfirst($user->role) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>