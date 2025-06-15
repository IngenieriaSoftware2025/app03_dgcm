<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-header bg-primary text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-person-lines-fill me-2"></i>
                    <span id="tituloFormulario">Registrar Cliente</span>
                </h4>
            </div>

            <div class="card-body p-3">
                <form id="FormCliente">
                    <input type="hidden" id="id_cliente" name="id_cliente">

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="nombres" class="form-label">Nombres</label>
                            <input type="text" class="form-control" id="nombres" name="nombres" placeholder="Ej: Juan Carlos">
                        </div>

                        <div class="col-lg-6">
                            <label for="apellidos" class="form-label">Apellidos</label>
                            <input type="text" class="form-control" id="apellidos" name="apellidos" placeholder="Ej: Pérez Gómez">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="telefono" class="form-label">Teléfono</label>
                            <input type="text" class="form-control" id="telefono" name="telefono" placeholder="Ej: 12345678">
                        </div>

                        <div class="col-lg-6">
                            <label for="celular" class="form-label">Celular</label>
                            <input type="text" class="form-control" id="celular" name="celular" placeholder="Ej: 98765432">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="nit" class="form-label">NIT</label>
                            <input type="text" class="form-control" id="nit" name="nit" placeholder="Ej: CF o 1234567-8">
                        </div>

                        <div class="col-lg-6">
                            <label for="correo" class="form-label">Correo</label>
                            <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@correo.com">
                        </div>
                    </div>

                    <div class="row mb-3">
                        <div class="col-lg-12">
                            <label for="direccion" class="form-label">Dirección</label>
                            <textarea class="form-control" id="direccion" name="direccion" placeholder="Dirección completa"></textarea>
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
                            <button type="button" id="BtnVerClientes" class="btn btn-info">
                                <i class="bi bi-card-list me-1"></i> Ver Clientes
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
                <h4 class="mb-0"><i class="bi bi-people-fill me-2"></i> Clientes Registrados</h4>
            </div>
            <div class="card-body p-3">
                <div class="row justify-content-between mb-3">
                    <div class="col-auto">
                        <button type="button" id="BtnCrearCliente" class="btn btn-success">
                            <i class="bi bi-plus-circle me-1"></i> Crear Nuevo Cliente
                        </button>
                    </div>

                    <div class="col-auto">
                        <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Lista
                        </button>
                    </div>
                </div>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableClientes">
                        <!-- DataTable generado por JS -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/clientes/index.js') ?>"></script>