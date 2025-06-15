<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-8">
        <div class="card shadow-lg border-primary">
            <div class="card-header bg-primary text-white text-center">
                <h4><i class="bi bi-tools me-2"></i> <span id="tituloFormulario">Registrar Tipo de Servicio</span></h4>
            </div>
            <div class="card-body">
                <form id="FormTipoServicio">
                    <input type="hidden" id="id_tipo_servicio" name="id_tipo_servicio">

                    <div class="mb-3">
                        <label for="descripcion" class="form-label">Descripción del Servicio</label>
                        <input type="text" class="form-control" id="descripcion" name="descripcion" placeholder="Ej. Cambio de pantalla, formateo, etc.">
                    </div>

                    <div class="mb-3">
                        <label for="precio_base" class="form-label">Precio Base</label>
                        <input type="number" class="form-control" id="precio_base" name="precio_base" placeholder="Q.0.00">
                    </div>

                    <div class="mb-3">
                        <label for="tiempo_estimado" class="form-label">Tiempo Estimado (Horas)</label>
                        <input type="number" class="form-control" id="tiempo_estimado" name="tiempo_estimado" placeholder="Horas estimadas de reparación">
                    </div>

                    <div class="mb-3">
                        <label for="categoria" class="form-label">Categoría</label>
                        <input type="text" class="form-control" id="categoria" name="categoria" placeholder="Ej. Pantalla, Hardware, Software">
                    </div>

                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success" id="BtnGuardar">
                                <i class="bi bi-save me-1"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-warning d-none" id="BtnModificar">
                                <i class="bi bi-pencil-square me-1"></i> Modificar
                            </button>
                            <button type="reset" class="btn btn-secondary" id="BtnLimpiar">
                                <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                            </button>
                        </div>
                        <div>
                            <button type="button" id="BtnVerLista" class="btn btn-info">
                                <i class="bi bi-list-ul me-1"></i> Ver Servicios
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
                <h4><i class="bi bi-list-ul me-2"></i> Tipos de Servicios Registrados</h4>
            </div>
            <div class="card-body">
                <div class="mb-3 d-flex justify-content-between">
                    <button type="button" id="BtnNuevo" class="btn btn-success">
                        <i class="bi bi-plus-circle me-1"></i> Nuevo Servicio
                    </button>
                    <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                        <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Lista
                    </button>
                </div>
                <div class="table-responsive">
                    <table class="table table-bordered table-hover table-striped w-100 table-sm" id="TableServicios"></table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/tipos_servicios/index.js') ?>"></script>