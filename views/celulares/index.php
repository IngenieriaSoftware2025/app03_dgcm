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

                    <!-- Marca y Modelo -->
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="id_marca" class="form-label">Marca</label>
                            <select id="id_marca" name="id_marca" class="form-select" required>
                                <option value="">Seleccione una marca</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="modelo" class="form-label">Modelo</label>
                            <input type="text" class="form-control" id="modelo" name="modelo" required placeholder="Ej: Galaxy S23, iPhone 15">
                        </div>
                    </div>

                    <!-- Precios -->
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="precio_compra" class="form-label">Precio de Compra</label>
                            <div class="input-group">
                                <span class="input-group-text">Q.</span>
                                <input type="number" class="form-control" id="precio_compra" name="precio_compra"
                                    step="0.01" min="0" required placeholder="0.00">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <label for="precio_venta" class="form-label">Precio de Venta</label>
                            <div class="input-group">
                                <span class="input-group-text">Q.</span>
                                <input type="number" class="form-control" id="precio_venta" name="precio_venta"
                                    step="0.01" min="0" required placeholder="0.00">
                            </div>
                        </div>
                    </div>

                    <!-- Stock -->
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="stock_actual" class="form-label">Stock Actual</label>
                            <input type="number" class="form-control" id="stock_actual" name="stock_actual"
                                min="0" value="0" required>
                        </div>
                        <div class="col-lg-6">
                            <label for="stock_minimo" class="form-label">Stock Mínimo</label>
                            <input type="number" class="form-control" id="stock_minimo" name="stock_minimo"
                                min="1" value="5" required>
                        </div>
                    </div>

                    <!-- Características Técnicas -->
                    <div class="row mb-3">
                        <div class="col-lg-4">
                            <label for="color" class="form-label">Color</label>
                            <input type="text" class="form-control" id="color" name="color" placeholder="Ej: Negro, Blanco, Azul">
                        </div>
                        <div class="col-lg-4">
                            <label for="almacenamiento" class="form-label">Almacenamiento</label>
                            <select id="almacenamiento" name="almacenamiento" class="form-select">
                                <option value="">Seleccione</option>
                                <option value="32GB">32GB</option>
                                <option value="64GB">64GB</option>
                                <option value="128GB">128GB</option>
                                <option value="256GB">256GB</option>
                                <option value="512GB">512GB</option>
                                <option value="1TB">1TB</option>
                            </select>
                        </div>
                        <div class="col-lg-4">
                            <label for="ram" class="form-label">RAM</label>
                            <select id="ram" name="ram" class="form-select">
                                <option value="">Seleccione</option>
                                <option value="2GB">2GB</option>
                                <option value="3GB">3GB</option>
                                <option value="4GB">4GB</option>
                                <option value="6GB">6GB</option>
                                <option value="8GB">8GB</option>
                                <option value="12GB">12GB</option>
                                <option value="16GB">16GB</option>
                            </select>
                        </div>
                    </div>

                    <!-- Estado y Fecha -->
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="estado" class="form-label">Estado</label>
                            <select id="estado" name="estado" class="form-select">
                                <option value="Nuevo">Nuevo</option>
                                <option value="Usado">Usado</option>
                                <option value="Reacondicionado">Reacondicionado</option>
                                <option value="Dañado">Dañado</option>
                            </select>
                        </div>
                        <div class="col-lg-6">
                            <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso"
                                value="<?= date('Y-m-d') ?>">
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