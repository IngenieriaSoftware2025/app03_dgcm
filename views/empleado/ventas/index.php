<?php
// ARCHIVO: views/empleado/ventas/index.php
?>
<!-- SECCIÓN DEL FORMULARIO -->
<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-12">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #28a745;">
            <div class="card-header bg-success text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-cash-coin me-2"></i>
                    <span id="tituloFormulario">Procesar Nueva Venta</span>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Módulo de Ventas - Empleado!</h5>
                    <h4 class="text-center mb-2 text-success">Proceso de Venta</h4>
                </div>

                <div class="row justify-content-center p-4 shadow-sm bg-light rounded">
                    <form id="FormVentasEmpleado">
                        <input type="hidden" id="id_venta" name="id_venta">
                        <input type="hidden" id="id_empleado_vendedor" name="id_empleado_vendedor"
                            value="<?= $_SESSION['empleado_id'] ?? '' ?>">

                        <!-- Información del Cliente -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-success fw-bold">
                                    <i class="bi bi-person me-2"></i>Cliente
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-8">
                                <label for="buscar_cliente" class="form-label">Buscar Cliente (Teléfono/Nombre/DPI)</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" id="buscar_cliente"
                                        placeholder="Escriba para buscar cliente...">
                                    <button class="btn btn-outline-primary" type="button" id="btnBuscarCliente">
                                        <i class="bi bi-search"></i>
                                    </button>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="id_cliente" class="form-label">Cliente Seleccionado</label>
                                <select class="form-select" id="id_cliente" name="id_cliente" required>
                                    <option value="">-- Busque y seleccione cliente --</option>
                                </select>
                            </div>
                        </div>

                        <!-- Información del Cliente Seleccionado -->
                        <div class="row mb-4 d-none" id="infoCliente">
                            <div class="col-12">
                                <div class="alert alert-info">
                                    <strong>Cliente:</strong> <span id="nombreCliente"></span><br>
                                    <strong>Teléfono:</strong> <span id="telefonoCliente"></span><br>
                                    <strong>Correo:</strong> <span id="correoCliente"></span>
                                </div>
                            </div>
                        </div>

                        <!-- Tipo de Venta -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-success fw-bold">
                                    <i class="bi bi-tag me-2"></i>Tipo de Venta
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo" id="tipo_celular" value="C" checked>
                                    <label class="form-check-label" for="tipo_celular">
                                        <i class="bi bi-phone me-1"></i>Venta de Celular
                                    </label>
                                </div>
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="tipo" id="tipo_reparacion" value="R">
                                    <label class="form-check-label" for="tipo_reparacion">
                                        <i class="bi bi-tools me-1"></i>Cobrar Reparación
                                    </label>
                                </div>
                            </div>
                        </div>

                        <!-- Sección para Celulares -->
                        <div id="seccionCelulares">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-success fw-bold">
                                        <i class="bi bi-phone me-2"></i>Seleccionar Celular
                                    </h6>
                                    <hr>
                                </div>
                                <div class="col-lg-6">
                                    <label for="buscar_celular" class="form-label">Buscar Celular</label>
                                    <input type="text" class="form-control" id="buscar_celular"
                                        placeholder="Buscar por marca, modelo...">
                                </div>
                                <div class="col-lg-6">
                                    <label for="id_celular" class="form-label">Celular</label>
                                    <select class="form-select" id="id_celular" name="id_celular">
                                        <option value="">-- Seleccione un celular --</option>
                                    </select>
                                </div>
                            </div>

                            <div class="row mb-4" id="infoCelular" style="display: none;">
                                <div class="col-md-4">
                                    <label for="cantidad" class="form-label">Cantidad</label>
                                    <input type="number" class="form-control" id="cantidad" name="cantidad"
                                        min="1" value="1">
                                </div>
                                <div class="col-md-4">
                                    <label for="precio_unitario" class="form-label">Precio Unitario</label>
                                    <input type="number" step="0.01" class="form-control" id="precio_unitario"
                                        name="precio_unitario" readonly>
                                </div>
                                <div class="col-md-4">
                                    <label for="stock_disponible" class="form-label">Stock Disponible</label>
                                    <input type="text" class="form-control" id="stock_disponible" readonly>
                                </div>
                            </div>
                        </div>

                        <!-- Sección para Reparaciones -->
                        <div id="seccionReparaciones" class="d-none">
                            <div class="row mb-4">
                                <div class="col-12">
                                    <h6 class="text-success fw-bold">
                                        <i class="bi bi-tools me-2"></i>Reparación a Cobrar
                                    </h6>
                                    <hr>
                                </div>
                                <div class="col-lg-12">
                                    <label for="id_reparacion" class="form-label">Seleccionar Reparación Terminada</label>
                                    <select class="form-select" id="id_reparacion" name="id_reparacion">
                                        <option value="">-- Seleccione una reparación terminada --</option>
                                    </select>
                                </div>
                            </div>
                        </div>

                        <!-- Total y Método de Pago -->
                        <div class="row mb-4">
                            <div class="col-12">
                                <h6 class="text-success fw-bold">
                                    <i class="bi bi-calculator me-2"></i>Total de la Venta
                                </h6>
                                <hr>
                            </div>
                            <div class="col-lg-6">
                                <label for="total" class="form-label">Total a Cobrar</label>
                                <div class="input-group">
                                    <span class="input-group-text bg-success text-white">Q.</span>
                                    <input type="number" step="0.01" class="form-control fs-4 fw-bold text-success"
                                        id="total" name="total" readonly>
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <label for="metodo_pago" class="form-label">Método de Pago</label>
                                <select class="form-select" id="metodo_pago" name="metodo_pago" required>
                                    <option value="efectivo">Efectivo</option>
                                    <option value="tarjeta">Tarjeta de Crédito/Débito</option>
                                    <option value="transferencia">Transferencia Bancaria</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- BOTONES DEL FORMULARIO -->
                <div class="row justify-content-between mt-4 px-4">
                    <div class="col-auto">
                        <button class="btn btn-success btn-lg" type="submit" form="FormVentasEmpleado" id="BtnProcesarVenta">
                            <i class="bi bi-cash-coin me-1"></i> Procesar Venta
                        </button>
                        <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiarVenta">
                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                        </button>
                    </div>

                    <div class="col-auto">
                        <button type="button" id="BtnVerHistorial" class="btn btn-info">
                            <i class="bi bi-clock-history me-1"></i> Ver Historial
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
                            <button type="button" class="btn btn-outline-primary" id="BtnMisVentas">
                                <i class="bi bi-person me-1"></i> Mis Ventas
                            </button>
                            <button type="button" class="btn btn-outline-warning" id="BtnVentasHoy">
                                <i class="bi bi-calendar-day me-1"></i> Hoy
                            </button>
                            <button type="button" id="BtnActualizarTabla" class="btn btn-outline-secondary">
                                <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableVentasEmpleado">
                        <!-- DataTable se genera automáticamente -->
                    </table>
                </div>

                <!-- Resumen del Día -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Resumen de Hoy</h6>
                                <div class="row text-center">
                                    <div class="col-md-4">
                                        <h5 class="text-success" id="totalVentasHoy">Q. 0.00</h5>
                                        <small class="text-muted">Total Vendido Hoy</small>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="text-primary" id="cantidadVentasHoy">0</h5>
                                        <small class="text-muted">Ventas Procesadas</small>
                                    </div>
                                    <div class="col-md-4">
                                        <h5 class="text-warning" id="clientesAtendidosHoy">0</h5>
                                        <small class="text-muted">Clientes Atendidos</small>
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

<script src="<?= asset('build/js/empleado/ventas.js') ?>"></script>