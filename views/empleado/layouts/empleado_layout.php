<?php
// ARCHIVO: views/empleado/layouts/empleado_layout.php
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
    <title><?= htmlspecialchars($title ?? 'Panel Empleado') ?></title>
</head>

<body>
    <!-- Navbar Empleado -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/app03_dgcm/empleado">
                <img src="<?= asset('images/cit.png') ?>" width="35" class="me-2" alt="Logo">
                <span>Panel Empleado</span>
            </a>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarEmpleado"
                aria-controls="navbarEmpleado" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarEmpleado">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/app03_dgcm/empleado">
                            <i class="bi bi-speedometer2 me-1"></i>Dashboard
                        </a>
                    </li>

                    <!-- Módulo Ventas -->
                    <li class="nav-item">
                        <a class="nav-link" href="/app03_dgcm/empleado/ventas">
                            <i class="bi bi-cash-coin me-1"></i>Procesar Ventas
                        </a>
                    </li>

                    <!-- Módulo Reparaciones -->
                    <li class="nav-item">
                        <a class="nav-link" href="/app03_dgcm/empleado/reparaciones">
                            <i class="bi bi-tools me-1"></i>Reparaciones
                        </a>
                    </li>

                    <!-- Consultas (Solo lectura) -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-search me-1"></i>Consultas
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/empleado/celulares">
                                    <i class="bi bi-phone me-2"></i>Inventario Celulares
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/empleado/clientes">
                                    <i class="bi bi-people me-2"></i>Consultar Clientes
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user']) && in_array($_SESSION['user']['rol'], ['empleado', 'administrador'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown"
                                role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <i class="bi bi-person-circle me-1"></i>
                                <?= htmlspecialchars($_SESSION['user']['nombre1'] ?? 'Empleado') ?>
                                <span class="badge bg-warning text-dark ms-1">
                                    <?= ucfirst($_SESSION['user']['rol']) ?>
                                </span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end dropdown-menu-dark">
                                <li>
                                    <a class="dropdown-item" href="/app03_dgcm/empleado/perfil">
                                        <i class="bi bi-person-gear me-1"></i>Mi Perfil
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <?php if ($_SESSION['user']['rol'] === 'administrador'): ?>
                                    <li>
                                        <a class="dropdown-item" href="/app03_dgcm/">
                                            <i class="bi bi-shield-fill me-1"></i>Panel Admin
                                        </a>
                                    </li>
                                    <li>
                                        <hr class="dropdown-divider">
                                    </li>
                                <?php endif; ?>
                                <li>
                                    <a class="dropdown-item text-danger" href="/app03_dgcm/logout">
                                        <i class="bi bi-box-arrow-right me-1"></i>Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link" href="/app03_dgcm/login">
                                <i class="bi bi-box-arrow-in-right me-1"></i>Iniciar Sesión
                            </a>
                        </li>
                    <?php endif; ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Barra de progreso fija -->
    <div class="progress fixed-bottom" style="height: 6px;">
        <div id="bar" class="progress-bar progress-bar-animated bg-warning"
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
            <i class="bi bi-person-workspace me-1"></i>
            Panel Empleado - Comando de Informática y Tecnología, <?= date('Y') ?>&copy;
        </small>
    </footer>
</body>

</html>