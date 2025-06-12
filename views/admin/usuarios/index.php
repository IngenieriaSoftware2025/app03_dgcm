<?php
// ARCHIVO: views/admin/usuarios/index.php
?>

<!-- SECCIÓN DEL FORMULARIO -->
<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-person-plus-fill me-2"></i>
                    <span id="tituloFormulario">Gestión de Usuarios</span>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">Panel de Administrador - Gestión de Usuarios</h5>
                    <h4 class="text-center mb-2 text-primary">Crear y Administrar Usuarios del Sistema</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormUsuarios">
                        <input type="hidden" id="id_usuario" name="id_usuario">

                        <!-- Información Personal -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold">
                                    <i class="bi bi-person me-2"></i>Información Personal
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="nombre1" class="form-label">Primer Nombre</label>
                                <input type="text" class="form-control" id="nombre1" name="nombre1"
                                    placeholder="Ej: Juan" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="nombre2" class="form-label">Segundo Nombre</label>
                                <input type="text" class="form-control" id="nombre2" name="nombre2"
                                    placeholder="Ej: Carlos">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <label for="apellido1" class="form-label">Primer Apellido</label>
                                <input type="text" class="form-control" id="apellido1" name="apellido1"
                                    placeholder="Ej: García" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="apellido2" class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" id="apellido2" name="apellido2"
                                    placeholder="Ej: López">
                            </div>
                        </div>

                        <!-- Información de Contacto -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold">
                                    <i class="bi bi-telephone me-2"></i>Información de Contacto
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="telefono" class="form-label">Teléfono (8 dígitos)</label>
                                <input type="number" class="form-control" id="telefono" name="telefono"
                                    placeholder="12345678" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="dpi" class="form-label">DPI (13 dígitos)</label>
                                <input type="number" class="form-control" id="dpi" name="dpi"
                                    placeholder="1234567890123">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo"
                                    placeholder="ejemplo@correo.com" required>
                            </div>
                        </div>

                        <!-- Configuración del Sistema -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold">
                                    <i class="bi bi-shield me-2"></i>Configuración del Sistema
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="rol" class="form-label">Rol del Usuario</label>
                                <select id="rol" name="rol" class="form-select" required>
                                    <option value="">-- Selecciona un rol --</option>
                                    <option value="cliente">Cliente</option>
                                    <option value="empleado">Empleado</option>
                                    <option value="administrador">Administrador</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="situacion" class="form-label">Estado</label>
                                <select id="situacion" name="situacion" class="form-select">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Contraseñas -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold">
                                    <i class="bi bi-key me-2"></i>Seguridad
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="usuario_clave" class="form-label">Contraseña</label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="usuario_clave" name="usuario_clave"
                                        placeholder="Contraseña segura" required>
                                    <button class="btn btn-outline-secondary" type="button" id="contraseniaBtn">
                                        <i class="bi bi-eye" id="iconOjo"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Mín. 10 caracteres, mayúscula, minúscula, número y símbolo</small>
                            </div>
                            <div class="col-lg-6">
                                <label for="confirmar_clave" class="form-label">Confirmar Contraseña</label>
                                <input type="password" class="form-control" id="confirmar_clave" name="confirmar_clave"
                                    placeholder="Confirme la contraseña" required>
                            </div>
                        </div>

                        <!-- Fotografía -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold">
                                    <i class="bi bi-camera me-2"></i>Fotografía del Usuario
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="fotografia" class="form-label">Seleccionar Imagen</label>
                                <input type="file" class="form-control" id="fotografia" name="fotografia" accept="image/*">
                                <small class="text-muted">Formatos: JPG, PNG, GIF (Máx. 5MB)</small>
                            </div>
                            <div class="col-lg-6">
                                <!-- CONTENEDOR DE VISTA PREVIA -->
                                <div id="contenedorVistaPrevia" class="d-none">
                                    <label class="form-label">Vista Previa:</label>
                                    <div class="text-center p-3 border rounded" style="background-color: #f8f9fa;">
                                        <img id="vistaPrevia" src="" alt="Vista previa de la imagen"
                                            class="img-fluid rounded shadow"
                                            style="max-width: 150px; max-height: 150px; object-fit: cover;">
                                        <br>
                                        <small class="text-muted mt-2 d-block" id="infoArchivo"></small>
                                        <button type="button" class="btn btn-sm btn-outline-danger mt-2" id="btnEliminarImagen">
                                            <i class="bi bi-trash me-1"></i> Eliminar
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- BOTONES DEL FORMULARIO -->
                <div class="row justify-content-between mt-4 px-5">
                    <div class="col-auto">
                        <button class="btn btn-success" type="submit" form="FormUsuarios" id="BtnGuardar">
                            <i class="bi bi-floppy me-1"></i> Guardar
                        </button>
                        <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                            <i class="bi bi-pen me-1"></i> Modificar
                        </button>
                        <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiar">
                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                        </button>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="BtnVerUsuarios" class="btn btn-info">
                            <i class="bi bi-people me-1"></i> Ver Usuarios
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
                    <i class="bi bi-people me-2"></i>
                    Usuarios del Sistema
                </h4>
            </div>
            <div class="card-body p-3">
                <!-- BOTONES DE LA TABLA -->
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <button type="button" id="BtnCrearUsuario" class="btn btn-success">
                            <i class="bi bi-person-plus me-1"></i> Nuevo Usuario
                        </button>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-success" id="BtnFiltroActivos">
                                <i class="bi bi-check-circle me-1"></i> Activos
                            </button>
                            <button type="button" class="btn btn-outline-warning" id="BtnFiltroInactivos">
                                <i class="bi bi-x-circle me-1"></i> Inactivos
                            </button>
                            <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filtros Avanzados -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select" id="filtroRol">
                            <option value="">Todos los roles</option>
                            <option value="administrador">Administradores</option>
                            <option value="empleado">Empleados</option>
                            <option value="cliente">Clientes</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="fechaDesde" placeholder="Fecha desde">
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="fechaHasta" placeholder="Fecha hasta">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="buscarUsuario" placeholder="Buscar usuario...">
                    </div>
                </div>

                <!-- TABLA -->
                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableUsuarios">
                        <!-- DataTable se genera automáticamente desde JS -->
                    </table>
                </div>

                <!-- Estadísticas de Usuarios -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-graph-up me-2"></i>Estadísticas de Usuarios
                                </h6>
                                <div class="row text-center">
                                    <div class="col-md-2">
                                        <h5 class="text-primary" id="totalUsuarios">0</h5>
                                        <small class="text-muted">Total</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-danger" id="totalAdmins">0</h5>
                                        <small class="text-muted">Administradores</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-warning" id="totalEmpleados">0</h5>
                                        <small class="text-muted">Empleados</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-info" id="totalClientes">0</h5>
                                        <small class="text-muted">Clientes</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-success" id="usuariosActivos">0</h5>
                                        <small class="text-muted">Activos</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-secondary" id="usuariosInactivos">0</h5>
                                        <small class="text-muted">Inactivos</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/views/admin/usuarios/index.js') ?>"></script>