<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-tags-fill me-2"></i>
                    <span id="tituloFormulario">Registrar Marca</span>
                </h4>
            </div>

            <div class="card-body p-3">
                <form id="FormMarca">
                    <input type="hidden" id="id_marca" name="id_marca">

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="nombre_marca" class="form-label">Nombre de la Marca</label>
                            <input type="text" class="form-control" id="nombre_marca" name="nombre_marca" placeholder="Ej: Samsung, Apple, Huawei">
                        </div>

                        <div class="col-lg-6">
                            <label for="pais_origen" class="form-label">País de Origen</label>
                            <input type="text" class="form-control" id="pais_origen" name="pais_origen" placeholder="Ej: Corea del Sur, Estados Unidos">
                        </div>
                    </div>

                    <div class="row justify-content-center mt-4">
                        <div class="col-auto">
                            <button class="btn btn-success" type="submit" id="BtnGuardar">
                                <i class="bi bi-save me-1"></i> Guardar
                            </button>

                            <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                                <i class="bi bi-pencil-square me-1"></i> Modificar
                            </button>

                            <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiar">
                                <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                            </button>
                        </div>

                        <div class="col-auto">
                            <button type="button" id="BtnVerMarcas" class="btn btn-info">
                                <i class="bi bi-card-list me-1"></i> Ver Marcas Registradas
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Tabla -->
<div id="seccionTabla" class="row justify-content-center p-3 d-none">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #17a2b8;">
            <div class="card-header bg-info text-white text-center">
                <h4 class="mb-0"><i class="bi bi-tags-fill me-2"></i> Marcas Registradas</h4>
            </div>
            <div class="card-body p-3">
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <button type="button" id="BtnCrearMarca" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Crear Nueva Marca
                        </button>
                    </div>

                    <div class="col-auto">
                        <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Lista
                        </button>
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableMarcas">
                        <!-- DataTable generado por JS -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/marcas/index.js') ?>"></script>