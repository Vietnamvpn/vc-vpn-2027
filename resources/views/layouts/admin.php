<?php 
$extraCss = 'admin';
$extraJs = 'app';
require_once __DIR__ . '/header.php'; 
?>

<!-- Màn hình chờ Đang tải... -->
<div id="page-preloader">
    <div class="preloader-spinner"></div>
    <div class="preloader-text">Đang tải...</div>
</div>

<div class="admin-app">
    <?php require_once __DIR__ . '/admin-sidebar.php'; ?>
    
    <div class="admin-main-wrapper">
        <?php require_once __DIR__ . '/navbar.php'; ?>
        
        <div class="sidebar-overlay"></div>

        <main class="admin-main">
            <div class="admin-content">
                <?= $content ?? '' ?>
            </div>
            <?php require_once __DIR__ . '/footer.php'; ?>
        </main>
    </div>
</div>