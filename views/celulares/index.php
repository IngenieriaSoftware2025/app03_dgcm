<?php $pagina = "celulares"; ?>

<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-phone-fill me-2"></i>
                    <span id="tituloFormulario">Registrar Celular</span>
                </h4>
            </div>
            <div class="card-body p-3">

                <form id="FormCelulares">
                    <input type="hidden" id="id_celular" name="id_celular">

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="id_marca" class="form-label">Marca</label>
                            <select class="form-select" id="id_marca" name="id_marca">
                                <option value="">Seleccione la marca</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" placeholder="Modelo del celular">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label for="precio_compra" class="form-label">Precio Compra</label>
                            <input type="number" class="form-control" id="precio_compra" name="precio_compra">
                        </div>
                        <div class="col-lg-4">
                            <label for="precio_venta" class="form-label">Precio Venta</label>
                            <input type="number" class="form-control" id="precio_venta" name="precio_venta">
                        </div>
                        <div class="col-lg-4">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" class="form-control" id="color" name="color">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-3">
                            <label for="almacenamiento" class="form-label">Almacenamiento</label>
                            <input type="text" class="form-control" id="almacenamiento" name="almacenamiento" placeholder="64GB, 128GB">
                        </div>
                        <div class="col-lg-3">
                            <label for="ram" class="form-label">RAM</label>
                            <input type="text" class="form-control" id="ram" name="ram" placeholder="4GB, 6GB">
                        </div>
                        <div class="col-lg-3">
                            <label for="estado" class="form-label">Estado</label>
                            <select class="form-select" id="estado" name="estado">
                                <option value="Nuevo">Nuevo</option>
                                <option value="Usado">Usado</option>
                                <option value="Reacondicionado">Reacondicionado</option>
                            </select>
                        </div>
                        <div class="col-lg-3">
                            <label for="fecha_ingreso" class="form-label">Fecha Ingreso</label>
                            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso">
                        </div>
                    </div>

                    <div class="row justify-content-between mt-4 px-5">
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
                            <button type="button" id="BtnVerRegistros" class="btn btn-info">
                                <i class="bi bi-table me-1"></i> Ver Inventario
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
                    <i class="bi bi-phone me-2"></i>
                    Inventario de Celulares
                </h4>
            </div>
            <div class="card-body p-3">

                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <button type="button" id="BtnCrearNuevo" class="btn btn-success">
                            <i class="bi bi-plus-lg me-1"></i> Nuevo Celular
                        </button>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                        </button>
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableCelulares">
                        <!-- DataTable -->
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/celulares/index.js') ?>"></script>