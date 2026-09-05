<footer style="margin-top: auto; padding: 2rem 1rem; text-align: center; color: var(--ios-text-secondary); font-size: 0.85rem;">
    <div class="container">
        <p>&copy; <?= date('Y') ?> VC VPN 2027. All rights reserved.</p>
    </div>
</footer>
<script src="/assets/js/app.js"></script>
<?php if (isset($extraJs)): ?>
    <script src="/assets/js/<?= $extraJs ?>.js"></script>
<?php endif; ?>
</body>
</html>