<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/vue@3/dist/vue.global.prod.js"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="<?= BASE_URL ?>/public/js/utils.js"></script>
<script src="<?= BASE_URL ?>/public/js/app.js"></script>
<?php if (!empty($jsExtra)): ?>
    <script src="<?= BASE_URL ?>/public/js/<?= $jsExtra ?>"></script>
<?php endif; ?>
</body>

</html>
