<?php
// Layout: resources/views/user/profile/password.php
?>
<div class="container-fluid py-4">
    <div class="row justify-content-center">
        <div class="col-md-6">
            <div class="card">
                <div class="card-header pb-0">
                    <h6 class="mb-0">Đổi mật khẩu</h6>
                </div>
                <div class="card-body">
                    <?php include __DIR__ . '/../../components/alert.php'; ?>
                    <form action="/user/profile/password/update" method="POST">
                        <div class="form-group">
                            <label for="current_password" class="form-control-label">Mật khẩu hiện tại</label>
                            <input class="form-control" type="password" id="current_password" name="current_password" required>
                        </div>
                        <div class="form-group">
                            <label for="new_password" class="form-control-label">Mật khẩu mới</label>
                            <input class="form-control" type="password" id="new_password" name="new_password" required minlength="6">
                        </div>
                        <div class="form-group">
                            <label for="confirm_password" class="form-control-label">Xác nhận mật khẩu mới</label>
                            <input class="form-control" type="password" id="confirm_password" name="confirm_password" required minlength="6">
                        </div>
                        <div class="text-end mt-4">
                            <button type="submit" class="btn btn-primary btn-sm mb-0">Đổi mật khẩu</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>