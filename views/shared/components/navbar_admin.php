<?php
// ARCHIVO: views/shared/components/navbar_admin.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow">
    <div class="container-fluid">
        <a class="navbar-brand d-flex align-items-center" href="/app03_dgcm/">
            <img src="<?= asset('images/cit.png') ?>" width="35" class="me-2" alt="Logo">
            <span class="fw-bold">Panel Administrador</span>
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarAdmin"
            aria-controls="navbarAdmin" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarAdmin">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Dashboard -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'dashboard' ? 'active' : '' ?>" href="/app03_dgcm/">
                        <i class="bi bi-speedometer2 me-1"></i>Dashboard
                    </a>
                </li>

                <!-- Gestión de Sistema -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= in_array($current_page, ['usuarios', 'roles', 'permisos']) ? 'active' : '' ?>"
                        href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-gear me-1"></i>Sistema
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li>
                            <a class="dropdown-item <?= $current_page === 'usuarios' ? 'active' : '' ?>"
                                href="/app03_dgcm/admin/usuarios">
                                <i class="bi bi-people-fill me-2"></i>Gestionar Usuarios
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page === 'roles' ? 'active' : '' ?>"
                                href="/app03_dgcm/admin/roles">
                                <i class="bi bi-award-fill me-2"></i>Gestionar Roles
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page === 'permisos' ? 'active' : '' ?>"
                                href="/app03_dgcm/admin/permisos">
                                <i class="bi bi-shield-check me-2"></i>Asignar Permisos
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/admin/configuracion">
                                <i class="bi bi-sliders me-2"></i>Configuración Sistema
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Inventario y Productos -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= in_array($current_page, ['marcas', 'celulares', 'inventario']) ? 'active' : '' ?>"
                        href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-phone me-1"></i>Inventario
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li>
                            <a class="dropdown-item <?= $current_page === 'marcas' ? 'active' : '' ?>"
                                href="/app03_dgcm/admin/marcas">
                                <i class="bi bi-tags-fill me-2"></i>Gestionar Marcas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page === 'celulares' ? 'active' : '' ?>"
                                href="/app03_dgcm/admin/celulares">
                                <i class="bi bi-phone me-2"></i>Gestionar Celulares
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/admin/inventario/reportes">
                                <i class="bi bi-clipboard-data me-2"></i>Reportes de Inventario
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Ventas y Servicios -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= in_array($current_page, ['ventas', 'reparaciones', 'servicios']) ? 'active' : '' ?>"
                        href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-cash-coin me-1"></i>Ventas & Servicios
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li>
                            <a class="dropdown-item <?= $current_page === 'ventas' ? 'active' : '' ?>"
                                href="/app03_dgcm/admin/ventas">
                                <i class="bi bi-receipt me-2"></i>Control de Ventas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page === 'reparaciones' ? 'active' : '' ?>"
                                href="/app03_dgcm/admin/reparaciones">
                                <i class="bi bi-tools me-2"></i>Control Reparaciones
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item <?= $current_page === 'servicios' ? 'active' : '' ?>"
                                href="/app03_dgcm/admin/servicios">
                                <i class="bi bi-gear-wide-connected me-2"></i>Tipos de Servicio
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Clientes -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'clientes' ? 'active' : '' ?>"
                        href="/app03_dgcm/admin/clientes">
                        <i class="bi bi-people me-1"></i>Clientes
                    </a>
                </li>

                <!-- Reportes y Estadísticas -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= in_array($current_page, ['estadisticas', 'reportes']) ? 'active' : '' ?>"
                        href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-graph-up me-1"></i>Reportes
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark">
                        <li>
                            <a class="dropdown-item <?= $current_page === 'estadisticas' ? 'active' : '' ?>"
                                href="/app03_dgcm/admin/estadisticas">
                                <i class="bi bi-bar-chart me-2"></i>Dashboard Estadísticas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/admin/reportes/ventas">
                                <i class="bi bi-file-earmark-bar-graph me-2"></i>Reportes de Ventas
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/admin/reportes/inventario">
                                <i class="bi bi-boxes me-2"></i>Reportes de Inventario
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/admin/reportes/clientes">
                                <i class="bi bi-person-lines-fill me-2"></i>Reportes de Clientes
                            </a>
                        </li>
                    </ul>
                </li>
            </ul>

            <!-- Menú de Usuario -->
            <ul class="navbar-nav">
                <!-- Notificaciones -->
                <li class="nav-item dropdown">
                    <a class="nav-link position-relative" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-bell"></i>
                        <span id="contadorNotificaciones" class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                            <?= $notificaciones_count ?? 0 ?>
                        </span>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end" style="width: 350px;">
                        <li class="dropdown-header">
                            <i class="bi bi-bell me-2"></i>Notificaciones
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <div class="dropdown-item-text">
                                <div id="listaNotificaciones">
                                    <!-- Se cargan dinámicamente -->
                                    <small class="text-muted">No hay notificaciones nuevas</small>
                                </div>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item text-center" href="/app03_dgcm/admin/notificaciones">
                                <small>Ver todas las notificaciones</small>
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Perfil de Usuario -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle d-flex align-items-center text-white"
                        href="#" data-bs-toggle="dropdown">
                        <div class="me-2">
                            <?php if (!empty($_SESSION['user']['fotografia'])): ?>
                                <img src="<?= $_SESSION['user']['fotografia'] ?>"
                                    class="rounded-circle" width="32" height="32" alt="Foto">
                            <?php else: ?>
                                <i class="bi bi-person-circle fs-4"></i>
                            <?php endif; ?>
                        </div>
                        <div class="d-flex flex-column align-items-start">
                            <span class="fw-bold"><?= htmlspecialchars($_SESSION['user']['nombre1'] ?? 'Admin') ?></span>
                            <small class="badge bg-danger">Administrador</small>
                        </div>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
                        <li class="dropdown-header">
                            <div class="text-center">
                                <strong><?= htmlspecialchars($_SESSION['user']['nombre1'] . ' ' . $_SESSION['user']['apellido1']) ?></strong><br>
                                <small class="text-muted"><?= htmlspecialchars($_SESSION['user']['correo']) ?></small>
                            </div>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/admin/mi-perfil">
                                <i class="bi bi-person-gear me-2"></i>Mi Perfil
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/admin/configuracion">
                                <i class="bi bi-sliders me-2"></i>Configuración
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/empleado">
                                <i class="bi bi-eye me-2"></i>Ver como Empleado
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/tienda">
                                <i class="bi bi-shop me-2"></i>Ver Tienda
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
            </ul>
        </div>
    </div>
</nav>