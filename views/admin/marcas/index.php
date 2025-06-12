<?php
// ARCHIVO: views/admin/marcas/index.php
?>
<!-- SECCIÓN DEL FORMULARIO -->
<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-tags-fill me-2"></i>
                    <span id="tituloFormulario">Gestión de Marcas</span>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Panel de Administrador - Gestión Completa de Marcas!</h5>
                    <h4 class="text-center mb-2 text-primary">Administración de Marcas de Celulares</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormMarcas">
                        <input type="hidden" id="id_marca" name="id_marca">

                        <!-- Información de la marca -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-8">
                                <label for="marca_nombre" class="form-label">
                                    <i class="bi bi-tag-fill me-1"></i>Nombre de la Marca
                                </label>
                                <input type="text" class="form-control" id="marca_nombre" name="marca_nombre"
                                    placeholder="Ej: Samsung, Apple, Xiaomi..." required>
                            </div>
                            <div class="col-lg-4">
                                <label for="situacion" class="form-label">
                                    <i class="bi bi-toggle-on me-1"></i>Estado
                                </label>
                                <select class="form-select" id="situacion" name="situacion">
                                    <option value="1">Activa</option>
                                    <option value="0">Inactiva</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- BOTONES DEL FORMULARIO -->
                <div class="row justify-content-between mt-4 px-5">
                    <div class="col-auto">
                        <button class="btn btn-success" type="submit" form="FormMarcas" id="BtnGuardar">
                            <i class="bi bi-tag-fill me-1"></i> Guardar Marca
                        </button>
                        <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                            <i class="bi bi-pen me-1"></i> Modificar
                        </button>
                        <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiar">
                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                        </button>
                    </div>

                    <div class="col-auto">
                        <button type="button" id="BtnVerMarcas" class="btn btn-info">
                            <i class="bi bi-tags me-1"></i> Ver Marcas del Sistema
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SECCIÓN DE LA TABLA -->
<div id="seccionTabla" class="row justify-content-center p-3 d-none">
    <div class="col-lg-10">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #17a2b8;">
            <div class="card-header bg-info text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-tags me-2"></i>
                    Marcas del Sistema
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <button type="button" id="BtnCrearMarca" class="btn btn-success">
                            <i class="bi bi-tag-fill me-1"></i> Crear Nueva Marca
                        </button>
                    </div>
                    <div class="col-auto">
                        <div class="btn-group" role="group">
                            <button type="button" class="btn btn-outline-success" id="BtnActivas">
                                <i class="bi bi-check-circle me-1"></i> Activas
                            </button>
                            <button type="button" class="btn btn-outline-secondary" id="BtnInactivas">
                                <i class="bi bi-x-circle me-1"></i> Inactivas
                            </button>
                            <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                                <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                            </button>
                        </div>
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableMarcas">
                        <!-- DataTable se genera automáticamente -->
                    </table>
                </div>

                <!-- Estadísticas de Marcas -->
                <div class="row mt-3">
                    <div class="col-12">
                        <div class="card bg-light">
                            <div class="card-body">
                                <h6 class="fw-bold mb-3">Estadísticas de Marcas</h6>
                                <div class="row text-center">
                                    <div class="col-md-3">
                                        <h5 class="text-primary" id="totalMarcas">0</h5>
                                        <small class="text-muted">Total Marcas</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-success" id="marcasActivas">0</h5>
                                        <small class="text-muted">Activas</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-warning" id="marcasConProductos">0</h5>
                                        <small class="text-muted">Con Productos</small>
                                    </div>
                                    <div class="col-md-3">
                                        <h5 class="text-info" id="marcasSinProductos">0</h5>
                                        <small class="text-muted">Sin Productos</small>
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

<script src="<?= asset('build/js/views/admin/marca/index.js') ?>"></script>