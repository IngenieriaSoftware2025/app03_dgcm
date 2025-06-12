<?php
// ARCHIVO: views/empleado/celulares/index.php
?>
<div class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #6610f2;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-phone me-2"></i>
                    Consulta de Inventario - Solo Lectura
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <div class="col-12">
                        <div class="alert alert-info">
                            <i class="bi bi-info-circle me-2"></i>
                            <strong>Modo Consulta:</strong> Como empleado, puedes consultar el inventario pero no modificarlo.
                            Para cambios, contacta a un administrador.
                        </div>
                    </div>
                </div>

                <!-- Filtros de Búsqueda -->
                <div class="row mb-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">
                                    <i class="bi bi-funnel me-2"></i>Filtros de Búsqueda
                                </h6>
                                <div class="row align-items-center">
                                    <div class="col-md-3">
                                        <label for="filtroMarca" class="form-label small">Marca:</label>
                                        <select class="form-select" id="filtroMarca">
                                            <option value="">Todas las marcas</option>
                                            <!-- Se cargan dinámicamente -->
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filtroStock" class="form-label small">Stock:</label>
                                        <select class="form-select" id="filtroStock">
                                            <option value="">Todo el stock</option>
                                            <option value="disponible">Disponibles (>0)</option>
                                            <option value="agotado">Agotados (0)</option>
                                            <option value="bajo">Stock bajo (≤5)</option>
                                        </select>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="filtroPrecio" class="form-label small">Precio máximo:</label>
                                        <input type="range" class="form-range" id="filtroPrecio" min="500" max="20000" value="20000">
                                        <small class="text-muted">Q. <span id="precioMaximo">20,000</span></small>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="buscarCelular" class="form-label small">Buscar:</label>
                                        <input type="text" class="form-control" id="buscarCelular"
                                            placeholder="Modelo, marca...">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Tabla de Inventario -->
                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableInventarioEmpleado">
                        <!-- DataTable se genera automáticamente -->
                    </table>
                </div>

                <!-- Botones -->
                <div class="row justify-content-between mt-4 px-4">
                    <div class="col-auto">
                        <button type="button" id="BtnExportarInventario" class="btn btn-outline-success">
                            <i class="bi bi-file-excel me-1"></i> Exportar a Excel
                        </button>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="BtnActualizarInventario" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Inventario
                        </button>
                    </div>
                </div>

                <!-- Resumen del Inventario -->
                <div class="row mt-4">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Resumen del Inventario</h6>
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <h5 class="text-primary" id="totalProductos">0</h5>
                                        <small class="text-muted">Total Productos</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-success" id="productosDisponibles">0</h5>
                                        <small class="text-muted">Disponibles</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-danger" id="productosAgotados">0</h5>
                                        <small class="text-muted">Agotados</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-warning" id="stockBajo">0</h5>
                                        <small class="text-muted">Stock Bajo</small>
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

<!-- Modal Detalle del Producto -->
<div class="modal fade" id="modalDetalleCelular" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title">
                    <i class="bi bi-phone me-2"></i>Detalle del Producto
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleCelularContent">
                <!-- Se llena dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/empleado/celulares.js') ?>"></script>