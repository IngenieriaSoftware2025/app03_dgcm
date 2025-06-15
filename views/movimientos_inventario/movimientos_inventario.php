<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card shadow-lg border-primary">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-boxes me-2"></i> Registro de Movimientos de Inventario
                </h4>
            </div>
            <div class="card-body">
                <form id="FormMovimientoInventario">
                    <input type="hidden" id="id_movimiento" name="id_movimiento">

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Celular:</label>
                            <select id="id_celular" name="id_celular" class="form-select"></select>
                        </div>
                        <div class="col-md-6">
                            <label>Empleado:</label>
                            <select id="id_empleado" name="id_empleado" class="form-select"></select>
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-4">
                            <label>Tipo Movimiento:</label>
                            <select id="tipo_movimiento" name="tipo_movimiento" class="form-select">
                                <option value="">Seleccione</option>
                                <option value="Entrada">Entrada</option>
                                <option value="Salida">Salida</option>
                                <option value="Ajuste">Ajuste</option>
                                <option value="Venta">Venta</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <label>Cantidad:</label>
                            <input type="number" id="cantidad" name="cantidad" class="form-control">
                        </div>
                        <div class="col-md-4">
                            <label>Referencia:</label>
                            <input type="text" id="referencia" name="referencia" class="form-control">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label>Motivo:</label>
                            <textarea id="motivo" name="motivo" class="form-control" rows="2"></textarea>
                        </div>
                    </div>

                    <div class="text-center">
                        <button type="submit" id="BtnGuardar" class="btn btn-success">
                            <i class="bi bi-save me-1"></i> Guardar
                        </button>

                        <button type="button" id="BtnModificar" class="btn btn-warning d-none">
                            <i class="bi bi-pencil-square me-1"></i> Modificar
                        </button>

                        <button type="reset" id="BtnLimpiar" class="btn btn-secondary">
                            <i class="bi bi-eraser-fill me-1"></i> Limpiar
                        </button>

                        <button type="button" id="BtnVerLista" class="btn btn-info">
                            <i class="bi bi-list-ul me-1"></i> Ver Movimientos
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center p-3 d-none" id="seccionTabla">
    <div class="col-lg-10">
        <div class="card shadow-lg border-info">
            <div class="card-header bg-info text-white text-center">
                <h4><i class="bi bi-clock-history me-2"></i> Movimientos Registrados</h4>
            </div>
            <div class="card-body">
                <div class="d-flex justify-content-end mb-3">
                    <button id="BtnNuevo" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo Movimiento
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="TableMovimientos" class="table table-bordered table-striped table-hover w-100"></table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/movimientos_inventario/index.js') ?>"></script>