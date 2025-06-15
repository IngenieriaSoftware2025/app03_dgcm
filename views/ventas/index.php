<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card shadow-lg border-primary">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0" id="tituloFormulario">
                    <i class="bi bi-receipt-cutoff me-2"></i> Registrar Venta
                </h4>
            </div>
            <div class="card-body">

                <form id="FormVenta">
                    <input type="hidden" id="id_venta" name="id_venta">

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="id_cliente" class="form-label">Cliente</label>
                            <select id="id_cliente" name="id_cliente" class="form-select">
                                <option value="">Seleccione un cliente</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="id_empleado_vendedor" class="form-label">Empleado Vendedor</label>
                            <select id="id_empleado_vendedor" name="id_empleado_vendedor" class="form-select">
                                <option value="">Seleccione un empleado</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label for="numero_factura" class="form-label">Factura</label>
                            <input type="text" class="form-control" id="numero_factura" name="numero_factura" placeholder="Número de factura">
                        </div>
                        <div class="col-lg-4">
                            <label for="tipo_venta" class="form-label">Tipo Venta</label>
                            <select id="tipo_venta" name="tipo_venta" class="form-select">
                                <option value="C">Celular</option>
                                <option value="R">Reparación</option>
                                <option value="M">Mixta</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="metodo_pago" class="form-label">Método Pago</label>
                            <select id="metodo_pago" name="metodo_pago" class="form-select">
                                <option value="Efectivo">Efectivo</option>
                                <option value="Tarjeta">Tarjeta</option>
                                <option value="Transferencia">Transferencia</option>
                            </select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label for="subtotal" class="form-label">Subtotal</label>
                            <input type="number" class="form-control" id="subtotal" name="subtotal" step="0.01" value="0.00">
                        </div>
                        <div class="col-lg-4">
                            <label for="descuento" class="form-label">Descuento</label>
                            <input type="number" class="form-control" id="descuento" name="descuento" step="0.01" value="0.00">
                        </div>
                        <div class="col-lg-4">
                            <label for="total" class="form-label">Total</label>
                            <input type="number" class="form-control" id="total" name="total" step="0.01" value="0.00">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="observaciones" class="form-label">Observaciones</label>
                        <textarea class="form-control" id="observaciones" name="observaciones" rows="2"></textarea>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" id="BtnGuardar" class="btn btn-success">
                                <i class="bi bi-save2-fill me-1"></i> Guardar
                            </button>
                            <button type="button" id="BtnModificar" class="btn btn-warning d-none">
                                <i class="bi bi-pencil-square me-1"></i> Modificar
                            </button>
                            <button type="reset" id="BtnLimpiar" class="btn btn-secondary ms-2">
                                <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                            </button>
                        </div>

                        <div>
                            <button type="button" id="BtnVerLista" class="btn btn-info">
                                <i class="bi bi-table me-1"></i> Ver Ventas
                            </button>
                        </div>
                    </div>
                </form>

            </div>
        </div>
    </div>
</div>

<div id="seccionTabla" class="row justify-content-center p-3 d-none">
    <div class="col-lg-10">
        <div class="card shadow-lg border-info">
            <div class="card-header bg-info text-white text-center">
                <h4 class="mb-0"><i class="bi bi-table me-2"></i> Ventas Registradas</h4>
            </div>
            <div class="card-body">

                <div class="d-flex justify-content-between mb-3">
                    <button id="BtnNuevo" class="btn btn-success"><i class="bi bi-plus-circle me-1"></i> Nueva Venta</button>
                    <button id="BtnActualizarTabla" class="btn btn-outline-primary"><i class="bi bi-arrow-clockwise me-1"></i> Actualizar</button>
                </div>

                <div class="table-responsive p-2">
                    <table id="TableVentas" class="table table-striped table-hover table-bordered w-100 table-sm"></table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/ventas/index.js') ?>"></script>