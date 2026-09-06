<footer style="margin-top: auto; padding: 1.5rem 1rem; text-align: center; color: var(--ios-text-secondary); font-size: 0.85rem;">
    <div class="container">
        <p>&copy; <?= date('Y') ?> VC VPN 2027. All rights reserved.</p>
    </div>
</footer>

<!-- Luôn tải app.js với tham số xóa cache -->
<script src="/assets/js/app.js?v=<?= time() ?>"></script>

<!-- Chỉ tải extraJs nếu khác file app.js -->
<?php if (isset($extraJs) && $extraJs !== 'app'): ?>
    <script src="/assets/js/<?= $extraJs ?>.js?v=<?= time() ?>"></script>
<?php endif; ?>
</body>
</html>