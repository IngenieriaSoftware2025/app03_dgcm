<?php
// ARCHIVO: views/admin/clientes/index.php
?>
<!-- SECCIÓN DEL FORMULARIO -->
<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-people-fill me-2"></i>
                    <span id="tituloFormulario">Gestión de Clientes</span>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Panel de Administrador - Gestión Completa de Clientes!</h5>
                    <h4 class="text-center mb-2 text-primary">Administrar Información de Clientes</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormClientes">
                        <input type="hidden" id="id_cliente" name="id_cliente">
                        <input type="hidden" id="id_usuario" name="id_usuario">

                        <!-- Información Personal del Cliente -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold">
                                    <i class="bi bi-person me-2"></i>Información Personal
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="nombre1" class="form-label">Primer Nombre</label>
                                <input type="text" class="form-control" id="nombre1" name="nombre1" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="nombre2" class="form-label">Segundo Nombre</label>
                                <input type="text" class="form-control" id="nombre2" name="nombre2">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-6">
                                <label for="apellido1" class="form-label">Primer Apellido</label>
                                <input type="text" class="form-control" id="apellido1" name="apellido1" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="apellido2" class="form-label">Segundo Apellido</label>
                                <input type="text" class="form-control" id="apellido2" name="apellido2">
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
                                <label for="telefono" class="form-label">Teléfono</label>
                                <input type="text" class="form-control" id="telefono" name="telefono" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="dpi" class="form-label">DPI</label>
                                <input type="text" class="form-control" id="dpi" name="dpi">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-12">
                                <label for="correo" class="form-label">Correo Electrónico</label>
                                <input type="email" class="form-control" id="correo" name="correo" required>
                            </div>
                        </div>

                        <!-- Información Adicional del Cliente -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold">
                                    <i class="bi bi-geo-alt me-2"></i>Información Adicional
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="direccion_principal" class="form-label">Dirección Principal</label>
                                <textarea class="form-control" id="direccion_principal" name="direccion_principal" rows="2"></textarea>
                            </div>
                            <div class="col-lg-6">
                                <label for="ciudad" class="form-label">Ciudad</label>
                                <input type="text" class="form-control" id="ciudad" name="ciudad">
                            </div>
                        </div>

                        <div class="row mb-4">
                            <div class="col-lg-4">
                                <label for="telefono_contacto" class="form-label">Teléfono de Contacto</label>
                                <input type="text" class="form-control" id="telefono_contacto" name="telefono_contacto">
                            </div>
                            <div class="col-lg-4">
                                <label for="codigo_postal" class="form-label">Código Postal</label>
                                <input type="text" class="form-control" id="codigo_postal" name="codigo_postal">
                            </div>
                            <div class="col-lg-4">
                                <label for="situacion" class="form-label">Estado</label>
                                <select class="form-select" id="situacion" name="situacion">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>

                        <!-- Preferencias del Cliente -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <h6 class="text-primary fw-bold">
                                    <i class="bi bi-gear me-2"></i>Preferencias de Comunicación
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="notificaciones_email" name="notificaciones_email" checked>
                                    <label class="form-check-label" for="notificaciones_email">
                                        Notificaciones por Email
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="notificaciones_sms" name="notificaciones_sms">
                                    <label class="form-check-label" for="notificaciones_sms">
                                        Notificaciones por SMS
                                    </label>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="newsletter" name="newsletter" checked>
                                    <label class="form-check-label" for="newsletter">
                                        Recibir Newsletter
                                    </label>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- BOTONES DEL FORMULARIO -->
                <div class="row justify-content-between mt-4 px-5">
                    <div class="col-auto">
                        <button class="btn btn-success" type="submit" form="FormClientes" id="BtnGuardar">
                            <i class="bi bi-person-plus me-1"></i> Guardar Cliente
                        </button>
                        <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                            <i class="bi bi-pen me-1"></i> Modificar
                        </button>
                        <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiar">
                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                        </button>
                    </div>

                    <div class="col-auto">
                        <button type="button" id="BtnVerClientes" class="btn btn-info">
                            <i class="bi bi-people me-1"></i> Ver Todos los Clientes
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
                    Clientes del Sistema
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <button type="button" id="BtnCrearCliente" class="btn btn-success">
                            <i class="bi bi-person-plus me-1"></i> Crear Nuevo Cliente
                        </button>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-success" id="BtnActivos">
                                <i class="bi bi-check-circle me-1"></i> Activos
                            </button>
                            <button type="button" class="btn btn-outline-warning" id="BtnInactivos">
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
                        <select class="form-select" id="filtroCiudad">
                            <option value="">Todas las ciudades</option>
                            <!-- Se carga dinámicamente -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="fechaRegistroDesde" placeholder="Registro desde">
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="fechaRegistroHasta" placeholder="Registro hasta">
                    </div>
                    <div class="col-md-3">
                        <input type="text" class="form-control" id="buscarCliente" placeholder="Buscar cliente...">
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableClientes">
                        <!-- DataTable se genera automáticamente -->
                    </table>
                </div>

                <!-- Estadísticas de Clientes -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Estadísticas de Clientes</h6>
                                <div class="row text-center">
                                    <div class="col-md-2">
                                        <h5 class="text-primary" id="totalClientes">0</h5>
                                        <small class="text-muted">Total Clientes</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-success" id="clientesActivos">0</h5>
                                        <small class="text-muted">Activos</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-warning" id="clientesConCompras">0</h5>
                                        <small class="text-muted">Con Compras</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-info" id="clientesConReparaciones">0</h5>
                                        <small class="text-muted">Con Reparaciones</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-danger" id="clientesNuevos">0</h5>
                                        <small class="text-muted">Nuevos (30 días)</small>
                                    </div>
                                    <div class="col-md-2">
                                        <h5 class="text-secondary" id="promedioCompras">Q.0</h5>
                                        <small class="text-muted">Promedio Compras</small>
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

<!-- Modal para Ver Historial del Cliente -->
<div class="modal fade" id="modalHistorialCliente" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-clock-history me-2"></i>Historial del Cliente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="historialClienteContent">
                    <!-- Se llena dinámicamente -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/admin/clientes.js') ?>"></script>