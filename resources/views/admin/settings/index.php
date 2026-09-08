<?php
$pageTitle = "Cài Đặt Hệ Thống - Quản Trị Hệ Thống";
$activeMenu = "settings";

ob_start();
?>

<style>
    /* CSS cho hệ thống Tab */
    .settings-tabs {
        display: flex;
        gap: 0.5rem;
        border-bottom: 1px solid var(--glass-border);
        margin-bottom: 1.5rem;
        overflow-x: auto;
        padding-bottom: 0.5rem;
    }
    .settings-tab-btn {
        background: rgba(255, 255, 255, 0.05);
        border: 1px solid var(--glass-border);
        border-radius: 8px;
        padding: 0.6rem 1.25rem;
        font-weight: 600;
        color: var(--ios-text-secondary);
        cursor: pointer;
        transition: all 0.3s ease;
        white-space: nowrap;
        font-size: 0.9rem;
    }
    .settings-tab-btn:hover {
        background: rgba(255, 255, 255, 0.1);
    }
    .settings-tab-btn.active {
        background: var(--ios-blue);
        color: #fff;
        border-color: var(--ios-blue);
    }
    .settings-tab-pane {
        display: none;
        animation: fadeInTab 0.3s ease;
    }
    .settings-tab-pane.active {
        display: block;
    }
    @keyframes fadeInTab {
        from { opacity: 0; transform: translateY(5px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>

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

<div style="margin-bottom: 1.5rem; width: 100%; box-sizing: border-box;">
    <div>
        <h1 style="font-size: 1.5rem; font-weight: 700; word-break: break-word;">Cài Đặt Hệ Thống</h1>
        <p style="color: var(--ios-text-secondary); font-size: 0.85rem;">Quản lý toàn diện các thông số của hệ thống VPN</p>
    </div>
</div>

<!-- Nút chuyển Tab -->
<div class="settings-tabs">
    <button class="settings-tab-btn active" data-target="tab-general">⚙️ Cấu Hình Chung</button>
    <button class="settings-tab-btn" data-target="tab-finance">💰 Tài Chính & Ưu Đãi</button>
    <button class="settings-tab-btn" data-target="tab-trial">🎁 Dùng Thử</button>
    <button class="settings-tab-btn" data-target="tab-bank">🏦 Đa Cổng Thanh Toán</button>
    <button class="settings-tab-btn" data-target="tab-email">📧 Cấu Hình Email</button>
</div>

<div class="settings-content">
    
    <!-- TAB 1: CẤU HÌNH CHUNG -->
    <div id="tab-general" class="settings-tab-pane active">
        <form method="POST" action="/admin/settings/save" class="glass-card" style="padding: 1.5rem; width: 100%; display: flex; flex-direction: column; gap: 1.25rem;">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem; color: var(--ios-blue);">
                Cấu Hình Website & Thương Hiệu
            </h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Trang Web (Site Title)</label>
                    <input type="text" name="settings[site_title]" class="glass-input" value="<?= htmlspecialchars($settings['site_title'] ?? 'VC VPN 2027') ?>" style="width: 100%;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Email Liên Hệ Hỗ Trợ</label>
                    <input type="email" name="settings[contact_email]" class="glass-input" value="<?= htmlspecialchars($settings['contact_email'] ?? 'support@vpn2s.linksub24h.com') ?>" style="width: 100%;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Kênh Telegram Hỗ Trợ</label>
                    <input type="text" name="settings[telegram_channel]" class="glass-input" value="<?= htmlspecialchars($settings['telegram_channel'] ?? '') ?>" placeholder="https://t.me/..." style="width: 100%;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Đường Dẫn Logo (URL)</label>
                    <input type="text" name="settings[site_logo]" class="glass-input" value="<?= htmlspecialchars($settings['site_logo'] ?? '/assets/images/logo.png') ?>" style="width: 100%;">
                </div>
            </div>

            <div>
                <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Mô Tả Trang Web (Meta Description)</label>
                <textarea name="settings[site_description]" rows="2" class="glass-input" style="width: 100%; resize: vertical;"><?= htmlspecialchars($settings['site_description'] ?? '') ?></textarea>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
                <button type="submit" class="glass-btn" style="padding: 0.75rem 2rem; background: var(--ios-blue); color: #fff; border: none; font-weight: 600; cursor: pointer;">
                    💾 Lưu Cấu Hình Chung
                </button>
            </div>
        </form>
    </div>

    <!-- TAB 2: TÀI CHÍNH & ƯU ĐÃI -->
    <div id="tab-finance" class="settings-tab-pane">
        <form method="POST" action="/admin/settings/save" class="glass-card" style="padding: 1.5rem; width: 100%; display: flex; flex-direction: column; gap: 1.25rem;">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem; color: var(--ios-success);">
                Cấu Hình Tài Chính & Ưu Đãi Giới Thiệu
            </h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tỷ Giá (VNĐ / 1 Đơn vị hệ thống)</label>
                    <input type="number" name="settings[exchange_rate]" class="glass-input" value="<?= htmlspecialchars($settings['exchange_rate'] ?? '1') ?>" min="1" step="1" style="width: 100%;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tỷ Lệ Hoa Hồng Giới Thiệu (%)</label>
                    <input type="number" name="settings[commission_rate]" class="glass-input" value="<?= htmlspecialchars($settings['commission_rate'] ?? '10') ?>" min="0" max="100" step="0.1" style="width: 100%;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Thưởng Khi Đăng Ký Có Mã Giới Thiệu (VNĐ)</label>
                    <input type="number" name="settings[referral_bonus]" class="glass-input" value="<?= htmlspecialchars($settings['referral_bonus'] ?? '0') ?>" min="0" step="1000" style="width: 100%;">
                </div>
                
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Số Tiền Nạp Tối Thiểu (VNĐ)</label>
                    <input type="number" name="settings[min_deposit]" class="glass-input" value="<?= htmlspecialchars($settings['min_deposit'] ?? '10000') ?>" min="0" step="1000" style="width: 100%;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Số Tiền Rút Tối Thiểu (VNĐ)</label>
                    <input type="number" name="settings[min_withdrawal]" class="glass-input" value="<?= htmlspecialchars($settings['min_withdrawal'] ?? '50000') ?>" min="0" step="1000" style="width: 100%;">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
                <button type="submit" class="glass-btn" style="padding: 0.75rem 2rem; background: var(--ios-success); color: #fff; border: none; font-weight: 600; cursor: pointer;">
                    💾 Lưu Tài Chính & Ưu Đãi
                </button>
            </div>
        </form>
    </div>

    <!-- TAB 3: DÙNG THỬ -->
    <div id="tab-trial" class="settings-tab-pane">
        <form method="POST" action="/admin/settings/save" class="glass-card" style="padding: 1.5rem; width: 100%; display: flex; flex-direction: column; gap: 1.25rem;">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem; color: #af52de;">
                🎁 Cấu Hình Gói Dùng Thử Cho Tài Khoản Mới
            </h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Trạng Thái Dùng Thử</label>
                    <select name="settings[trial_enabled]" class="glass-input" style="width: 100%; cursor: pointer;">
                        <option value="1" <?= ($settings['trial_enabled'] ?? '0') == '1' ? 'selected' : '' ?>>Bật</option>
                        <option value="0" <?= ($settings['trial_enabled'] ?? '0') == '0' ? 'selected' : '' ?>>Tắt</option>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Gói Cước Dùng Thử (Plan)</label>
                    <select name="settings[trial_plan_id]" class="glass-input" style="width: 100%; cursor: pointer;">
                        <option value="">-- Chọn Gói Cước --</option>
                        <?php foreach (($plans ?? []) as $plan): ?>
                            <option value="<?= $plan['id'] ?>" <?= ($settings['trial_plan_id'] ?? '') == $plan['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($plan['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Thời Gian Dùng Thử (Ngày)</label>
                    <input type="number" name="settings[trial_duration_days]" class="glass-input" value="<?= htmlspecialchars($settings['trial_duration_days'] ?? '3') ?>" min="1" step="1" style="width: 100%;">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
                <button type="submit" class="glass-btn" style="padding: 0.75rem 2rem; background: #af52de; color: #fff; border: none; font-weight: 600; cursor: pointer;">
                    💾 Lưu Cấu Hình Dùng Thử
                </button>
            </div>
        </form>
    </div>

    <!-- TAB 4: THÔNG TIN NGÂN HÀNG & ĐA CỔNG (QR) -->
    <div id="tab-bank" class="settings-tab-pane">
        <form method="POST" action="/admin/settings/save" class="glass-card" style="padding: 1.5rem; width: 100%; display: flex; flex-direction: column; gap: 1.5rem;">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem; color: #ff9500;">
                🏦 Cấu Hình Đa Cổng Thanh Toán
            </h2>

            <div style="display: flex; flex-direction: column; gap: 1rem; width: 100%; overflow-x: auto;">
                <!-- Dòng 1: Ngân Hàng VN -->
                <div style="display: grid; grid-template-columns: 120px 1fr 1fr 1fr; gap: 1rem; align-items: end; background: rgba(255,255,255,0.02); padding: 1rem; border-radius: 8px; border: 1px solid var(--glass-border); min-width: 800px;">
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Trạng Thái</label>
                        <select name="settings[enable_vietqr]" class="glass-input" style="width: 100%; cursor: pointer;">
                            <option value="1" <?= ($settings['enable_vietqr'] ?? '1') == '1' ? 'selected' : '' ?>>Bật</option>
                            <option value="0" <?= ($settings['enable_vietqr'] ?? '1') == '0' ? 'selected' : '' ?>>Tắt</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Ngân Hàng (Mã BIN)</label>
                        <input type="text" name="settings[bank_name]" class="glass-input" value="<?= htmlspecialchars($settings['bank_name'] ?? '') ?>" placeholder="VD: MB, VCB..." style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Số Tài Khoản</label>
                        <input type="text" name="settings[bank_account_number]" class="glass-input" value="<?= htmlspecialchars($settings['bank_account_number'] ?? '') ?>" placeholder="Nhập số tài khoản" style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Chủ Tài Khoản</label>
                        <input type="text" name="settings[bank_account_name]" class="glass-input" value="<?= htmlspecialchars($settings['bank_account_name'] ?? '') ?>" placeholder="VD: NGUYEN VAN A" style="width: 100%; text-transform: uppercase;">
                    </div>
                </div>

                <!-- Dòng 2: WeChat -->
                <div style="display: grid; grid-template-columns: 120px 1fr 1fr 1fr; gap: 1rem; align-items: end; background: rgba(255,255,255,0.02); padding: 1rem; border-radius: 8px; border: 1px solid var(--glass-border); min-width: 800px;">
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Trạng Thái</label>
                        <select name="settings[enable_wechat]" class="glass-input" style="width: 100%; cursor: pointer;">
                            <option value="1" <?= ($settings['enable_wechat'] ?? '0') == '1' ? 'selected' : '' ?>>Bật</option>
                            <option value="0" <?= ($settings['enable_wechat'] ?? '0') == '0' ? 'selected' : '' ?>>Tắt</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Ngân Hàng / Cổng</label>
                        <input type="text" class="glass-input" value="WeChat Pay" readonly style="width: 100%; background: rgba(0,0,0,0.1); color: var(--ios-text-secondary); cursor: not-allowed;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Link Ảnh QR WeChat</label>
                        <input type="text" name="settings[wechat_qr_image]" class="glass-input" value="<?= htmlspecialchars($settings['wechat_qr_image'] ?? '') ?>" placeholder="https://..." style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Chủ Tài Khoản</label>
                        <input type="text" name="settings[wechat_account_name]" class="glass-input" value="<?= htmlspecialchars($settings['wechat_account_name'] ?? '') ?>" placeholder="Tên hiển thị WeChat" style="width: 100%;">
                    </div>
                </div>

                <!-- Dòng 3: Alipay -->
                <div style="display: grid; grid-template-columns: 120px 1fr 1fr 1fr; gap: 1rem; align-items: end; background: rgba(255,255,255,0.02); padding: 1rem; border-radius: 8px; border: 1px solid var(--glass-border); min-width: 800px;">
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Trạng Thái</label>
                        <select name="settings[enable_alipay]" class="glass-input" style="width: 100%; cursor: pointer;">
                            <option value="1" <?= ($settings['enable_alipay'] ?? '0') == '1' ? 'selected' : '' ?>>Bật</option>
                            <option value="0" <?= ($settings['enable_alipay'] ?? '0') == '0' ? 'selected' : '' ?>>Tắt</option>
                        </select>
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Ngân Hàng / Cổng</label>
                        <input type="text" class="glass-input" value="Alipay" readonly style="width: 100%; background: rgba(0,0,0,0.1); color: var(--ios-text-secondary); cursor: not-allowed;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Link Ảnh QR Alipay</label>
                        <input type="text" name="settings[alipay_qr_image]" class="glass-input" value="<?= htmlspecialchars($settings['alipay_qr_image'] ?? '') ?>" placeholder="https://..." style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Chủ Tài Khoản</label>
                        <input type="text" name="settings[alipay_account_name]" class="glass-input" value="<?= htmlspecialchars($settings['alipay_account_name'] ?? '') ?>" placeholder="Tên hiển thị Alipay" style="width: 100%;">
                    </div>
                </div>

                <!-- Dòng cuối: Cú Pháp Nạp / Thanh Toán -->
                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; align-items: end; border-top: 1px solid var(--glass-border); padding-top: 1rem;">
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Cú Pháp Nạp Tiền</label>
                        <input type="text" name="settings[bank_transfer_syntax]" class="glass-input" value="<?= htmlspecialchars($settings['bank_transfer_syntax'] ?? 'NAPTIEN') ?>" placeholder="VD: NAPTIEN" style="width: 100%;">
                    </div>
                    <div>
                        <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Cú Pháp Thanh Toán Đơn</label>
                        <input type="text" name="settings[order_transfer_syntax]" class="glass-input" value="<?= htmlspecialchars($settings['order_transfer_syntax'] ?? 'THANHTOAN') ?>" placeholder="VD: THANHTOAN" style="width: 100%;">
                    </div>
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
                <button type="submit" class="glass-btn" style="padding: 0.75rem 2rem; background: #ff9500; color: #fff; border: none; font-weight: 600; cursor: pointer;">
                    💾 Lưu Cấu Hình Đa Cổng
                </button>
            </div>
        </form>
    </div>

    <!-- TAB 5: CẤU HÌNH EMAIL -->
    <div id="tab-email" class="settings-tab-pane">
        <form method="POST" action="/admin/settings/save" class="glass-card" style="padding: 1.5rem; width: 100%; display: flex; flex-direction: column; gap: 1.25rem;">
            <h2 style="font-size: 1.1rem; font-weight: 700; margin-bottom: 0.5rem; border-bottom: 1px solid var(--glass-border); padding-bottom: 0.5rem; color: var(--ios-danger);">
                Cấu Hình Máy Chủ Gửi Email (SMTP)
            </h2>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Máy Chủ SMTP (Host)</label>
                    <input type="text" name="settings[smtp_host]" class="glass-input" value="<?= htmlspecialchars($settings['smtp_host'] ?? '') ?>" placeholder="VD: smtp.gmail.com" style="width: 100%;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Cổng (Port)</label>
                    <input type="number" name="settings[smtp_port]" class="glass-input" value="<?= htmlspecialchars($settings['smtp_port'] ?? '465') ?>" placeholder="VD: 465 hoặc 587" style="width: 100%;">
                </div>
                
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Phương Thức Mã Hóa (Encryption)</label>
                    <select name="settings[smtp_encryption]" class="glass-input" style="width: 100%;">
                        <option value="ssl" <?= ($settings['smtp_encryption'] ?? '') === 'ssl' ? 'selected' : '' ?>>SSL</option>
                        <option value="tls" <?= ($settings['smtp_encryption'] ?? '') === 'tls' ? 'selected' : '' ?>>TLS</option>
                        <option value="none" <?= ($settings['smtp_encryption'] ?? '') === 'none' ? 'selected' : '' ?>>None</option>
                    </select>
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tài Khoản Đăng Nhập (Username)</label>
                    <input type="text" name="settings[smtp_username]" class="glass-input" value="<?= htmlspecialchars($settings['smtp_username'] ?? '') ?>" placeholder="Email của bạn" style="width: 100%;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Mật Khẩu / App Password</label>
                    <input type="password" name="settings[smtp_password]" class="glass-input" value="<?= htmlspecialchars($settings['smtp_password'] ?? '') ?>" placeholder="Mật khẩu ứng dụng" style="width: 100%;">
                </div>
            </div>

            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.25rem;">
                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Địa Chỉ Gửi (Mail From Address)</label>
                    <input type="email" name="settings[mail_from_address]" class="glass-input" value="<?= htmlspecialchars($settings['mail_from_address'] ?? '') ?>" placeholder="no-reply@domain.com" style="width: 100%;">
                </div>

                <div>
                    <label style="display: block; font-weight: 600; font-size: 0.85rem; margin-bottom: 0.4rem;">Tên Người Gửi (Mail From Name)</label>
                    <input type="text" name="settings[mail_from_name]" class="glass-input" value="<?= htmlspecialchars($settings['mail_from_name'] ?? 'VC VPN') ?>" placeholder="VD: Hệ thống VC VPN" style="width: 100%;">
                </div>
            </div>

            <div style="display: flex; justify-content: flex-end; margin-top: 0.5rem;">
                <button type="submit" class="glass-btn" style="padding: 0.75rem 2rem; background: var(--ios-danger); color: #fff; border: none; font-weight: 600; cursor: pointer;">
                    💾 Lưu Cấu Hình Email
                </button>
            </div>
        </form>
    </div>

</div>

<!-- Script xử lý chuyển Tab & Lưu trạng thái -->
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const tabBtns = document.querySelectorAll('.settings-tab-btn');
        const tabPanes = document.querySelectorAll('.settings-tab-pane');
        
        // Kiểm tra xem có tab nào đang được lưu trong localStorage không
        const activeTabId = localStorage.getItem('vc_active_settings_tab') || 'tab-general';
        
        function activateTab(tabId) {
            tabBtns.forEach(btn => {
                btn.classList.toggle('active', btn.dataset.target === tabId);
            });
            tabPanes.forEach(pane => {
                pane.classList.toggle('active', pane.id === tabId);
            });
            // Lưu lại trạng thái tab
            localStorage.setItem('vc_active_settings_tab', tabId);
        }

        // Gắn sự kiện click cho các nút
        tabBtns.forEach(btn => {
            btn.addEventListener('click', function(e) {
                e.preventDefault();
                activateTab(this.dataset.target);
            });
        });

        // Kích hoạt tab ban đầu
        activateTab(activeTabId);
    });
</script>

<?php
$content = ob_get_clean();
require BASE_PATH . '/resources/views/layouts/admin.php';
?>