<?php 
$extraCss = 'admin';
$extraJs = 'admin';
require_once __DIR__ . '/header.php'; 
?>

<div class="admin-layout">
    <?php require_once __DIR__ . '/admin-sidebar.php'; ?>
    
    <div style="display: flex; flex-direction: column; width: 100%;">
        <?php require_once __DIR__ . '/navbar.php'; ?>
        
        <main class="admin-main">
            <?= $content ?? '' ?>
        </main>
        
        <?php require_once __DIR__ . '/footer.php'; ?>
    </div>
</div>