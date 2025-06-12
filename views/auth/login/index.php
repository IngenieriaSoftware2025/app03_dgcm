<?php
// ARCHIVO: views/auth/login/index.php
?>
<div class="container">
    <div class="row justify-content-center align-items-center min-vh-100">
        <div class="col-lg-10 col-xl-8">
            <div class="login-container shadow-lg">
                <div class="row g-0">
                    <!-- Sección de Marca/Información -->
                    <div class="col-md-6 brand-section text-white d-flex align-items-center">
                        <div class="p-5 text-center w-100">
                            <img src="<?= asset('images/cit.png') ?>" width="80" class="mb-4" alt="Logo">
                            <h2 class="fw-bold mb-3">Sistema de Celulares</h2>
                            <p class="lead mb-4">Gestión integral de ventas y reparaciones</p>

                            <!-- Características del Sistema -->
                            <div class="mt-4">
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-shield-check fs-4 me-3"></i>
                                    <div class="text-start">
                                        <h6 class="mb-0">Seguro</h6>
                                        <small class="opacity-75">Protección de datos</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center mb-3">
                                    <i class="bi bi-people fs-4 me-3"></i>
                                    <div class="text-start">
                                        <h6 class="mb-0">Multi-usuario</h6>
                                        <small class="opacity-75">Roles diferenciados</small>
                                    </div>
                                </div>
                                <div class="d-flex align-items-center">
                                    <i class="bi bi-graph-up fs-4 me-3"></i>
                                    <div class="text-start">
                                        <h6 class="mb-0">Reportes</h6>
                                        <small class="opacity-75">Análisis en tiempo real</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Formulario de Login -->
                    <div class="col-md-6 login-form">
                        <div class="p-5">
                            <div class="text-center mb-4">
                                <h3 class="fw-bold text-primary">Iniciar Sesión</h3>
                                <p class="text-muted">Ingrese sus credenciales para acceder</p>
                            </div>

                            <form id="FormLogin">
                                <div class="mb-3">
                                    <label for="usuario_correo" class="form-label">
                                        <i class="bi bi-envelope me-1"></i>Correo Electrónico
                                    </label>
                                    <input type="email" class="form-control form-control-lg"
                                        id="usuario_correo" name="usuario_correo"
                                        placeholder="ejemplo@empresa.com" required>
                                </div>

                                <div class="mb-3">
                                    <label for="usuario_clave" class="form-label">
                                        <i class="bi bi-lock me-1"></i>Contraseña
                                    </label>
                                    <div class="input-group">
                                        <input type="password" class="form-control form-control-lg"
                                            id="usuario_clave" name="usuario_clave"
                                            placeholder="Ingrese su contraseña" required>
                                        <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                            <i class="bi bi-eye" id="eyeIcon"></i>
                                        </button>
                                    </div>
                                </div>

                                <div class="mb-3 form-check">
                                    <input type="checkbox" class="form-check-input" id="recordarme" name="recordarme">
                                    <label class="form-check-label" for="recordarme">
                                        Recordar mis credenciales
                                    </label>
                                </div>

                                <!-- Contenedor para alertas -->
                                <div id="alertasLogin" class="mb-3"></div>

                                <div class="d-grid">
                                    <button class="btn btn-primary btn-lg" type="submit" id="BtnLogin">
                                        <i class="bi bi-box-arrow-in-right me-2"></i>
                                        <span id="btnText">Iniciar Sesión</span>
                                        <span id="btnSpinner" class="spinner-border spinner-border-sm d-none ms-2"></span>
                                    </button>
                                </div>

                                <div class="text-center mt-4">
                                    <small class="text-muted">
                                        ¿Olvidó su contraseña?
                                        <a href="#" class="text-decoration-none" onclick="mostrarRecuperacion()">
                                            Contacte al administrador
                                        </a>
                                    </small>
                                </div>

                                <!-- Acceso rápido para demo (quitar en producción) -->
                                <div class="mt-4 p-3 bg-light rounded">
                                    <small class="text-muted d-block mb-2">Acceso de prueba:</small>
                                    <div class="row g-2">
                                        <div class="col-4">
                                            <button type="button" class="btn btn-outline-danger btn-sm w-100"
                                                onclick="loginRapido('admin')">
                                                <i class="bi bi-shield-fill me-1"></i>Admin
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn btn-outline-warning btn-sm w-100"
                                                onclick="loginRapido('empleado')">
                                                <i class="bi bi-person-badge me-1"></i>Empleado
                                            </button>
                                        </div>
                                        <div class="col-4">
                                            <button type="button" class="btn btn-outline-info btn-sm w-100"
                                                onclick="loginRapido('cliente')">
                                                <i class="bi bi-person me-1"></i>Cliente
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/auth/login.js') ?>"></script>

<script>
    function mostrarRecuperacion() {
        Swal.fire({
            title: 'Recuperar Contraseña',
            html: `
                <p>Para recuperar su contraseña, contacte al administrador del sistema con la siguiente información:</p>
                <ul class="text-start">
                    <li>Su nombre completo</li>
                    <li>Correo electrónico registrado</li>
                    <li>Número de teléfono</li>
                    <li>Departamento o área de trabajo</li>
                </ul>
                <hr>
                <p><strong>Contacto:</strong><br>
                📧 admin@tiendacelulares.com<br>
                📞 +502 1234-5678</p>
            `,
            icon: 'question',
            confirmButtonText: 'Entendido'
        });
    }

    function loginRapido(tipo) {
        const credenciales = {
            admin: {
                correo: 'admin@ejemplo.com',
                clave: 'admin123'
            },
            empleado: {
                correo: 'empleado@ejemplo.com',
                clave: 'empleado123'
            },
            cliente: {
                correo: 'cliente@ejemplo.com',
                clave: 'cliente123'
            }
        };

        document.getElementById('usuario_correo').value = credenciales[tipo].correo;
        document.getElementById('usuario_clave').value = credenciales[tipo].clave;

        // Auto-submit después de un breve delay
        setTimeout(() => {
            document.getElementById('FormLogin').dispatchEvent(new Event('submit'));
        }, 500);
    }
</script>