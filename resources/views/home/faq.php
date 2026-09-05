<?php
$pageTitle = "Câu Hỏi Thường Gặp - VC VPN 2027";
ob_start();
?>

<div style="text-align: center; margin-bottom: 2.5rem;">
    <h1 style="font-size: 2rem; font-weight: 700;">Câu Hỏi Thường Gặp (FAQ)</h1>
    <p style="color: var(--ios-text-secondary); margin-top: 0.5rem;">Giải đáp các thắc mắc phổ biến về dịch vụ VPN của chúng tôi</p>
</div>

<div style="display: flex; flex-direction: column; gap: 1rem; max-width: 800px; margin: 0 auto;">
    <div class="glass-card">
        <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--ios-blue);">1. Dịch vụ VPN này hỗ trợ những thiết bị nào?</h3>
        <p style="color: var(--ios-text-secondary); font-size: 0.95rem;">Hệ thống hỗ trợ tất cả các hệ điều hành phổ biến hiện nay như iOS, Android, Windows, macOS và Linux qua các ứng dụng kết nối chuyên dụng.</p>
    </div>

    <div class="glass-card">
        <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--ios-blue);">2. Tôi có thể chia sẻ tài khoản cho người khác dùng chung không?</h3>
        <p style="color: var(--ios-text-secondary); font-size: 0.95rem;">Mỗi gói dịch vụ đều quy định rõ số lượng thiết bị tối đa kết nối đồng thời. Bạn có thể sử dụng trên nhiều thiết bị trong hạn mức của gói đã mua.</p>
    </div>

    <div class="glass-card">
        <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--ios-blue);">3. Làm thế nào để gia hạn gói dịch vụ khi hết hạn?</h3>
        <p style="color: var(--ios-text-secondary); font-size: 0.95rem;">Bạn chỉ cần đăng nhập vào Bảng điều khiển (Dashboard), chọn Gói dịch vụ mong muốn và tiến hành thanh toán để gia hạn tự động.</p>
    </div>

    <div class="glass-card">
        <h3 style="font-size: 1.1rem; font-weight: 600; margin-bottom: 0.5rem; color: var(--ios-blue);">4. Tôi có thể nạp tiền vào ví bằng những phương thức nào?</h3>
        <p style="color: var(--ios-text-secondary); font-size: 0.95rem;">Hệ thống hỗ trợ nạp tiền tự động qua Chuyển khoản ngân hàng (QR Code) và các cổng thanh toán tích hợp.</p>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>