<?php
// ARCHIVO: views/admin/ventas/index.php
?>
<!-- SECCIÓN DEL FORMULARIO -->
<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-cash-coin me-2"></i>
                    <span id="tituloFormulario">Nueva Venta</span>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Módulo de Ventas de Celulares!</h5>
                    <h4 class="text-center mb-2 text-success">Registro de Ventas</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormVentas">
                        <input type="hidden" id="id_venta" name="id_venta">

                        <!-- Información de la Venta -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-success"><i class="bi bi-receipt me-2"></i>Información de la Venta</h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="id_cliente" class="form-label">Cliente</label>
                                <select class="form-select" id="id_cliente" name="id_cliente" required>
                                    <option value="">-- Seleccione un cliente --</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="tipo" class="form-label">Tipo de Venta</label>
                                <select class="form-select" id="tipo" name="tipo" required>
                                    <option value="C">Celular</option>
                                    <option value="R">Reparación</option>
                                </select>
                            </div>
                        </div>

                        <!-- Productos/Servicios -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-success"><i class="bi bi-cart-fill me-2"></i>Productos/Servicios</h6>
                                <hr>
                            </div>

                            <!-- Sección para Celulares -->
                            <div id="seccionCelulares">
                                <div class="row mb-3">
                                    <div class="col-lg-6">
                                        <label for="id_celular" class="form-label">Seleccionar Celular</label>
                                        <select class="form-select" id="id_celular" name="id_celular">
                                            <option value="">-- Seleccione un celular --</option>
                                        </select>
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="cantidad" class="form-label">Cantidad</label>
                                        <input type="number" class="form-control" id="cantidad" name="cantidad"
                                            min="1" value="1">
                                    </div>
                                    <div class="col-lg-3">
                                        <label for="precio_unitario" class="form-label">Precio Unitario</label>
                                        <input type="number" step="0.01" class="form-control" id="precio_unitario"
                                            name="precio_unitario" readonly>
                                    </div>
                                </div>

                                <!-- Información de Stock -->
                                <div class="row mb-3" id="infoStock" style="display: none;">
                                    <div class="col-12">
                                        <div class="alert alert-info">
                                            <i class="bi bi-info-circle me-2"></i>
                                            <span id="stockDisponible">Stock disponible: 0 unidades</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Sección para Reparaciones -->
                            <div id="seccionReparaciones" class="d-none">
                                <div class="row mb-3">
                                    <div class="col-lg-12">
                                        <label for="id_reparacion" class="form-label">Seleccionar Reparación Terminada</label>
                                        <select class="form-select" id="id_reparacion" name="id_reparacion">
                                            <option value="">-- Seleccione una reparación --</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Total de la Venta -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <h6 class="text-success"><i class="bi bi-calculator me-2"></i>Total de la Venta</h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="total" class="form-label">Total a Pagar</label>
                                <div class="input-group">
                                    <span class="input-group-text">Q.</span>
                                    <input type="number" step="0.01" class="form-control fs-4 fw-bold text-success"
                                        id="total" name="total" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="metodo_pago" class="form-label">Método de Pago</label>
                                <select class="form-select" id="metodo_pago" name="metodo_pago">
                                    <option value="efectivo">Efectivo</option>
                                    <option value="tarjeta">Tarjeta</option>
                                    <option value="transferencia">Transferencia</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- BOTONES DEL FORMULARIO -->
                <div class="row justify-content-between mt-4 px-5">
                    <div class="col-auto">
                        <button class="btn btn-success" type="submit" form="FormVentas" id="BtnGuardar">
                            <i class="bi bi-cash-coin me-1"></i> Procesar Venta
                        </button>
                        <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiar">
                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                        </button>
                    </div>

                    <div class="col-auto">
                        <button type="button" id="BtnVerVentas" class="btn btn-info">
                            <i class="bi bi-receipt-cutoff me-1"></i> Ver Historial
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
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #17a2b8;">
            <div class="card-header bg-info text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-receipt-cutoff me-2"></i>
                    Historial de Ventas
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <button type="button" id="BtnNuevaVenta" class="btn btn-success">
                            <i class="bi bi-cash-coin me-1"></i> Nueva Venta
                        </button>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-primary" id="BtnHoy">
                                <i class="bi bi-calendar-day me-1"></i> Hoy
                            </button>
                            <button type="button" class="btn btn-outline-warning" id="BtnSemana">
                                <i class="bi bi-calendar-week me-1"></i> Semana
                            </button>
                            <button type="button" class="btn btn-outline-info" id="BtnMes">
                                <i class="bi bi-calendar-month me-1"></i> Mes
                            </button>
                            <button type="button" id="BtnActualizarTabla" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Filtros adicionales -->
                <div class="row mb-3">
                    <div class="col-md-3">
                        <select class="form-select" id="filtroTipo">
                            <option value="">Todos los tipos</option>
                            <option value="C">Solo Celulares</option>
                            <option value="R">Solo Reparaciones</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <select class="form-select" id="filtroEmpleado">
                            <option value="">Todos los empleados</option>
                            <!-- Se carga dinámicamente -->
                        </select>
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="fechaDesde" placeholder="Fecha desde">
                    </div>
                    <div class="col-md-3">
                        <input type="date" class="form-control" id="fechaHasta" placeholder="Fecha hasta">
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableVentas">
                        <!-- DataTable se genera automáticamente -->
                    </table>
                </div>

                <!-- Totales del período -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <h5 class="text-primary" id="totalVentas">Q. 0.00</h5>
                                        <small class="text-muted">Total Ventas</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-success" id="totalCelulares">0</h5>
                                        <small class="text-muted">Celulares Vendidos</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-warning" id="totalReparaciones">0</h5>
                                        <small class="text-muted">Reparaciones</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-info" id="totalTransacciones">0</h5>
                                        <small class="text-muted">Transacciones</small>
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

<!-- Modal para Confirmar Venta -->
<div class="modal fade" id="modalConfirmarVenta" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle me-2"></i>Confirmar Venta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="resumenVenta">
                    <!-- Se llena dinámicamente -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="button" class="btn btn-success" id="BtnConfirmarVenta">
                    <i class="bi bi-cash-coin me-1"></i>Confirmar Venta
                </button>
            </div>
        </div>
    </div>
</div>

<!-- Modal para Ver Detalle de Venta -->
<div class="modal fade" id="modalDetalleVenta" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-info text-white">
                <h5 class="modal-title">
                    <i class="bi bi-receipt me-2"></i>Detalle de Venta
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <div id="detalleVentaContent">
                    <!-- Se llena dinámicamente -->
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" id="BtnImprimirTicket">
                    <i class="bi bi-printer me-1"></i>Imprimir Ticket
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/ventas/ventas.js') ?>"></script>