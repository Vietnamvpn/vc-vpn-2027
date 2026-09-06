<?php 
$extraCss = 'admin';
$extraJs = 'admin';
require_once __DIR__ . '/header.php'; 
?>

<div class="admin-app">
    <!-- Navbar tràn ngang trên cùng -->
    <?php require_once __DIR__ . '/navbar.php'; ?>
    
    <div class="admin-body">
        <!-- Lớp phủ cho Mobile Sidebar -->
        <div class="sidebar-overlay"></div>

        <!-- Sidebar bên trái -->
        <?php require_once __DIR__ . '/admin-sidebar.php'; ?>
        
        <!-- Vùng nội dung cuộn bên phải -->
        <main class="admin-main">
            <div class="admin-content">
                <?= $content ?? '' ?>
            </div>
            <?php require_once __DIR__ . '/footer.php'; ?>
        </main>
    </div>
</div>