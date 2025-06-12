<?php
// ARCHIVO: views/auth/logout/index.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();

// Guardar información del usuario para mostrar mensaje de despedida
$usuario_nombre = $_SESSION['user']['nombre1'] ?? 'Usuario';
$usuario_rol = $_SESSION['user']['rol'] ?? 'usuario';

// Destruir la sesión
$_SESSION = array();
if (ini_get("session.use_cookies")) {
    $params = session_get_cookie_params();
    setcookie(
        session_name(),
        '',
        time() - 42000,
        $params["path"],
        $params["domain"],
        $params["secure"],
        $params["httponly"]
    );
}
session_destroy();
?>
<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="<?= asset('build/js/app.js') ?>"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>Sesión Cerrada - Sistema de Celulares</title>

    <style>
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
        }

        .logout-container {
            backdrop-filter: blur(10px);
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            border: 1px solid rgba(255, 255, 255, 0.2);
        }

        .success-animation {
            animation: successPulse 2s ease-in-out infinite;
        }

        @keyframes successPulse {

            0%,
            100% {
                transform: scale(1);
            }

            50% {
                transform: scale(1.05);
            }
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="row justify-content-center align-items-center min-vh-100">
            <div class="col-lg-6 col-md-8">
                <div class="logout-container shadow-lg text-center p-5">
                    <div class="success-animation mb-4">
                        <i class="bi bi-check-circle-fill text-success" style="font-size: 4rem;"></i>
                    </div>

                    <h2 class="fw-bold text-success mb-3">¡Sesión Cerrada Exitosamente!</h2>

                    <p class="text-muted mb-4">
                        Gracias por usar el sistema, <strong><?= htmlspecialchars($usuario_nombre) ?></strong>
                        <br>
                        <small>Rol: <?= ucfirst($usuario_rol) ?></small>
                    </p>

                    <!-- Información de Seguridad -->
                    <div class="alert alert-info mb-4">
                        <i class="bi bi-info-circle me-2"></i>
                        <strong>Por seguridad:</strong> Su sesión ha sido cerrada completamente.
                        Cierre el navegador si está en un equipo compartido.
                    </div>

                    <!-- Opciones de Navegación -->
                    <div class="row g-3">
                        <div class="col-md-6">
                            <a href="/app03_dgcm/login" class="btn btn-primary w-100">
                                <i class="bi bi-box-arrow-in-right me-2"></i>
                                Iniciar Sesión Nuevamente
                            </a>
                        </div>
                        <div class="col-md-6">
                            <a href="/app03_dgcm/tienda" class="btn btn-outline-primary w-100">
                                <i class="bi bi-shop me-2"></i>
                                Ir a la Tienda
                            </a>
                        </div>
                    </div>

                    <hr class="my-4">

                    <!-- Información Adicional -->
                    <div class="row text-center">
                        <div class="col-md-4">
                            <i class="bi bi-clock text-muted"></i>
                            <p class="small text-muted mb-0">Horario:</p>
                            <p class="small">Lun-Vie 8:00-18:00</p>
                        </div>
                        <div class="col-md-4">
                            <i class="bi bi-telephone text-muted"></i>
                            <p class="small text-muted mb-0">Teléfono:</p>
                            <p class="small">+502 1234-5678</p>
                        </div>
                        <div class="col-md-4">
                            <i class="bi bi-envelope text-muted"></i>
                            <p class="small text-muted mb-0">Email:</p>
                            <p class="small">info@tiendacelulares.com</p>
                        </div>
                    </div>

                    <!-- Auto-redirect -->
                    <div class="mt-4">
                        <small class="text-muted">
                            Será redirigido automáticamente en <span id="countdown">10</span> segundos...
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="position-fixed bottom-0 w-100 text-center py-2">
        <small class="text-white-50">
            <i class="bi bi-shield-check me-1"></i>
            Sistema de Celulares - Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
        </small>
    </footer>

    <script>
        // Auto-redirect después de 10 segundos
        let countdown = 10;
        const countdownElement = document.getElementById('countdown');

        const timer = setInterval(() => {
            countdown--;
            countdownElement.textContent = countdown;

            if (countdown <= 0) {
                clearInterval(timer);
                window.location.href = '/app03_dgcm/login';
            }
        }, 1000);

        // Limpiar localStorage y sessionStorage por seguridad
        localStorage.clear();
        sessionStorage.clear();

        // Mostrar notificación de éxito
        setTimeout(() => {
            if (typeof Swal !== 'undefined') {
                Swal.fire({
                    title: '¡Hasta pronto!',
                    text: 'Su sesión se cerró de forma segura',
                    icon: 'success',
                    timer: 3000,
                    showConfirmButton: false,
                    toast: true,
                    position: 'top-end'
                });
            }
        }, 500);
    </script>
</body>

</html>