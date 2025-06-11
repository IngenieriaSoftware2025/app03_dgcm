<!-- SECCIÓN DEL FORMULARIO (Vista 1) -->
<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-shield-lock me-2"></i>
                    <span id="tituloFormulario">Asignar Rol a Usuario</span>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Gestión de Asignación de Roles a Usuarios!</h5>
                    <h4 class="text-center mb-2 text-primary">Asignación Usuario-Rol</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormPermisos">
                        <input type="hidden" id="id_usuario_rol" name="id_usuario_rol">

                        <!-- USUARIO (SELECT) -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="id_usuario" class="form-label">Usuario</label>
                                <select class="form-select" id="id_usuario" name="id_usuario" required>
                                    <option value="">-- Selecciona un usuario --</option>
                                    <!-- Se carga dinámicamente -->
                                </select>
                            </div>

                            <!-- ROL (SELECT) -->
                            <div class="col-lg-6">
                                <label for="id_rol" class="form-label">Rol</label>
                                <select class="form-select" id="id_rol" name="id_rol" required>
                                    <option value="">-- Selecciona un rol --</option>
                                    <!-- Se carga dinámicamente -->
                                </select>
                            </div>
                        </div>

                        <!-- DESCRIPCIÓN -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                    placeholder="Describe la asignación de este rol al usuario..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- BOTONES DEL FORMULARIO - MODIFICADOS IGUAL QUE USUARIOS -->
                <div class="row justify-content-between mt-4 px-5">
                    <!-- Botones de acción del formulario -->
                    <div class="col-auto">
                        <button class="btn btn-success" type="submit" form="FormPermisos" id="BtnGuardar">
                            <i class="bi bi-shield-plus me-1"></i> Guardar
                        </button>
                        <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                            <i class="bi bi-pen me-1"></i> Modificar
                        </button>
                        <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiar">
                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                        </button>
                    </div>

                    <!-- NUEVO BOTÓN PARA VER PERMISOS -->
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

<!-- SECCIÓN DE LA TABLA (Vista 2) - OCULTA POR DEFECTO -->
<div id="seccionTabla" class="row justify-content-center p-3 d-none">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #17a2b8;">
            <div class="card-header bg-info text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-shield-fill me-2"></i>
                    Permisos Registrados
                </h4>
            </div>
            <div class="card-body p-3">

                <!-- BOTONES DE LA TABLA -->
                <div class="row justify-content-between mb-3">
                    <!-- BOTÓN PARA CREAR NUEVO -->
                    <div class="col-auto">
                        <button type="button" id="BtnCrearPermiso" class="btn btn-success">
                            <i class="bi bi-shield-plus me-1"></i> Crear Nuevo Permiso
                        </button>
                    </div>

                    <!-- BOTÓN PARA ACTUALIZAR -->
                    <div class="col-auto">
                        <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Lista
                        </button>
                    </div>
                </div>

                <!-- TABLA EXISTENTE -->
                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TablePermisos">
                        <!-- DataTable se genera automáticamente -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/permisos/permisos.js') ?>"></script>