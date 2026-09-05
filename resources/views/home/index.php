<?php
$pageTitle = "VC VPN 2027 - Dịch Vụ VPN Tốc Độ Cao";
ob_start();
?>

<!-- Hero Section -->
<div class="glass-card" style="text-align: center; padding: 3rem 1.5rem; margin-bottom: 2rem; background: linear-gradient(135deg, rgba(0, 122, 255, 0.1), rgba(52, 199, 89, 0.05));">
    <h1 style="font-size: 2.5rem; font-weight: 800; margin-bottom: 1rem; letter-spacing: -0.5px;">Bảo Mật & Tốc Độ Không Giới Hạn</h1>
    <p style="color: var(--ios-text-secondary); max-width: 600px; margin: 0 auto 2rem; font-size: 1.1rem;">
        Trải nghiệm kết nối VPN thế hệ mới với hạ tầng tối ưu, bảo vệ quyền riêng tư tuyệt đối trên mọi thiết bị.
    </p>
    <div style="display: flex; gap: 1rem; justify-content: center; flex-wrap: wrap;">
        <a href="/home/plans" class="glass-btn" style="padding: 0.8rem 2rem; font-size: 1rem;">Xem Gói Dịch Vụ</a>
        <a href="/auth/register" class="glass-btn" style="padding: 0.8rem 2rem; font-size: 1rem; background: rgba(255, 255, 255, 0.2); color: var(--ios-text); border: 1px solid var(--glass-border);">Đăng Ký Ngay</a>
    </div>
</div>

<!-- Features Grid -->
<div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
    <div class="glass-card">
        <div style="font-size: 2rem; margin-bottom: 0.5rem;">⚡</div>
        <h3 style="margin-bottom: 0.5rem;">Tốc Độ Cực Đỉnh</h3>
        <p style="color: var(--ios-text-secondary); font-size: 0.9rem;">Hạ tầng băng thông rộng, tối ưu hóa cho xem phim 4K, chơi game và truyền dữ liệu dung lượng lớn.</p>
    </div>
    <div class="glass-card">
        <div style="font-size: 2rem; margin-bottom: 0.5rem;">🔒</div>
        <h3 style="margin-bottom: 0.5rem;">Mã Hóa An Toàn</h3>
        <p style="color: var(--ios-text-secondary); font-size: 0.9rem;">Hỗ trợ các giao thức hiện đại nhất như VMess, VLess, Trojan, WireGuard và HY2.</p>
    </div>
    <div class="glass-card">
        <div style="font-size: 2rem; margin-bottom: 0.5rem;">📱</div>
        <h3 style="margin-bottom: 0.5rem;">Đa Nền Tảng</h3>
        <p style="color: var(--ios-text-secondary); font-size: 0.9rem;">Dễ dàng đồng bộ và sử dụng trên iOS, Android, Windows, macOS và Linux.</p>
    </div>
</div>

<?php
$content = ob_get_clean();
require_once __DIR__ . '/../layouts/app.php';
?>