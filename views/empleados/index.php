<div id="seccionFormulario" class="row justify-content-center p-3">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg">
            <div class="card-header bg-primary text-white text-center">
                <h4 id="tituloFormulario">Registrar Empleado</h4>
            </div>

            <div class="card-body p-3">
                <form id="FormEmpleados">
                    <input type="hidden" id="id_empleado" name="id_empleado">

                    <!-- USUARIO ASOCIADO -->
                    <div class="mb-3">
                        <label for="id_usuario" class="form-label">Seleccionar Usuario</label>
                        <select id="id_usuario" name="id_usuario" class="form-select">
                            <option value="">Seleccione...</option>
                        </select>
                    </div>

                    <!-- DATOS BÁSICOS -->
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="codigo_empleado" class="form-label">Código Empleado</label>
                            <input type="text" class="form-control" id="codigo_empleado" name="codigo_empleado" placeholder="Ingrese código único">
                        </div>
                        <div class="col-lg-6">
                            <label for="puesto" class="form-label">Puesto</label>
                            <input type="text" class="form-control" id="puesto" name="puesto" placeholder="Ingrese puesto">
                        </div>
                    </div>

                    <!-- SALARIO / FECHA -->
                    <div class="row mb-3">
                        <div class="col-lg-6">
                            <label for="salario" class="form-label">Salario</label>
                            <input type="number" class="form-control" id="salario" name="salario" step="0.01" placeholder="Q0.00">
                        </div>
                        <div class="col-lg-6">
                            <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                            <input type="date" class="form-control" id="fecha_ingreso" name="fecha_ingreso">
                        </div>
                    </div>

                    <!-- ESPECIALIDAD -->
                    <div class="mb-3">
                        <label for="especialidad" class="form-label">Especialidad</label>
                        <input type="text" class="form-control" id="especialidad" name="especialidad" placeholder="Reparaciones, Ventas, etc.">
                    </div>

                    <!-- BOTONES -->
                    <div class="d-flex justify-content-between">
                        <div>
                            <button type="submit" class="btn btn-success" id="BtnGuardar">
                                <i class="bi bi-person-fill-add me-1"></i> Guardar
                            </button>
                            <button type="button" class="btn btn-warning d-none" id="BtnModificar">
                                <i class="bi bi-pencil-square me-1"></i> Modificar
                            </button>
                            <button type="button" class="btn btn-secondary" id="BtnLimpiar">
                                <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                            </button>
                        </div>

                        <div>
                            <button type="button" class="btn btn-info" id="BtnVerRegistros">
                                <i class="bi bi-list-ul me-1"></i> Ver Registros
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
        <div class="card custom-card shadow-lg">
            <div class="card-header bg-info text-white text-center">
                <h4>Empleados Registrados</h4>
            </div>

            <div class="card-body p-3">

                <div class="d-flex justify-content-between mb-3">
                    <button class="btn btn-success" id="BtnCrearNuevo">
                        <i class="bi bi-person-plus-fill me-1"></i> Nuevo Registro
                    </button>

                    <button class="btn btn-outline-primary" id="BtnActualizarTabla">
                        <i class="bi bi-arrow-clockwise me-1"></i> Actualizar
                    </button>
                </div>

                <div class="table-responsive">
                    <table id="TableEmpleados" class="table table-striped table-hover table-bordered w-100 table-sm">
                        <!-- Se genera con DataTable -->
                    </table>
                </div>

            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/empleados/index.js') ?>"></script>