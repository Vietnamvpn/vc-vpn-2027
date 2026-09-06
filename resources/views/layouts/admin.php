<?php 
$extraCss = 'admin';
$extraJs = 'app';
require_once __DIR__ . '/header.php'; 
?>

<div class="admin-app">
    <!-- Lớp phủ cho Mobile Sidebar Drawer -->
    <div class="sidebar-overlay"></div>

    <!-- Sidebar nằm song song bên trái trên Desktop -->
    <?php require_once __DIR__ . '/admin-sidebar.php'; ?>
    
    <!-- Vùng Nội dung + Navbar nằm vừa vặn bên phải Sidebar -->
    <div class="admin-main-wrapper">
        <?php require_once __DIR__ . '/navbar.php'; ?>
        
        <main class="admin-main">
            <div class="admin-content">
                <?= $content ?? '' ?>
            </div>
            <?php require_once __DIR__ . '/footer.php'; ?>
        </main>
    </div>
</div>