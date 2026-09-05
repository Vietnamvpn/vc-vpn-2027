<?php
$pageTitle = "Liên Hệ - VC VPN 2027";
ob_start();
?>

<div style="text-align: center; margin-bottom: 2.5rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">Liên Hệ Hỗ Trợ</h1>
    <p style="color: var(--ios-text-secondary); margin-top: 0.5rem;">Gửi tin nhắn cho chúng tôi nếu bạn cần giúp đỡ hoặc có thắc mắc</p>
</div>

<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(300px, 1fr)); gap: 2rem;">
    <div style="display: flex; flex-direction: column; gap: 1rem;">
        <div class="glass-card">
            <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">📧 Email Hỗ Trợ</h3>
            <p style="color: var(--ios-text-secondary); font-size: 0.95rem;">support@domain.com</p>
        </div>
        <div class="glass-card">
            <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">💬 Kênh Telegram</h3>
            <p style="color: var(--ios-text-secondary); font-size: 0.95rem;">@VC_VPN_Support</p>
        </div>
        <div class="glass-card">
            <h3 style="font-size: 1.1rem; margin-bottom: 0.5rem;">⏰ Thời Gian Làm Việc</h3>
            <p style="color: var(--ios-text-secondary); font-size: 0.95rem;">24/7 - Hỗ trợ liên tục tất cả các ngày trong tuần.</p>
        </div>
    </div>

    <div class="glass-card">
        <form action="/home/contact" method="POST" style="display: flex; flex-direction: column; gap: 1rem;">
            <div class="form-group">
                <label for="name">Họ và tên</label>
                <input type="text" id="name" name="name" class="glass-input" placeholder="Nhập họ và tên" required>
            </div>
            <div class="form-group">
                <label for="email">Địa chỉ Email</label>
                <input type="email" id="email" name="email" class="glass-input" placeholder="nhap@email.com" required>
            </div>
            <div class="form-group">
                <label for="subject">Chủ đề</label>
                <input type="text" id="subject" name="subject" class="glass-input" placeholder="Cần hỗ trợ về..." required>
            </div>
            <div class="form-group">
                <label for="message">Nội dung tin nhắn</label>
                <textarea id="message" name="message" class="glass-input" rows="4" placeholder="Viết nội dung tin nhắn của bạn ở đây..." required style="resize: vertical;"></textarea>
            </div>
            <button type="submit" class="glass-btn" style="width: 100%; margin-top: 0.5rem;">Gửi Tin Nhắn</button>
        </form>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>