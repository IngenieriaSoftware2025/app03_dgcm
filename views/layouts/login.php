<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="build/js/app.js"></script>
    <link rel="shortcut icon" href="<?= asset('images/cit.png') ?>" type="image/x-icon">
    <link rel="stylesheet" href="<?= asset('build/styles.css') ?>">
    <title>Iniciar Sesión - DemoApp</title>
</head>

<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container-fluid">

            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarToggler" aria-controls="navbarToggler" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>

            <a class="navbar-brand" href="/app03_carbajal_clase/">
                <img src="<?= asset('./images/cit.png') ?>" width="35px" alt="cit">
                Sistema de Celulares
            </a>

            <div class="collapse navbar-collapse" id="navbarToggler">
                <!-- Menú izquierdo - Solo inicio -->
                <ul class="navbar-nav me-auto mb-2 mb-lg-0" style="margin: 0;">
                    <li class="nav-item">
                        <a class="nav-link" aria-current="page" href="/app03_carbajal_clase">
                            <i class="bi bi-house-fill me-2"></i>Inicio
                        </a>
                    </li>
                </ul>

                <!-- Menú derecho - Solo información de acceso -->
                <div class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-info-circle me-1"></i>Información
                    </a>
                    <ul class="dropdown-menu dropdown-menu-dark dropdown-menu-end">
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

    <div class="progress fixed-bottom" style="height: 6px;">
        <div class="progress-bar progress-bar-animated bg-primary" id="bar" role="progressbar" aria-valuemin="0" aria-valuemax="100"></div>
    </div>

    <div class="container-fluid pt-5 mb-4" style="min-height: 85vh">
        <?php echo $contenido; ?>
    </div>

    <div class="container-fluid">
        <div class="row justify-content-center text-center">
            <div class="col-12">
                <p style="font-size:xx-small; font-weight: bold;">
                    <i class="bi bi-shield-lock me-1"></i>
                    Sistema Seguro - Comando de Informática y Tecnología, <?= date('Y') ?> &copy;
                </p>
            </div>
        </div>
    </div>

    <script>
        function mostrarAyuda() {
            alert('Para obtener acceso al sistema, contacte al administrador del sistema.\n\nTeléfono: [Número de soporte]\nEmail: admin@empresa.com');
        }
    </script>
</body>

</html>