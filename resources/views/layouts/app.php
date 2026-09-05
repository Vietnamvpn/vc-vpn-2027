<?php require_once __DIR__ . '/header.php'; ?>
<?php require_once __DIR__ . '/navbar.php'; ?>

<main class="container">
    <?php if (isset($showSidebar) && $showSidebar): ?>
        <div class="admin-layout">
            <?php require_once __DIR__ . '/sidebar.php'; ?>
            <section class="admin-main">
                <?= $content ?? '' ?>
            </section>
        </div>
    <?php else: ?>
        <section style="padding: 1rem 0;">
            <?= $content ?? '' ?>
        </section>
    <?php endif; ?>
</main>

<?php require_once __DIR__ . '/footer.php'; ?>