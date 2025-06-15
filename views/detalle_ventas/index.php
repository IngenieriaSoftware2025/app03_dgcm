<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-cart-fill me-2"></i>
                    <span id="tituloFormulario">Registrar Detalle de Venta</span>
                </h4>
            </div>
            <div class="card-body p-3">
                <form id="FormDetalleVenta">
                    <input type="hidden" id="id_detalle" name="id_detalle">

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="id_venta" class="form-label">Venta</label>
                            <select id="id_venta" name="id_venta" class="form-select">
                                <option value="">Seleccione la venta</option>
                            </select>
                        </div>

                        <div class="col-lg-6">
                            <label for="descripcion" class="form-label">Descripción</label>
                            <input type="text" id="descripcion" name="descripcion" class="form-control" placeholder="Descripción del detalle">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label for="id_celular" class="form-label">Celular (opcional)</label>
                            <select id="id_celular" name="id_celular" class="form-select">
                                <option value="">Seleccione celular (si aplica)</option>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="id_reparacion" class="form-label">Reparación (opcional)</label>
                            <select id="id_reparacion" name="id_reparacion" class="form-select">
                                <option value="">Seleccione reparación (si aplica)</option>
                            </select>
                        </div>

                        <div class="col-lg-4">
                            <label for="cantidad" class="form-label">Cantidad</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control" value="1" min="1">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label for="precio_unitario" class="form-label">Precio Unitario</label>
                            <input type="number" step="0.01" id="precio_unitario" name="precio_unitario" class="form-control" placeholder="Precio">
                        </div>

                        <div class="col-lg-4">
                            <label for="descuento_item" class="form-label">Descuento</label>
                            <input type="number" step="0.01" id="descuento_item" name="descuento_item" class="form-control" value="0">
                        </div>

                        <div class="col-lg-4">
                            <label for="subtotal_item" class="form-label">Subtotal</label>
                            <input type="number" step="0.01" id="subtotal_item" name="subtotal_item" class="form-control" readonly>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success" id="BtnGuardar">
                                <i class="bi bi-save"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-warning d-none" id="BtnModificar">
                                <i class="bi bi-pencil-square"></i> Modificar
                            </button>
                            <button type="reset" class="btn btn-secondary" id="BtnLimpiar">
                                <i class="bi bi-arrow-clockwise"></i> Limpiar
                            </button>
                        </div>
                        <div>
                            <button type="button" id="BtnVerLista" class="btn btn-info">
                                <i class="bi bi-card-list"></i> Ver Detalles
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center p-3 d-none" id="seccionTabla">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg">
            <div class="card-header bg-info text-white text-center">
                <h4>Detalles de Ventas</h4>
            </div>
            <div class="card-body p-3">
                <div class="mb-3 d-flex justify-content-between">
                    <button type="button" id="BtnNuevo" class="btn btn-success">
                        <i class="bi bi-plus-circle"></i> Nuevo Registro
                    </button>
                    <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise"></i> Actualizar Lista
                    </button>
                </div>

                <div class="table-responsive">
                    <table class="table table-striped table-hover table-bordered" id="TableDetalleVentas"></table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/detalle_ventas/index.js') ?>"></script>