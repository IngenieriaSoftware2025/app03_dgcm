<?php
// ARCHIVO: views/admin/permisos/index.php
?>
<!-- SECCIÓN DEL FORMULARIO -->
<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-shield-lock me-2"></i>
                    <span id="tituloFormulario">Gestión de Permisos</span>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Panel de Administrador - Asignación de Roles a Usuarios!</h5>
                    <h4 class="text-center mb-2 text-primary">Control de Acceso del Sistema</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormPermisos">
                        <input type="hidden" id="id_usuario_rol" name="id_usuario_rol">

                        <!-- Selección de Usuario -->
                        <div class="row mb-4 justify-content-center">
                            <div class="col-lg-6">
                                <label for="id_usuario" class="form-label">
                                    <i class="bi bi-person me-1"></i>Usuario
                                </label>
                                <select class="form-select" id="id_usuario" name="id_usuario" required>
                                    <option value="">-- Selecciona un usuario --</option>
                                    <!-- Se carga dinámicamente -->
                                </select>
                                <small class="text-muted">Solo usuarios activos del sistema</small>
                            </div>

                            <div class="col-lg-6">
                                <label for="id_rol" class="form-label">
                                    <i class="bi bi-shield me-1"></i>Rol
                                </label>
                                <select class="form-select" id="id_rol" name="id_rol" required>
                                    <option value="">-- Selecciona un rol --</option>
                                    <!-- Se carga dinámicamente -->
                                </select>
                                <small class="text-muted">Roles disponibles en el sistema</small>
                            </div>
                        </div>

                        <!-- Información del Usuario Seleccionado -->
                        <div class="row mb-4 d-none" id="infoUsuario">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <h6><i class="bi bi-info-circle me-2"></i>Información del Usuario</h6>
                                    <div class="row">
                                        <div class="col-md-6">
                                            <p><strong>Nombre:</strong> <span id="usuarioNombre"></span></p>
                                            <p><strong>Correo:</strong> <span id="usuarioCorreo"></span></p>
                                        </div>
                                        <div class="col-md-6">
                                            <p><strong>Rol Actual:</strong> <span id="rolActual" class="badge bg-secondary"></span></p>
                                            <p><strong>Estado:</strong> <span id="usuarioEstado"></span></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Descripción de la Asignación -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-12">
                                <label for="descripcion" class="form-label">
                                    <i class="bi bi-card-text me-1"></i>Descripción de la Asignación
                                </label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                    placeholder="Explica el motivo de esta asignación de rol..."></textarea>
                            </div>
                        </div>

                        <!-- Estado de la Asignación -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="situacion" class="form-label">
                                    <i class="bi bi-toggle-on me-1"></i>Estado de la Asignación
                                </label>
                                <select class="form-select" id="situacion" name="situacion">
                                    <option value="1">Activa</option>
                                    <option value="0">Inactiva</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- BOTONES DEL FORMULARIO -->
                <div class="row justify-content-between mt-4 px-5">
                    <div class="col-auto">
                        <button class="btn btn-success" type="submit" form="FormPermisos" id="BtnGuardar">
                            <i class="bi bi-shield-plus me-1"></i> Asignar Rol
                        </button>
                        <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                            <i class="bi bi-pen me-1"></i> Modificar Asignación
                        </button>
                        <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiar">
                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                        </button>
                    </div>

                    <div class="col-auto">
                        <button type="button" id="BtnVerPermisos" class="btn btn-info">
                            <i class="bi bi-people-fill me-1"></i> Ver Asignaciones
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SECCIÓN DE LA TABLA -->
<div id="seccionTabla" class="row justify-content-center p-3 d-none">
    <div class="col-lg-12">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #17a2b8;">
            <div class="card-header bg-info text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-shield-fill me-2"></i>
                    Asignaciones de Roles
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <button type="button" id="BtnCrearPermiso" class="btn btn-success">
                            <i class="bi bi-shield-plus me-1"></i> Nueva Asignación
                        </button>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-danger" id="BtnAdmins">
                                <i class="bi bi-shield-fill me-1"></i> Administradores
                            </button>
                            <button type="button" class="btn btn-outline-warning" id="BtnEmpleados">
                                <i class="bi bi-person-badge me-1"></i> Empleados
                            </button>
                            <button type="button" class="btn btn-outline-info" id="BtnClientes">
                                <i class="bi bi-person me-1"></i> Clientes
                            </button>
                            <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TablePermisos">
                        <!-- DataTable se genera automáticamente -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/admin/permisos.js') ?>"></script>