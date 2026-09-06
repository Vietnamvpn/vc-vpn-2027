<?php 
$extraCss = 'auth';
$extraJs = 'auth';
require_once __DIR__ . '/header.php'; 
?>

<div class="auth-wrapper">
    <div class="glass-card auth-card">
        <div class="auth-header">
            <img src="/assets/images/logo.png" alt="Logo" class="logo">
            <h1><?= $authTitle ?? 'VC VPN 2027' ?></h1>
            <p><?= $authSubtitle ?? 'Hệ thống dịch vụ VPN cao cấp' ?></p>
        </div>
        
        <?= $content ?? '' ?>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>