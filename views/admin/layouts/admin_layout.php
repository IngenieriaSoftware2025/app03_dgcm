<?php
// ARCHIVO: views/admin/layouts/admin_layout.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="<?= asset('build/js/app.js') ?>"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title><?= htmlspecialchars($title ?? 'Panel Administrador') ?></title>
</head>

<body>
    <!-- Include del navbar admin -->
    <?php include __DIR__ . '/../../shared/components/navbar_admin.php'; ?>

    <!-- Barra de progreso fija -->
    <div class="progress fixed-bottom" style="height: 6px;">
        <div id="bar" class="progress-bar progress-bar-animated bg-danger"
            role="progressbar" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="container-fluid pt-4 mb-4" style="min-height:85vh;">
        <?= $contenido; ?>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 bg-light">
        <small style="font-size:xx-small; font-weight:bold;">
            <i class="bi bi-shield-fill me-1"></i>
            Panel Administrador - Comando de Informática y Tecnología, <?= date('Y') ?>&copy;
        </small>
    </footer>
</body>

</html>