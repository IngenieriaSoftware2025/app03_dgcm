<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la Aplicación para la gestión de roles!</h5>
                    <h4 class="text-center mb-2 text-primary">Manipulación de roles</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormRoles">
                        <input type="hidden" id="id_rol" name="id_rol">

                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-8">
                                <label for="rol_nombre" class="form-label">Nombre del Rol</label>
                                <input type="text" class="form-control" id="rol_nombre" name="rol_nombre" placeholder="Ingrese el nombre del rol" required>
                            </div>
                        </div>

                        <div class="row justify-content-center mt-5">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">
                                    <i class="bi bi-shield-plus"></i> Guardar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                                    <i class="bi bi-pen"></i> Modificar
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                    <i class="bi bi-arrow-clockwise"></i> Limpiar
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-3">
                <h3 class="text-center">Roles existentes</h3>

                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableRoles">
                        <!-- JavaScript -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/roles/index.js') ?>"></script>