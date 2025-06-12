<?php
// ARCHIVO: views/admin/estadisticas/index.php
?>
<!-- PANEL DE CONTROL DE ESTADÍSTICAS -->
<div class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #6f42c1;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-graph-up me-2"></i>
                    Centro de Estadísticas y Reportes
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Panel de Administrador - Análisis Completo del Negocio!</h5>
                    <h4 class="text-center mb-2 text-primary">Métricas, Reportes y Análisis de Datos</h4>
                </div>

                <!-- Controles de Filtrado -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-funnel me-2"></i>Filtros de Análisis
                                </h6>
                                <div class="row align-items-end">
                                    <div class="col-md-3">
                                        <label for="periodoAnalisis" class="form-label">Período:</label>
                                        <select class="form-select" id="periodoAnalisis">
                                            <option value="hoy">Hoy</option>
                                            <option value="semana">Esta Semana</option>
                                            <option value="mes" selected>Este Mes</option>
                                            <option value="trimestre">Este Trimestre</option>
                                            <option value="ano">Este Año</option>
                                            <option value="personalizado">Personalizado</option>
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="fechaInicio" class="form-label">Fecha Inicio:</label>
                                        <input type="date" class="form-control" id="fechaInicio">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="fechaFin" class="form-label">Fecha Fin:</label>
                                        <input type="date" class="form-control" id="fechaFin">
                                    </div>
                                    <div class="col-md-2">
                                        <label for="filtroEmpleado" class="form-label">Empleado:</label>
                                        <select class="form-select" id="filtroEmpleado">
                                            <option value="">Todos</option>
                                            <!-- Se carga dinámicamente -->
                                        </select>
                                    </div>
                                    <div class="col-md-2">
                                        <label for="filtroCategoria" class="form-label">Categoría:</label>
                                        <select class="form-select" id="filtroCategoria">
                                            <option value="">Todas</option>
                                            <option value="ventas">Ventas</option>
                                            <option value="reparaciones">Reparaciones</option>
                                            <option value="inventario">Inventario</option>
                                        </select>
                                    </div>
                                    <div class="col-md-1">
                                        <button type="button" id="BtnActualizarEstadisticas" class="btn btn-primary w-100">
                                            <i class="bi bi-arrow-clockwise"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Métricas Principales -->
                <div class="row g-3 mb-4">
                    <div class="col-md-3">
                        <div class="card bg-gradient text-white h-100" style="background: linear-gradient(45deg, #28a745, #20c997);">
                            <div class="card-body text-center">
                                <i class="bi bi-cash-coin display-4 mb-2"></i>
                                <h3 id="totalVentasPeriodo">Q.0</h3>
                                <p class="mb-1">Ventas Totales</p>
                                <small id="comparacionVentas" class="badge bg-light text-dark">+0%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-gradient text-white h-100" style="background: linear-gradient(45deg, #17a2b8, #6f42c1);">
                            <div class="card-body text-center">
                                <i class="bi bi-phone display-4 mb-2"></i>
                                <h3 id="totalCelularesVendidos">0</h3>
                                <p class="mb-1">Celulares Vendidos</p>
                                <small id="comparacionCelulares" class="badge bg-light text-dark">+0%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-gradient text-white h-100" style="background: linear-gradient(45deg, #ffc107, #fd7e14);">
                            <div class="card-body text-center">
                                <i class="bi bi-tools display-4 mb-2"></i>
                                <h3 id="totalReparacionesPeriodo">0</h3>
                                <p class="mb-1">Reparaciones</p>
                                <small id="comparacionReparaciones" class="badge bg-light text-dark">+0%</small>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="card bg-gradient text-white h-100" style="background: linear-gradient(45deg, #dc3545, #e83e8c);">
                            <div class="card-body text-center">
                                <i class="bi bi-people display-4 mb-2"></i>
                                <h3 id="totalClientesNuevos">0</h3>
                                <p class="mb-1">Clientes Nuevos</p>
                                <small id="comparacionClientes" class="badge bg-light text-dark">+0%</small>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Gráficos Principales -->
                <div class="row mb-4">
                    <div class="col-md-8">
                        <div class="card">
                            <div class="card-header">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h6 class="mb-0">
                                        <i class="bi bi-graph-up me-2"></i>Evolución de Ventas
                                    </h6>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <button type="button" class="btn btn-outline-primary active" data-chart="ventas-diarias">Diario</button>
                                        <button type="button" class="btn btn-outline-primary" data-chart="ventas-semanales">Semanal</button>
                                        <button type="button" class="btn btn-outline-primary" data-chart="ventas-mensuales">Mensual</button>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="chartEvolucionVentas" width="400" height="200"></canvas>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-pie-chart me-2"></i>Distribución por Categoría
                                </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="chartDistribucionCategorias" width="300" height="300"></canvas>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Análisis Detallado -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-trophy me-2"></i>Top 10 Productos Más Vendidos
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="tableTopProductos">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Producto</th>
                                                <th>Cantidad</th>
                                                <th>Ingresos</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Se llena dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-star me-2"></i>Mejores Empleados del Período
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-sm" id="tableTopEmpleados">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Empleado</th>
                                                <th>Ventas</th>
                                                <th>Total</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Se llena dinámicamente -->
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Análisis de Inventario y Reparaciones -->
                <div class="row mb-4">
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-box-seam me-2"></i>Estado del Inventario
                                </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="chartEstadoInventario" width="400" height="250"></canvas>

                                <div class="row mt-3 text-center">
                                    <div class="col-4">
                                        <h6 class="text-success" id="productosDisponibles">0</h6>
                                        <small class="text-muted">Disponibles</small>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="text-warning" id="productosStockBajo">0</h6>
                                        <small class="text-muted">Stock Bajo</small>
                                    </div>
                                    <div class="col-4">
                                        <h6 class="text-danger" id="productosAgotados">0</h6>
                                        <small class="text-muted">Agotados</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-tools me-2"></i>Análisis de Reparaciones
                                </h6>
                            </div>
                            <div class="card-body">
                                <canvas id="chartAnalisisReparaciones" width="400" height="250"></canvas>

                                <div class="row mt-3 text-center">
                                    <div class="col-3">
                                        <h6 class="text-info" id="reparacionesIngresadas">0</h6>
                                        <small class="text-muted">Ingresadas</small>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-warning" id="reparacionesProceso">0</h6>
                                        <small class="text-muted">En Proceso</small>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-success" id="reparacionesTerminadas">0</h6>
                                        <small class="text-muted">Terminadas</small>
                                    </div>
                                    <div class="col-3">
                                        <h6 class="text-primary" id="reparacionesEntregadas">0</h6>
                                        <small class="text-muted">Entregadas</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Métricas de Rendimiento -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-speedometer2 me-2"></i>Métricas de Rendimiento del Negocio
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-2">
                                        <div class="border rounded p-3">
                                            <h5 class="text-success" id="ticketPromedio">Q.0</h5>
                                            <small class="text-muted">Ticket Promedio</small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="border rounded p-3">
                                            <h5 class="text-info" id="ventasPorDia">0</h5>
                                            <small class="text-muted">Ventas/Día</small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="border rounded p-3">
                                            <h5 class="text-warning" id="tiempoPromedioReparacion">0</h5>
                                            <small class="text-muted">Tiempo Promedio Rep.</small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="border rounded p-3">
                                            <h5 class="text-primary" id="satisfaccionClientes">0%</h5>
                                            <small class="text-muted">Satisfacción</small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="border rounded p-3">
                                            <h5 class="text-danger" id="rotacionInventario">0</h5>
                                            <small class="text-muted">Rotación Stock</small>
                                        </div>
                                    </div>
                                    <div class="col-md-2">
                                        <div class="border rounded p-3">
                                            <h5 class="text-secondary" id="margenGanancia">0%</h5>
                                            <small class="text-muted">Margen Promedio</small>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Botones de Reportes -->
                <div class="row">
                    <div class="col-12">
                        <div class="card">
                            <div class="card-header">
                                <h6 class="mb-0">
                                    <i class="bi bi-file-earmark-pdf me-2"></i>Generar Reportes
                                </h6>
                            </div>
                            <div class="card-body">
                                <div class="row g-2">
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-danger w-100" id="BtnReporteVentas">
                                            <i class="bi bi-file-pdf me-1"></i>
                                            <small>Reporte Ventas</small>
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-warning w-100" id="BtnReporteInventario">
                                            <i class="bi bi-file-excel me-1"></i>
                                            <small>Reporte Inventario</small>
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-info w-100" id="BtnReporteReparaciones">
                                            <i class="bi bi-file-word me-1"></i>
                                            <small>Reporte Reparaciones</small>
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-success w-100" id="BtnReporteClientes">
                                            <i class="bi bi-file-text me-1"></i>
                                            <small>Reporte Clientes</small>
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-primary w-100" id="BtnReporteFinanciero">
                                            <i class="bi bi-file-ruled me-1"></i>
                                            <small>Reporte Financiero</small>
                                        </button>
                                    </div>
                                    <div class="col-md-2">
                                        <button type="button" class="btn btn-outline-secondary w-100" id="BtnReporteCompleto">
                                            <i class="bi bi-file-zip me-1"></i>
                                            <small>Reporte Completo</small>
                                        </button>
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

<!-- Modal para Configurar Reporte -->
<div class="modal fade" id="modalConfigurarReporte" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-file-earmark-text me-2"></i>Configurar Reporte
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="FormConfigurarReporte">
                    <input type="hidden" id="tipoReporte" name="tipo_reporte">

                    <div class="mb-3">
                        <label for="tituloReporte" class="form-label">Título del Reporte:</label>
                        <input type="text" class="form-control" id="tituloReporte" name="titulo" required>
                    </div>

                    <div class="row mb-3">
                        <div class="col-6">
                            <label for="fechaInicioReporte" class="form-label">Fecha Inicio:</label>
                            <input type="date" class="form-control" id="fechaInicioReporte" name="fecha_inicio" required>
                        </div>
                        <div class="col-6">
                            <label for="fechaFinReporte" class="form-label">Fecha Fin:</label>
                            <input type="date" class="form-control" id="fechaFinReporte" name="fecha_fin" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="formatoReporte" class="form-label">Formato:</label>
                        <select class="form-select" id="formatoReporte" name="formato" required>
                            <option value="pdf">PDF</option>
                            <option value="excel">Excel</option>
                            <option value="csv">CSV</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label class="form-label">Incluir:</label>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="incluirGraficos" name="incluir_graficos" checked>
                            <label class="form-check-label" for="incluirGraficos">Gráficos</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="incluirTablas" name="incluir_tablas" checked>
                            <label class="form-check-label" for="incluirTablas">Tablas de Datos</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="checkbox" id="incluirAnalisis" name="incluir_analisis" checked>
                            <label class="form-check-label" for="incluirAnalisis">Análisis Automático</label>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-primary" id="BtnGenerarReporte">
                    <i class="bi bi-download me-1"></i>Generar Reporte
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/admin/estadisticas.js') ?>"></script>