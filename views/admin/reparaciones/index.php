<?php
// ARCHIVO: views/admin/reparaciones/index.php
?>
<!-- SECCIÓN DE CONTROL DE REPARACIONES -->
<div class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #fd7e14;">
            <div class="card-header bg-warning text-dark text-center">
                <h4 class="mb-0">
                    <i class="bi bi-tools me-2"></i>
                    Control Total de Reparaciones
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Panel de Administrador - Supervisión Completa de Reparaciones!</h5>
                    <h4 class="text-center mb-2 text-warning">Gestión y Análisis de Servicios Técnicos</h4>
                </div>

                <!-- Panel de Estado de Reparaciones -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-info text-white text-center">
                            <div class="card-body">
                                <i class="bi bi-inbox display-6"></i>
                                <h4 id="reparacionesIngresadas">0</h4>
                                <small>Ingresadas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-warning text-dark text-center">
                            <div class="card-body">
                                <i class="bi bi-gear display-6"></i>
                                <h4 id="reparacionesProceso">0</h4>
                                <small>En Proceso</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-success text-white text-center">
                            <div class="card-body">
                                <i class="bi bi-check-circle display-6"></i>
                                <h4 id="reparacionesTerminadas">0</h4>
                                <small>Terminadas</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-primary text-white text-center">
                            <div class="card-body">
                                <i class="bi bi-check2-all display-6"></i>
                                <h4 id="reparacionesEntregadas">0</h4>
                                <small>Entregadas</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Filtros y Asignaciones -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-sliders me-2"></i>Control y Asignaciones
                                </h6>
                                <div class="row align-items-center">
                                    <div class="col-md-2">
                                        <label for="filtroEstadoRep" class="form-label small">Estado:</label>
                                        <select class="form-select" id="filtroEstadoRep">
                                            <option value="">Todos</option>
                                            <option value="Ingresado">Ingresado</option>
                                            <option value="En Proceso">En Proceso</option>
                                            <option value="Terminado">Terminado</option>
                                            <option value="Entregado">Entregado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="filtroEmpleadoRep" class="form-label small">Empleado:</label>
                                        <select class="form-select" id="filtroEmpleadoRep">
                                            <option value="">Todos</option>
                                            <!-- Se cargan dinámicamente -->
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="filtroTipoServicio" class="form-label small">Servicio:</label>
                                        <select class="form-select" id="filtroTipoServicio">
                                            <option value="">Todos</option>
                                            <!-- Se cargan dinámicamente -->
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="fechaIngresoDesde" class="form-label small">Ingreso desde:</label>
                                        <input type="date" class="form-control" id="fechaIngresoDesde">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="fechaIngresoHasta" class="form-label small">Hasta:</label>
                                        <input type="date" class="form-control" id="fechaIngresoHasta">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="buscarReparacion" class="form-label small">Buscar:</label>
                                        <input type="text" class="form-control" id="buscarReparacion"
                                            placeholder="Cliente, motivo...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Gestión -->
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <div class="btn-group" role="group">
                            <button type="button" id="BtnNuevaReparacion" class="btn btn-warning">
                                <i class="bi bi-tools me-1"></i> Nueva Reparación
                            </button>
                            <button type="button" id="BtnAsignacionMasiva" class="btn btn-outline-warning">
                                <i class="bi bi-people me-1"></i> Asignación Masiva
                            </button>
                            <button type="button" id="BtnReporteReparaciones" class="btn btn-outline-primary">
                                <i class="bi bi-file-text me-1"></i> Generar Reporte
                            </button>
                        </div>
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
                            <button type="button" id="BtnActualizarReparaciones" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Reparaciones -->
                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableReparacionesAdmin">
                        <!-- DataTable se genera automáticamente -->
                    </table>
                </div>

                <!-- Análisis y Métricas -->
                <div class="row mt-4">
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Tiempo Promedio</h6>
                                <div class="text-center">
                                    <h4 class="text-primary" id="tiempoPromedioReparacion">0 días</h4>
                                    <small class="text-muted">Tiempo de reparación</small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Ingresos por Reparaciones</h6>
                                <div class="text-center">
                                    <h4 class="text-success" id="ingresosTotalReparaciones">Q.0</h4>
                                    <div class="row mb-3 justify-content-center">
                                        <div class="col-lg-12">
                                            <label for="descripcion" class="form-label">
                                                <i class="bi bi-card-text me-1"></i>Descripción del Rol
                                            </label>
                                            <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                                placeholder="Describe las responsabilidades y alcance de este rol..."></textarea>
                                        </div>
                                    </div>
                                    </form>
                                </div>

                                <!-- BOTONES DEL FORMULARIO -->
                                <div class="row justify-content-between mt-4 px-5">
                                    <div class="col-auto">
                                        <button class="btn btn-success" type="submit" form="FormRoles" id="BtnGuardar">
                                            <i class="bi bi-shield-plus me-1"></i> Guardar Rol
                                        </button>
                                        <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                                            <i class="bi bi-pen me-1"></i> Modificar
                                        </button>
                                        <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiar">
                                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                                        </button>
                                    </div>

                                    <div class="col-auto">
                                        <button type="button" id="BtnVerRoles" class="btn btn-info">
                                            <i class="bi bi-list-ul me-1"></i> Ver Roles del Sistema
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- SECCIÓN DE LA TABLA -->
                <div id="seccionTabla" class="row justify-content-center p-3 d-none">
                    <div class="col-lg-10">
                        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #17a2b8;">
                            <div class="card-header bg-info text-white text-center">
                                <h4 class="mb-0">
                                    <i class="bi bi-list-ul me-2"></i>
                                    Roles del Sistema
                                </h4>
                            </div>
                            <div class="card-body p-3">
                                <div class="row justify-content-between mb-3">
                                    <div class="col-auto">
                                        <button type="button" id="BtnCrearRol" class="btn btn-success">
                                            <i class="bi bi-shield-plus me-1"></i> Crear Nuevo Rol
                                        </button>
                                    </div>
                                    <div class="col-auto">
                                        <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Lista
                                        </button>
                                    </div>
                                </div>

                                <div class="table-responsive p-2">
                                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableRoles">
                                        <!-- DataTable se genera automáticamente -->
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <script src="<?= asset('build/js/admin/roles.js') ?>"></script>