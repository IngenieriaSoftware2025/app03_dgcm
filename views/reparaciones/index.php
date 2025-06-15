<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-wrench-adjustable-circle me-2"></i>
                    <span id="tituloFormulario">Registrar Reparación</span>
                </h4>
            </div>
            <div class="card-body p-3">

                <form id="FormReparacion">
                    <input type="hidden" id="id_reparacion" name="id_reparacion">

                    <!-- Cliente -->
                    <div class="mb-3">
                        <label for="id_cliente" class="form-label">Cliente</label>
                        <select id="id_cliente" name="id_cliente" class="form-select"></select>
                    </div>

                    <!-- Datos del celular -->
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="tipo_celular" class="form-label">Tipo de Celular</label>
                            <input type="text" class="form-control" id="tipo_celular" name="tipo_celular">
                        </div>
                        <div class="col-lg-6">
                            <label for="marca_celular" class="form-label">Marca</label>
                            <input type="text" class="form-control" id="marca_celular" name="marca_celular">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="modelo_celular" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo_celular" name="modelo_celular">
                        </div>
                        <div class="col-lg-6">
                            <label for="imei" class="form-label">IMEI</label>
                            <input type="text" class="form-control" id="imei" name="imei">
                        </div>
                    </div>

                    <!-- Servicio y motivo -->
                    <div class="mb-3">
                        <label for="id_tipo_servicio" class="form-label">Tipo de Servicio</label>
                        <select id="id_tipo_servicio" name="id_tipo_servicio" class="form-select"></select>
                    </div>

                    <div class="mb-3">
                        <label for="motivo" class="form-label">Motivo de Ingreso</label>
                        <textarea id="motivo" name="motivo" rows="3" class="form-control"></textarea>
                    </div>

                    <!-- Opciones -->
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success" id="BtnGuardar">
                                <i class="bi bi-floppy-fill me-1"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-warning d-none" id="BtnModificar">
                                <i class="bi bi-pencil-fill me-1"></i> Modificar
                            </button>
                            <button type="reset" class="btn btn-secondary ms-2" id="BtnLimpiar">
                                <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                            </button>
                        </div>

                        <div>
                            <button type="button" id="BtnVerLista" class="btn btn-info">
                                <i class="bi bi-list-check me-1"></i> Ver Reparaciones
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
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #17a2b8;">
            <div class="card-header bg-info text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-tools me-2"></i> Reparaciones Registradas
                </h4>
            </div>
            <div class="card-body p-3">

                <div class="d-flex justify-content-between mb-3">
                    <button type="button" id="BtnNuevo" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Nueva Reparación
                    </button>

                    <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                    </button>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableReparaciones">
                        <!-- DataTable -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/reparaciones/index.js') ?>"></script>