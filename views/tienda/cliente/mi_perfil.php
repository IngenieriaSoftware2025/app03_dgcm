<?php
// ARCHIVO: views/tienda/cliente/mi_perfil.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/app03_dgcm/tienda">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/app03_dgcm/tienda/dashboard">Mi Panel</a></li>
            <li class="breadcrumb-item active">Mi Perfil</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar de Navegación -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h6 class="mb-0"><i class="bi bi-person-gear me-2"></i>Mi Cuenta</h6>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#perfil" class="list-group-item list-group-item-action active" data-section="perfil">
                        <i class="bi bi-person me-2"></i>Información Personal
                    </a>
                    <a href="#configuracion" class="list-group-item list-group-item-action" data-section="configuracion">
                        <i class="bi bi-gear me-2"></i>Configuración
                    </a>
                    <a href="#direcciones" class="list-group-item list-group-item-action" data-section="direcciones">
                        <i class="bi bi-geo-alt me-2"></i>Mis Direcciones
                    </a>
                    <a href="#seguridad" class="list-group-item list-group-item-action" data-section="seguridad">
                        <i class="bi bi-shield-lock me-2"></i>Seguridad
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="col-md-9">
            <!-- Sección: Información Personal -->
            <div id="seccion-perfil" class="content-section">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>Información Personal</h5>
                    </div>
                    <div class="card-body">
                        <form id="FormPerfil">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombre1" class="form-label">Primer Nombre</label>
                                    <input type="text" class="form-control" id="nombre1" name="nombre1"
                                        value="<?= htmlspecialchars($_SESSION['user']['nombre1'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="nombre2" class="form-label">Segundo Nombre</label>
                                    <input type="text" class="form-control" id="nombre2" name="nombre2"
                                        value="<?= htmlspecialchars($_SESSION['user']['nombre2'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="apellido1" class="form-label">Primer Apellido</label>
                                    <input type="text" class="form-control" id="apellido1" name="apellido1"
                                        value="<?= htmlspecialchars($_SESSION['user']['apellido1'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="apellido2" class="form-label">Segundo Apellido</label>
                                    <input type="text" class="form-control" id="apellido2" name="apellido2"
                                        value="<?= htmlspecialchars($_SESSION['user']['apellido2'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono"
                                        value="<?= htmlspecialchars($_SESSION['user']['telefono'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="correo" name="correo"
                                        value="<?= htmlspecialchars($_SESSION['user']['correo'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="dpi" class="form-label">DPI</label>
                                    <input type="text" class="form-control" id="dpi" name="dpi"
                                        value="<?= htmlspecialchars($_SESSION['user']['dpi'] ?? '') ?>">
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Guardar Cambios
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sección: Configuración -->
            <div id="seccion-configuracion" class="content-section d-none">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Configuración de Cuenta</h5>
                    </div>
                    <div class="card-body">
                        <form id="FormConfiguracion">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="idioma" class="form-label">Idioma</label>
                                    <select class="form-select" id="idioma" name="idioma">
                                        <option value="es">Español</option>
                                        <option value="en">English</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="moneda" class="form-label">Moneda</label>
                                    <select class="form-select" id="moneda" name="moneda">
                                        <option value="GTQ">Quetzal (GTQ)</option>
                                        <option value="USD">Dólar (USD)</option>
                                    </select>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-3">Notificaciones</h6>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notificaciones_email" name="notificaciones_email" checked>
                                        <label class="form-check-label" for="notificaciones_email">
                                            Recibir notificaciones por email
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notificaciones_sms" name="notificaciones_sms">
                                        <label class="form-check-label" for="notificaciones_sms">
                                            Recibir notificaciones por SMS
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" checked>
                                        <label class="form-check-label" for="newsletter">
                                            Suscribirse al newsletter
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold mb-3">Privacidad</h6>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="perfil_publico" name="perfil_publico">
                                        <label class="form-check-label" for="perfil_publico">
                                            Perfil público
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="mostrar_compras" name="mostrar_compras">
                                        <label class="form-check-label" for="mostrar_compras">
                                            Mostrar historial de compras
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Guardar Configuración
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sección: Direcciones -->
            <div id="seccion-direcciones" class="content-section d-none">
                <div class="card shadow-sm">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><i class="bi bi-geo-alt me-2"></i>Mis Direcciones</h5>
                        <button class="btn btn-sm btn-primary" id="btnNuevaDireccion">
                            <i class="bi bi-plus me-1"></i>Nueva Dirección
                        </button>
                    </div>
                    <div class="card-body">
                        <div id="listaDirecciones">
                            <!-- Se cargan dinámicamente -->
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección: Seguridad -->
            <div id="seccion-seguridad" class="content-section d-none">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Seguridad de la Cuenta</h5>
                    </div>
                    <div class="card-body">
                        <form id="FormSeguridad">
                            <h6 class="fw-bold mb-3">Cambiar Contraseña</h6>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="clave_actual" class="form-label">Contraseña Actual</label>
                                    <input type="password" class="form-control" id="clave_actual" name="clave_actual" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nueva_clave" class="form-label">Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="nueva_clave" name="nueva_clave" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="confirmar_nueva_clave" class="form-label">Confirmar Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="confirmar_nueva_clave" name="confirmar_nueva_clave" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-key me-1"></i>Cambiar Contraseña
                            </button>
                        </form>

                        <hr class="my-4">

                        <h6 class="fw-bold mb-3 text-danger">Zona Peligrosa</h6>
                        <p class="text-muted">Las siguientes acciones son irreversibles.</p>
                        <button class="btn btn-outline-danger" data-bs-toggle="modal" data-bs-target="#modalEliminarCuenta">
                            <i class="bi bi-trash me-1"></i>Eliminar Mi Cuenta
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Nueva Dirección -->
<div class="modal fade" id="modalNuevaDireccion" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Nueva Dirección</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="FormNuevaDireccion">
                    <div class="mb-3">
                        <label for="direccion_completa" class="form-label">Dirección Completa</label>
                        <textarea class="form-control" id="direccion_completa" name="direccion_completa" rows="3" required></textarea>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="ciudad" class="form-label">Ciudad</label>
                            <input type="text" class="form-control" id="ciudad" name="ciudad">
                        </div>
                        <div class="col-md-6">
                            <label for="codigo_postal" class="form-label">Código Postal</label>
                            <input type="text" class="form-control" id="codigo_postal" name="codigo_postal">
                        </div>
                    </div>
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" id="direccion_principal" name="direccion_principal">
                        <label class="form-check-label" for="direccion_principal">
                            Establecer como dirección principal
                        </label>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="FormNuevaDireccion" class="btn btn-primary">Guardar Dirección</button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Eliminar Cuenta -->
<div class="modal fade" id="modalEliminarCuenta" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">Eliminar Cuenta</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div class="alert alert-warning">
                    <i class="bi bi-exclamation-triangle me-2"></i>
                    <strong>¡Atención!</strong> Esta acción es irreversible.
                </div>
                <p>Al eliminar tu cuenta se perderá:</p>
                <ul>
                    <li>Historial de pedidos</li>
                    <li>Información personal</li>
                    <li>Configuraciones guardadas</li>
                </ul>
                <p>Para confirmar, escribe tu contraseña actual:</p>
                <form id="FormEliminarCuenta">
                    <input type="password" class="form-control" id="confirmar_eliminacion"
                        name="confirmar_eliminacion" placeholder="Contraseña actual" required>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="FormEliminarCuenta" class="btn btn-danger">
                    <i class="bi bi-trash me-1"></i>Eliminar Definitivamente
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/tienda/mi-perfil.js') ?>"></script>