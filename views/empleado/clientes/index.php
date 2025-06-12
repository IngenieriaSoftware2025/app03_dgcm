<?php
// ARCHIVO: views/empleado/clientes/index.php
?>
<div class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #20c997;">
            <div class="card-header bg-info text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-people me-2"></i>
                    Consulta de Clientes
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Funciones disponibles:</strong> Consultar información de clientes y su historial.
                            No puedes crear o eliminar clientes.
                        </div>
                    </div>
                </div>

                <!-- Búsqueda de Clientes -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-search me-2"></i>Buscar Cliente
                                </h6>
                                <div class="row align-items-center">
                                    <div class="col-md-6">
                                        <label for="buscarCliente" class="form-label">Buscar por:</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" id="buscarCliente"
                                                placeholder="Nombre, teléfono, correo, DPI...">
                                            <button class="btn btn-primary" type="button" id="btnBuscarCliente">
                                                <i class="bi bi-search"></i> Buscar
                                            </button>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filtroEstado" class="form-label">Estado:</label>
                                        <select class="form-select" id="filtroEstado">
                                            <option value="">Todos</option>
                                            <option value="1">Activos</option>
                                            <option value="0">Inactivos</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filtroFecha" class="form-label">Registrados:</label>
                                        <select class="form-select" id="filtroFecha">
                                            <option value="">Cualquier fecha</option>
                                            <option value="hoy">Hoy</option>
                                            <option value="semana">Esta semana</option>
                                            <option value="mes">Este mes</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Clientes -->
                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableClientesEmpleado">
                        <!-- DataTable se genera automáticamente -->
                    </table>
                </div>

                <!-- Botones -->
                <div class="row justify-content-between mt-4 px-4">
                    <div class="col-auto">
                        <button type="button" id="BtnExportarClientes" class="btn btn-outline-success">
                            <i class="bi bi-file-excel me-1"></i> Exportar Lista
                        </button>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="BtnActualizarClientes" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Lista
                        </button>
                    </div>
                </div>

                <!-- Estadísticas -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Estadísticas de Clientes</h6>
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <h5 class="text-primary" id="totalClientes">0</h5>
                                        <small class="text-muted">Total Clientes</small>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="text-success" id="clientesActivos">0</h5>
                                        <small class="text-muted">Activos</small>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="text-info" id="clientesNuevosHoy">0</h5>
                                        <small class="text-muted">Nuevos Hoy</small>
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

<!-- Modal Detalle del Cliente -->
<div class="modal fade" id="modalDetalleCliente" tabindex="-1">
    <div class="modal-dialog modal-xl">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-person me-2"></i>Información Completa del Cliente
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleClienteContent">
                <!-- Se llena dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" id="btnVerHistorialCliente">
                    <i class="bi bi-clock-history me-1"></i>Ver Historial Completo
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/empleado/clientes.js') ?>"></script>