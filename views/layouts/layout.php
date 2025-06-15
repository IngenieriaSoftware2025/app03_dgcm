<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>Sistema de Gestión</title>
</head>

<body>
    <!-- Mobile Toggle -->
    <button class="mobile-toggle" onclick="toggleSidebar()">
        <i class="bi bi-list"></i>
    </button>

    <!-- Sidebar -->
    <nav class="sidebar" id="sidebar">
        <!-- Brand -->
        <div class="sidebar-brand">
            <img src="<?= asset('./images/cit.png') ?>" alt="CIT">
            <h5>Sistema</h5>
        </div>

        <!-- User Section -->
        <div class="user-section">
            <?php session_start(); ?>
            <?php if (isset($_SESSION['user'])): ?>
                <div class="user-dropdown" id="userDropdown">
                    <button class="user-btn dropdown-toggle" data-bs-toggle="dropdown">
                        <div class="user-avatar">
                            <?= strtoupper(substr($_SESSION['user'], 0, 1)) ?>
                        </div>
                        <span class="flex-grow-1 text-start"><?= $_SESSION['user'] ?></span>
                    </button>

                    <div class="dropdown-menu mt-2">
                        <div class="dropdown-header" style="padding: 8px 12px; font-size: 12px; color: #666; border-bottom: 1px solid #e0e0e0;">
                            Sesión Activa
                        </div>
                        <a class="dropdown-item" href="/app03_carbajal_clase/logout" style="color: #e60023; padding: 8px 12px;">
                            <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                        </a>
                    </div>
                </div>
            <?php else: ?>
                <a href="/app03_carbajal_clase/login" class="btn btn-primary w-100">
                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                </a>
            <?php endif; ?>
        </div>

        <!-- Navigation -->
        <div class="nav-items">
            <div class="nav-item">
                <a class="nav-link <?= ($pagina == 'inicio') ? 'active' : '' ?>" href="/app03_carbajal_clase" data-tooltip="Inicio">
                    <i class="bi bi-house-fill"></i>
                    <span>Inicio</span>
                </a>
            </div>

            <!-- Dropdown de Tienda -->
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="bi bi-shop"></i>
                    <span>Tienda</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/app03_carbajal_clase/celulares">Celulares</a></li>
                    <li><a class="dropdown-item" href="/app03_carbajal_clase/marcas">Marcas</a></li>
                    <li><a class="dropdown-item" href="/app03_carbajal_clase/reparaciones">Reparaciones</a></li>
                </ul>
            </div>

            <div class="nav-item">
                <a class="nav-link" href="/app03_carbajal_clase/aplicaciones" data-tooltip="Aplicaciones">
                    <i class="bi bi-app-indicator"></i>
                    <span>Aplicaciones</span>
                </a>
            </div>

            <div class="nav-item">
                <a class="nav-link" href="/app03_carbajal_clase/permisos" data-tooltip="Permisos">
                    <i class="bi bi-shield-lock"></i>
                    <span>Permisos</span>
                </a>
            </div>

            <div class="nav-item">
                <a class="nav-link" href="/app03_carbajal_clase/registro" data-tooltip="Usuarios">
                    <i class="bi bi-people"></i>
                    <span>Usuarios</span>
                </a>
            </div>

            <div class="nav-item">
                <a class="nav-link" href="/app03_carbajal_clase/clientes" data-tooltip="Clientes">
                    <i class="bi bi-person-lines-fill"></i>
                    <span>Clientes</span>
                </a>
            </div>

            <div class="nav-item">
                <a class="nav-link" href="/app03_carbajal_clase/mapa" data-tooltip="Mapa">
                    <i class="bi bi-geo-alt"></i>
                    <span>Mapa</span>
                </a>
            </div>

            <div class="nav-item">
                <a class="nav-link" href="/app03_carbajal_clase/graficas" data-tooltip="Gráficas">
                    <i class="bi bi-graph-up"></i>
                    <span>Gráficas</span>
                </a>
            </div>

            <!-- Dropdown de Configuración -->
            <div class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="#" role="button" data-bs-toggle="dropdown" data-bs-auto-close="outside" aria-expanded="false">
                    <i class="bi bi-gear"></i>
                    <span>Configuración</span>
                </a>
                <ul class="dropdown-menu">
                    <li><a class="dropdown-item" href="/app03_carbajal_clase/permiso_aplicacion">Asignar Permisos a Apps</a></li>
                    <li><a class="dropdown-item" href="/app03_carbajal_clase/asignacion_permisos">Asignar Permisos a Usuarios</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="main-content">
        <div class="content-area">
            <?php echo $contenido; ?>
        </div>
    </div>

    <!-- Progress Bar -->
    <div class="progress-bar-custom">
        <div class="progress-fill" id="progressBar"></div>
    </div>

    <script src="<?= asset('build/js/app.js') ?>"></script>

    <!-- Agrega esto AL FINAL de layout.php si app.js no carga -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.1/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            // Inicializar todos los dropdowns
            const dropdownElementList = document.querySelectorAll('[data-bs-toggle="dropdown"]');
            const dropdownList = [...dropdownElementList].map(dropdownToggleEl => new bootstrap.Dropdown(dropdownToggleEl));

            // Función para el toggle del sidebar
            window.toggleSidebar = function() {
                const sidebar = document.getElementById('sidebar');
                if (sidebar) {
                    sidebar.classList.toggle('active');
                }
            };

            // Marcar enlaces activos
            const currentPath = window.location.pathname;
            const navLinks = document.querySelectorAll('.nav-link, .dropdown-item');

            navLinks.forEach(link => {
                if (link.getAttribute('href') === currentPath) {
                    link.classList.add('active');

                    if (link.classList.contains('dropdown-item')) {
                        const dropdownToggle = link.closest('.dropdown').querySelector('.dropdown-toggle');
                        if (dropdownToggle) {
                            dropdownToggle.classList.add('active');
                        }
                    }
                }
            });
        });
    </script>
</body>

</html>