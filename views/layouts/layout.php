<?php
// C:\docker\app03_dgcm\views\layouts\layout.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= asset('build/js/app.js') ?>"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title><?= isset($title) ? htmlspecialchars($title) : 'DemoApp' ?></title>
</head>

<body>
    <!-- Navbar Administrador actualizado -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">
            <a class="navbar-brand d-flex align-items-center" href="/app03_dgcm/">
                <img src="<?= asset('images/cit.png') ?>" width="35" class="me-2" alt="cit">
                <span>Aplicaciones</span>
            </a>
            <button class="navbar-toggler" type="button"
                data-bs-toggle="collapse" data-bs-target="#navbarAdmin"
                aria-controls="navbarAdmin" aria-expanded="false"
                aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse" id="navbarAdmin">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="/app03_dgcm">
                            <i class="bi bi-house-fill me-1"></i>Inicio
                        </a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-gear me-1"></i>Opciones
                        </a>
                        <ul class="dropdown-menu dropdown-menu-dark">
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/registro">
                                    <i class="bi bi-people-fill me-2"></i>Gestionar Usuarios
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/roles">
                                    <i class="bi bi-award-fill me-2"></i>Gestionar Roles
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/permisos">
                                    <i class="bi bi-shield-check me-2"></i>Asignar Permisos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/aplicaciones">
                                    <i class="bi bi-grid-3x3-gap-fill me-2"></i>Aplicaciones
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>

                <ul class="navbar-nav">
                    <?php if (isset($_SESSION['user'])): ?>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center text-white"
                                href="#" data-bs-toggle="dropdown">
                                <i class="bi bi-person-check-fill me-1 text-success"></i>
                                <span class="me-2"><?= htmlspecialchars($_SESSION['user']['correo']) ?></span>
                                <span class="badge bg-danger rounded-pill">Administrador</span>
                            </a>
                            <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                                <li class="dropdown-header small text-muted">
                                    Conectado como:<br>
                                    <strong><?= htmlspecialchars($_SESSION['user']['correo']) ?></strong>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/app03_dgcm/">
                                        <i class="bi bi-speedometer2 me-2"></i>Mi Dashboard
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/app03_dgcm/registro">
                                        <i class="bi bi-people-fill me-2"></i>Gestionar Usuarios
                                    </a>
                                </li>
                                <li>
                                    <a class="dropdown-item" href="/app03_dgcm/roles">
                                        <i class="bi bi-award-fill me-2"></i>Gestionar Roles
                                    </a>
                                </li>
                                <li>
                                    <hr class="dropdown-divider">
                                </li>
                                <li>
                                    <a class="dropdown-item text-danger" href="/app03_dgcm/logout">
                                        <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                    </a>
                                </li>
                            </ul>
                        </li>
                    <?php else: ?>
                        <li class="nav-item">
                            <a class="nav-link text-white" href="/app03_dgcm/login">
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
        <div id="bar"
            class="progress-bar progress-bar-animated bg-danger"
            role="progressbar" aria-valuemin="0" aria-valuemax="100">
        </div>
    </div>

    <!-- Contenido principal -->
    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh;">
        <?= $contenido; ?>
    </div>

    <!-- Footer -->
    <div class="container-fluid">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight:bold;">
                    Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>
</body>

</html>