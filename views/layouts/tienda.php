<?php
// C:\docker\app03_dgcm\views\layouts\tienda_layout.php
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
    <title><?= htmlspecialchars($title ?? 'Tienda') ?></title>
</head>

<body>
    <!-- Navbar Tienda -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/app03_dgcm/tienda">
                <img src="<?= asset('images/cit.png') ?>" width="35" class="me-2" alt="Logo">
                <span>Tienda</span>
            </a>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarTienda"
                aria-controls="navbarTienda" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarTienda">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/app03_dgcm/tienda">
                            <i class="bi bi-basket me-1"></i>Productos
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/app03_dgcm/categorias">
                            <i class="bi bi-tags me-1"></i>Categorías
                        </a>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'cliente'): ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/app03_dgcm/mis-pedidos">
                                <i class="bi bi-bag-check me-1"></i>Mis Pedidos
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/app03_dgcm/mi-perfil">
                                <i class="bi bi-person-gear me-1"></i>Mi Perfil
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link text-danger" href="/app03_dgcm/logout">
                                <i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión
                            </a>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/app03_dgcm/login">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="/app03_dgcm/registro-cliente">
                                <i class="bi bi-person-plus me-1"></i>Registrarse
                            </a>
                        </li>
                    <?php endif; ?>

                    <li class="nav-item position-relative">
                        <button type="button" class="btn nav-link position-relative"
                            data-bs-toggle="modal" data-bs-target="#modalCarrito">
                            <i class="bi bi-cart3"></i>
                            <span id="contadorCarrito"
                                class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                                <?= $contadorCarrito ?? 0 ?>
                            </span>
                        </button>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Barra de progreso fija -->
    <div class="progress fixed-bottom" style="height: 6px;">
        <div id="bar"
            class="progress-bar progress-bar-animated bg-danger"
            role="progressbar" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="container-fluid pt-5 mb-4" style="min-height:85vh;">
        <?= $contenido; ?>
    </div>

    <!-- Footer -->
    <footer class="text-center py-3 bg-light">
        <small style="font-size:xx-small; font-weight:bold;">
            Comando de Informática y Tecnología, <?= date('Y') ?>&copy;
        </small>
    </footer>
</body>

</html>