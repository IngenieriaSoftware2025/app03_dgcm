<?php
// ARCHIVO: views/tienda/layouts/tienda_layout.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= asset('build/js/app.js') ?>"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title><?= htmlspecialchars($titulo ?? 'Tienda de Celulares') ?></title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarTienda" aria-controls="navbarTienda" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="/app03_dgcm/tienda">
                <img src="<?= asset('images/cit.png') ?>" width="35px" alt="logo">
                📱 Tienda de Celulares
            </a>

            <div class="collapse navbar-collapse" id="navbarTienda">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
                    <li class="nav-item">
                        <a class="nav-link" href="/app03_dgcm/tienda">
                            <i class="bi bi-house-fill me-2"></i>Inicio
                        </a>
                    </li>

                    <div class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-phone me-2"></i>Productos
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark" style="margin: 0;">
                            <li>
                                <a class="dropdown-item nav-link text-white" href="/app03_dgcm/tienda/categoria?cat=smartphones">
                                    <i class="ms-lg-0 ms-2 bi bi-phone me-2"></i>Smartphones
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white" href="/app03_dgcm/tienda/categoria?cat=accesorios">
                                    <i class="ms-lg-0 ms-2 bi bi-headphones me-2"></i>Accesorios
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item nav-link text-white" href="/app03_dgcm/tienda/ofertas">
                                    <i class="ms-lg-0 ms-2 bi bi-tags me-2"></i>Ofertas
                                </a>
                            </li>
                        </ul>
                    </div>

                    <li class="nav-item">
                        <a class="nav-link" href="/app03_dgcm/tienda/contacto">
                            <i class="bi bi-envelope me-2"></i>Contacto
                        </a>
                    </li>
                </ul>

                <!-- Buscador simple -->
                <div class="col-lg-3 d-flex mb-lg-0 mb-2">
                    <input type="search" class="form-control me-2" placeholder="Buscar productos..." id="searchInput">
                    <button class="btn btn-outline-light" type="button">
                        <i class="bi bi-search"></i>
                    </button>
                </div>

                <!-- Carrito y Usuario -->
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <!-- Carrito -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="/app03_dgcm/tienda/carrito">
                            <i class="bi bi-cart3 me-1"></i>Carrito
                            <span id="contadorCarrito" class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                                <?= $_SESSION['carrito_items'] ?? 0 ?>
                            </span>
                        </a>
                    </li>

                    <?php if (isset($_SESSION['user'])): ?>
                        <!-- Usuario logueado -->
                        <div class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-circle me-2"></i><?= htmlspecialchars($_SESSION['user']['nombre1']) ?>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" style="margin: 0;">
                                <li>
                                    <a class="dropdown-item nav-link text-white" href="/app03_dgcm/tienda/mi-perfil">
                                        <i class="ms-lg-0 ms-2 bi bi-person me-2"></i>Mi Perfil
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item nav-link text-white" href="/app03_dgcm/tienda/mis-pedidos">
                                        <i class="ms-lg-0 ms-2 bi bi-bag me-2"></i>Mis Pedidos
                                    </a>
                                </li>
                                <?php if ($_SESSION['user']['rol'] === 'administrador'): ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item nav-link text-white" href="/app03_dgcm/admin">
                                            <i class="ms-lg-0 ms-2 bi bi-gear me-2"></i>Panel Admin
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <?php if ($_SESSION['user']['rol'] === 'empleado'): ?>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                    <li>
                                        <a class="dropdown-item nav-link text-white" href="/app03_dgcm/empleado">
                                            <i class="ms-lg-0 ms-2 bi bi-briefcase me-2"></i>Panel Empleado
                                        </a>
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item nav-link text-white" href="/app03_dgcm/logout">
                                        <i class="ms-lg-0 ms-2 bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </div>
                    <?php else: ?>
                        <!-- Usuario no logueado -->
                        <li class="nav-item">
                            <a class="nav-link" href="/app03_dgcm/login">
                                <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>

                <?php if (!isset($_SESSION['user'])): ?>
                    <!-- Botón de registro solo si no está logueado -->
                    <div class="col-lg-1 d-grid mb-lg-0 mb-2">
                        <a href="/app03_dgcm/registro" class="btn btn-success">
                            <i class="bi bi-person-plus"></i> Registro
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <!-- Barra de progreso -->
    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-success" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <!-- Contenido principal -->
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh;">
        <?= $contenido; ?>
    </div>

    <!-- Footer simple -->
    <div class="container-fluid bg-dark text-light py-3">
        <div class="row justify-content-center text-center">
            <div class="col-md-4">
                <h6><i class="bi bi-telephone me-2"></i>+502 1234-5678</h6>
            </div>
            <div class="col-md-4">
                <h6><i class="bi bi-envelope me-2"></i>info@tiendacelulares.com</h6>
            </div>
            <div class="col-md-4">
                <h6>
                    <a href="#" class="text-light me-2"><i class="bi bi-facebook"></i></a>
                    <a href="#" class="text-light me-2"><i class="bi bi-instagram"></i></a>
                    <a href="#" class="text-light"><i class="bi bi-whatsapp"></i></a>
                </h6>
            </div>
        </div>
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                    <i class="bi bi-shop me-1"></i>
                    Tienda de Celulares - Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>

    <script src="<?= asset('build/js/tienda/layout.js') ?>"></script>
</body>

</html>