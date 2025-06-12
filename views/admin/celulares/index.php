<?php
// ARCHIVO: views/admin/celulares/index.php - VISTA ESTÁTICA PURA
?>

<!-- SECCIÓN DEL FORMULARIO -->
<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-phone me-2"></i>
                    <span id="tituloFormulario">Gestión de Inventario</span>
                </h4>
            </div>
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">Panel de Administrador - Gestión de Inventario</h5>
                    <h4 class="text-center mb-2 text-primary">Administrar Celulares</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormCelulares">
                        <input type="hidden" id="id_celular" name="id_celular">

                        <!-- Información del Producto -->
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="id_marca" class="form-label">Marca</label>
                                <select class="form-select" id="id_marca" name="id_marca" required>
                                    <option value="">-- Selecciona una marca --</option>
                                    <!-- Se carga dinámicamente desde JS -->
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="modelo" class="form-label">Modelo</label>
                                <input type="text" class="form-control" id="modelo" name="modelo"
                                    placeholder="Ej: Galaxy S24, iPhone 15..." required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-12">
                                <label for="descripcion" class="form-label">Descripción</label>
                                <textarea class="form-control" id="descripcion" name="descripcion" rows="3"
                                    placeholder="Descripción del celular..."></textarea>
                            </div>
                        </div>

                        <!-- Precios -->
                        <div class="row mb-3">
                            <div class="col-lg-4">
                                <label for="precio_compra" class="form-label">Precio de Compra</label>
                                <div class="input-group">
                                    <span class="input-group-text">Q.</span>
                                    <input type="number" step="0.01" class="form-control"
                                        id="precio_compra" name="precio_compra" min="0">
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="precio_venta" class="form-label">Precio de Venta</label>
                                <div class="input-group">
                                    <span class="input-group-text">Q.</span>
                                    <input type="number" step="0.01" class="form-control"
                                        id="precio_venta" name="precio_venta" min="0" required>
                                </div>
                            </div>
                            <div class="col-lg-4">
                                <label for="cantidad" class="form-label">Cantidad en Stock</label>
                                <input type="number" class="form-control" id="cantidad" name="cantidad"
                                    min="0" value="0" required>
                            </div>
                        </div>

                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="situacion" class="form-label">Estado</label>
                                <select class="form-select" id="situacion" name="situacion">
                                    <option value="1">Activo</option>
                                    <option value="0">Inactivo</option>
                                </select>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- BOTONES DEL FORMULARIO -->
                <div class="row justify-content-between mt-4 px-5">
                    <div class="col-auto">
                        <button class="btn btn-success" type="submit" form="FormCelulares" id="BtnGuardar">
                            <i class="bi bi-floppy me-1"></i> Guardar
                        </button>
                        <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                            <i class="bi bi-pen me-1"></i> Modificar
                        </button>
                        <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiar">
                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                        </button>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="BtnVerInventario" class="btn btn-info">
                            <i class="bi bi-table me-1"></i> Ver Inventario
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
                    <i class="bi bi-table me-2"></i>
                    Inventario de Celulares
                </h4>
            </div>
            <div class="card-body p-3">
                <!-- BOTONES DE LA TABLA -->
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <button type="button" id="BtnCrearCelular" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Nuevo Celular
                        </button>
                    </div>
                    <div class="col-auto">
                        <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                        </button>
                    </div>
                </div>

                <!-- TABLA -->
                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableCelulares">
                        <!-- DataTable se genera automáticamente desde JS -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/views/admin/celulares/index.js') ?>"></script>