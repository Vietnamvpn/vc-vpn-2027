<?php 
$extraCss = 'admin';
$extraJs = 'admin';
require_once __DIR__ . '/header.php'; 
?>

<div class="admin-layout">
    <!-- Lớp phủ cho Mobile Sidebar -->
    <div class="sidebar-overlay"></div>

    <?php require_once __DIR__ . '/admin-sidebar.php'; ?>
    
    <div class="admin-main-wrapper">
        <?php require_once __DIR__ . '/navbar.php'; ?>
        
        <main class="admin-main">
            <?= $content ?? '' ?>
        </main>
    </div>
</div>

<?php require_once __DIR__ . '/footer.php'; ?>