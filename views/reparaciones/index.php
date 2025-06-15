<!-- SECCIÓN DEL FORMULARIO (Vista 1) -->
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
                <div class="row mb-3">
                    <h5 class="text-center mb-2">¡Bienvenido a la Aplicación para el registro, modificación y eliminación de reparaciones!</h5>
                    <h4 class="text-center mb-2 text-primary">Manipulación de reparaciones</h4>
                </div>

                <div class="row justify-content-center p-5 shadow-lg">
                    <form id="FormReparaciones">
                        <input type="hidden" id="id_reparacion" name="id_reparacion">

                        <!-- Cliente y Celular -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="id_cliente" class="form-label">Cliente</label>
                                <select class="form-control" id="id_cliente" name="id_cliente">
                                    <option value="">Seleccione un cliente</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="id_celular" class="form-label">Celular</label>
                                <select class="form-control" id="id_celular" name="id_celular">
                                    <option value="">Seleccione un celular</option>
                                </select>
                            </div>
                        </div>

                        <!-- IMEI y Empleado -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="imei" class="form-label">IMEI</label>
                                <input type="text" class="form-control" id="imei" name="imei" placeholder="Ingrese el IMEI del dispositivo">
                            </div>
                            <div class="col-lg-6">
                                <label for="id_empleado_asignado" class="form-label">Empleado Asignado</label>
                                <select class="form-control" id="id_empleado_asignado" name="id_empleado_asignado">
                                    <option value="">Seleccione un empleado</option>
                                </select>
                            </div>
                        </div>

                        <!-- Tipo de Servicio -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="id_tipo_servicio" class="form-label">Tipo de Servicio</label>
                                <select class="form-control" id="id_tipo_servicio" name="id_tipo_servicio">
                                    <option value="">Seleccione un tipo de servicio</option>
                                </select>
                            </div>
                            <div class="col-lg-6">
                                <label for="estado" class="form-label">Estado</label>
                                <select class="form-control" id="estado" name="estado">
                                    <option value="Ingresado">Ingresado</option>
                                    <option value="Asignado">Asignado</option>
                                    <option value="En_Proceso">En Proceso</option>
                                    <option value="Terminado">Terminado</option>
                                    <option value="Entregado">Entregado</option>
                                    <option value="Cancelado">Cancelado</option>
                                </select>
                            </div>
                        </div>

                        <!-- Prioridad -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="prioridad" class="form-label">Prioridad</label>
                                <select class="form-control" id="prioridad" name="prioridad">
                                    <option value="Normal">Normal</option>
                                    <option value="Alta">Alta</option>
                                    <option value="Baja">Baja</option>
                                </select>
                            </div>
                        </div>

                        <!-- Motivo -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-12">
                                <label for="motivo" class="form-label">Motivo de Ingreso</label>
                                <textarea class="form-control" id="motivo" name="motivo" rows="3" placeholder="Describa el motivo de la reparación (mínimo 10 caracteres)"></textarea>
                            </div>
                        </div>

                        <!-- Diagnóstico y Solución -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-6">
                                <label for="diagnostico" class="form-label">Diagnóstico</label>
                                <textarea class="form-control" id="diagnostico" name="diagnostico" rows="3" placeholder="Describa el diagnóstico"></textarea>
                            </div>
                            <div class="col-lg-6">
                                <label for="solucion" class="form-label">Solución</label>
                                <textarea class="form-control" id="solucion" name="solucion" rows="3" placeholder="Describa la solución aplicada"></textarea>
                            </div>
                        </div>

                        <!-- Costos -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-4">
                                <label for="costo_servicio" class="form-label">Costo de Servicio</label>
                                <input type="number" step="0.01" class="form-control" id="costo_servicio" name="costo_servicio" placeholder="0.00">
                            </div>
                            <div class="col-lg-4">
                                <label for="costo_repuestos" class="form-label">Costo de Repuestos</label>
                                <input type="number" step="0.01" class="form-control" id="costo_repuestos" name="costo_repuestos" placeholder="0.00">
                            </div>
                            <div class="col-lg-4">
                                <label for="total_cobrado" class="form-label">Total Cobrado</label>
                                <input type="number" step="0.01" class="form-control" id="total_cobrado" name="total_cobrado" placeholder="0.00">
                            </div>
                        </div>

                        <!-- Observaciones -->
                        <div class="row mb-3 justify-content-center">
                            <div class="col-lg-12">
                                <label for="observaciones" class="form-label">Observaciones</label>
                                <textarea class="form-control" id="observaciones" name="observaciones" rows="2" placeholder="Observaciones adicionales"></textarea>
                            </div>
                        </div>

                    </form>
                </div>

                <!-- BOTONES DEL FORMULARIO -->
                <div class="row justify-content-between mt-4 px-5">
                    <!-- Botones de acción del formulario -->
                    <div class="col-auto">
                        <button class="btn btn-success" type="submit" form="FormReparaciones" id="BtnGuardar">
                            <i class="bi bi-wrench-adjustable-circle-fill me-1"></i> Guardar
                        </button>
                        <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                            <i class="bi bi-pen me-1"></i> Modificar
                        </button>
                        <button class="btn btn-secondary ms-2" type="reset" id="BtnLimpiar">
                            <i class="bi bi-arrow-clockwise me-1"></i> Limpiar
                        </button>
                    </div>

                    <!-- BOTÓN PARA VER REPARACIONES -->
                    <div class="col-auto">
                        <button type="button" id="BtnVerReparaciones" class="btn btn-info">
                            <i class="bi bi-tools me-1"></i> Ver Reparaciones Registradas
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- SECCIÓN DE LA TABLA (Vista 2) - OCULTA POR DEFECTO -->
<div id="seccionTabla" class="row justify-content-center p-3 d-none">
    <div class="col-lg-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #17a2b8;">
            <div class="card-header bg-info text-white text-center">
                <h4 class="mb-0">
                    <i class="bi bi-tools me-2"></i>
                    Reparaciones Registradas
                </h4>
            </div>
            <div class="card-body p-3">

                <!-- BOTONES DE LA TABLA -->
                <div class="row justify-content-between mb-3">
                    <!-- BOTÓN PARA CREAR NUEVA -->
                    <div class="col-auto">
                        <button type="button" id="BtnCrearReparacion" class="btn btn-success">
                            <i class="bi bi-wrench-adjustable-circle-fill me-1"></i> Crear Nueva Reparación
                        </button>
                    </div>

                    <!-- BOTÓN PARA ACTUALIZAR -->
                    <div class="col-auto">
                        <button type="button" id="BtnActualizarTabla" class="btn btn-outline-primary">
                            <i class="bi bi-arrow-clockwise me-1"></i> Actualizar Lista
                        </button>
                    </div>
                </div>

                <!-- TABLA -->
                <div class="table-responsive p-2">
                    <table class="table table-striped table-hover table-bordered w-100 table-sm" id="TableReparaciones">
                        <!-- DataTable se genera automáticamente -->
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/reparaciones/index.js') ?>"></script>