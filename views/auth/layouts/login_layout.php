<?php
// ARCHIVO: views/auth/layouts/login_layout.php
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= asset('build/js/app.js') ?>"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title><?= htmlspecialchars($title ?? 'Iniciar Sesión') ?></title>

    <!-- Estilos adicionales para login -->
    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .login-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
            border-radius: 15px;
        }

        .brand-section {
            background: rgba(255, 255, 255, 0.05);
            border-radius: 15px 0 0 15px;
        }

        .login-form {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 0 15px 15px 0;
        }

        .floating-elements {
            position: absolute;
            width: 100%;
            height: 100%;
            overflow: hidden;
            z-index: -1;
        }

        .floating-elements::before,
        .floating-elements::after {
            content: '';
            position: absolute;
            width: 200px;
            height: 200px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
            animation: float 6s ease-in-out infinite;
        }

        .floating-elements::before {
            top: 10%;
            left: 10%;
            animation-delay: 0s;
        }

        .floating-elements::after {
            bottom: 10%;
            right: 10%;
            animation-delay: 3s;
        }

        @keyframes float {

            0%,
            100% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-20px);
            }
        }
    </style>
</head>

<body>
    <!-- Elementos flotantes -->
    <div class="floating-elements"></div>

    <!-- Navbar minimalista -->
    <nav class="navbar navbar-expand-lg navbar-dark bg-transparent position-fixed w-100" style="z-index: 1000;">
        <div class="container">
            <a class="navbar-brand d-flex align-items-center" href="/app03_dgcm/">
                <img src="<?= asset('images/cit.png') ?>" width="35" class="me-2" alt="Logo">
                <span class="fw-bold">Sistema de Celulares</span>
            </a>

            <div class="navbar-nav ms-auto">
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-white" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-info-circle me-1"></i>Información
                    </a>
                    <ul class="dropdown-menu dropdown-menu-end">
                        <li>
                            <span class="dropdown-item-text">
                                <small class="text-muted">¿Necesita acceso?</small><br>
                                <strong>Contacte al administrador</strong>
                            </span>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="#" onclick="mostrarAyuda()">
                                <i class="bi bi-question-circle me-2"></i>Ayuda
                            </a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </nav>

    <!-- Contenido principal -->
    <div class="container-fluid">
        <?= $contenido; ?>
    </div>

    <!-- Footer -->
    <footer class="position-fixed bottom-0 w-100 text-center py-2">
        <small class="text-white-50">
            <i class="bi bi-shield-lock me-1"></i>
            Sistema Seguro - Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
        </small>
    </footer>

    <script>
        function mostrarAyuda() {
            Swal.fire({
                title: 'Ayuda del Sistema',
                html: `
                    <div class="text-start">
                        <p><strong>Para obtener acceso al sistema:</strong></p>
                        <ul>
                            <li>Contacte al administrador del sistema</li>
                            <li>Proporcione sus datos personales</li>
                            <li>Especifique el tipo de acceso requerido</li>
                        </ul>
                        <hr>
                        <p><strong>Contacto:</strong></p>
                        <p>📧 admin@tiendacelulares.com<br>
                        📞 +502 1234-5678</p>
                    </div>
                `,
                icon: 'info',
                confirmButtonText: 'Entendido',
                confirmButtonColor: '#007bff'
            });
        }
    </script>
</body>

</html>