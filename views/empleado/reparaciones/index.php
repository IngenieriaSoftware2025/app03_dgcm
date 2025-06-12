<?php
// ARCHIVO: views/empleado/reparaciones/index.php
?>
<!-- SECCIÓN DEL FORMULARIO -->
<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #fd7e14;">
            <div class="card-header bg-warning text-dark text-center">
                <h4 class="mb-0">
                    <i class="bi bi-tools me-2"></i>
                    <span id="tituloFormulario">Gestionar Reparación</span>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Módulo de Reparaciones - Empleado!</h5>
                    <h4 class="text-center mb-2 text-warning">Actualización de Estado</h4>
                </div>

                <div class="row justify-content-center p-4 shadow-sm bg-light rounded">
                    <form id="FormReparacionesEmpleado">
                        <input type="hidden" id="id_reparacion" name="id_reparacion">

                        <!-- Filtro para Mis Reparaciones -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-warning fw-bold">
                                    <i class="bi bi-funnel me-2"></i>Mis Reparaciones Asignadas
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="filtro_estado" class="form-label">Filtrar por Estado</label>
                                <select class="form-select" id="filtro_estado">
                                    <option value="">Todos los estados</option>
                                    <option value="Ingresado">Recién Ingresadas</option>
                                    <option value="En Proceso">En Proceso</option>
                                    <option value="Terminado">Terminadas</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="buscar_reparacion" class="form-label">Buscar Reparación</label>
                                <input type="text" class="form-control" id="buscar_reparacion"
                                    placeholder="Cliente, motivo, celular...">
                            </div>
                        </div>

                        <!-- Selección de Reparación -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-warning fw-bold">
                                    <i class="bi bi-list-check me-2"></i>Seleccionar Reparación
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-12">
                                <label for="seleccionar_reparacion" class="form-label">Reparación a Actualizar</label>
                                <select class="form-select" id="seleccionar_reparacion" name="seleccionar_reparacion" required>
                                    <option value="">-- Seleccione una reparación --</option>
                                </select>
                            </div>
                        </div>

                        <!-- Información de la Reparación Seleccionada -->
                        <div class="row mb-4 d-none" id="infoReparacion">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <h6 class="fw-bold">Información de la Reparación</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Cliente:</strong> <span id="cliente_nombre"></span></p>
                                                <p><strong>Teléfono:</strong> <span id="cliente_telefono"></span></p>
                                                <p><strong>Celular:</strong> <span id="celular_info"></span></p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Motivo:</strong> <span id="motivo_reparacion"></span></p>
                                                <p><strong>Fecha Ingreso:</strong> <span id="fecha_ingreso"></span></p>
                                                <p><strong>Costo:</strong> Q.<span id="costo_servicio"></span></p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Actualización de Estado -->
                        <div class="row mb-4 d-none" id="seccionActualizacion">
                            <div class="col-12">
                                <h6 class="text-warning fw-bold">
                                    <i class="bi bi-arrow-repeat me-2"></i>Actualizar Estado
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="nuevo_estado" class="form-label">Nuevo Estado</label>
                                <select class="form-select" id="nuevo_estado" name="nuevo_estado" required>
                                    <option value="">-- Seleccionar estado --</option>
                                    <option value="En Proceso">Marcar En Proceso</option>
                                    <option value="Terminado">Marcar Terminado</option>
                                    <option value="Entregado">Marcar Entregado</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="fecha_entrega" class="form-label">Fecha de Entrega (si aplica)</label>
                                <input type="datetime-local" class="form-control" id="fecha_entrega" name="fecha_entrega">
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="row mb-4 d-none" id="seccionObservaciones">
                            <div class="col-12">
                                <label for="observaciones" class="form-label">Observaciones del Trabajo</label>
                                <textarea class="form-control" id="observaciones" name="observaciones" rows="3"
                                    placeholder="Detalles del trabajo realizado, piezas cambiadas, etc..."></textarea>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- BOTONES DEL FORMULARIO -->
                <div class="row justify-content-between mt-4 px-4">
                    <div class="col-auto">
                        <button class="btn btn-warning btn-lg d-none" type="submit" form="FormReparacionesEmpleado" id="BtnActualizarEstado">
                            <i class="bi bi-arrow-repeat me-1"></i> Actualizar Estado
                        </button>
                        <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiarReparacion">
                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                        </button>
                    </div>

                    <div class="col-auto">
                        <button type="button" id="BtnVerTodasReparaciones" class="btn btn-info">
                            <i class="bi bi-list me-1"></i> Ver Todas Mis Reparaciones
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
                    <i class="bi bi-tools me-2"></i>
                    Mis Reparaciones Asignadas
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <button type="button" id="BtnGestionarReparacion" class="btn btn-warning">
                            <i class="bi bi-tools me-1"></i> Gestionar Reparación
                        </button>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-danger" id="BtnPendientes">
                                <i class="bi bi-clock me-1"></i> Pendientes
                            </button>
                            <button type="button" class="btn btn-outline-warning" id="BtnEnProceso">
                                <i class="bi bi-gear me-1"></i> En Proceso
                            </button>
                            <button type="button" class="btn btn-outline-success" id="BtnTerminadas">
                                <i class="bi bi-check-circle me-1"></i> Terminadas
                            </button>
                            <button type="button" id="BtnActualizarTabla" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableReparacionesEmpleado">
                        <!-- DataTable se genera automáticamente -->
                    </table>
                </div>

                <!-- Resumen de Reparaciones -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Resumen de Mis Reparaciones</h6>
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <h5 class="text-danger" id="totalPendientes">0</h5>
                                        <small class="text-muted">Pendientes</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-warning" id="totalEnProceso">0</h5>
                                        <small class="text-muted">En Proceso</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-success" id="totalTerminadas">0</h5>
                                        <small class="text-muted">Terminadas</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-info" id="totalEntregadas">0</h5>
                                        <small class="text-muted">Entregadas</small>
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

<script src="<?= asset('build/js/empleado/reparaciones.js') ?>"></script>