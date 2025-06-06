<div class="row justify-content-center p-3">
    <div class="col-lg-8 col-md-10">
        <div class="card custom-card shadow-lg" style="border-radius: 10px; border: 1px solid #007bff;">
            <div class="card-body p-4">
                <div class="row mb-4">
                    <div class="col-12 text-center">
                        <i class="bi bi-person-plus-fill display-1 text-primary mb-3"></i>
                        <h3 class="text-primary mb-2">Registro de Usuario</h3>
                        <h6 class="text-muted">Complete la información para crear un nuevo usuario</h6>
                    </div>
                </div>

                <div class="row justify-content-center p-3">
                    <form id="FormRegistro">
                        <input type="hidden" id="id_usuario" name="id_usuario">

                        <!-- Nombres -->
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="nombre1" class="form-label">
                                    <i class="bi bi-person me-1"></i>Primer Nombre *
                                </label>
                                <input type="text" class="form-control" id="nombre1" name="nombre1" placeholder="Primer nombre" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="nombre2" class="form-label">
                                    <i class="bi bi-person me-1"></i>Segundo Nombre
                                </label>
                                <input type="text" class="form-control" id="nombre2" name="nombre2" placeholder="Segundo nombre (opcional)">
                            </div>
                        </div>

                        <!-- Apellidos -->
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="apellido1" class="form-label">
                                    <i class="bi bi-person me-1"></i>Primer Apellido *
                                </label>
                                <input type="text" class="form-control" id="apellido1" name="apellido1" placeholder="Primer apellido" required>
                            </div>
                            <div class="col-lg-6">
                                <label for="apellido2" class="form-label">
                                    <i class="bi bi-person me-1"></i>Segundo Apellido
                                </label>
                                <input type="text" class="form-control" id="apellido2" name="apellido2" placeholder="Segundo apellido (opcional)">
                            </div>
                        </div>

                        <!-- Información de contacto -->
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="telefono" class="form-label">
                                    <i class="bi bi-telephone me-1"></i>Teléfono
                                </label>
                                <input type="tel" class="form-control" id="telefono" name="telefono" placeholder="Número de teléfono">
                            </div>
                            <div class="col-lg-6">
                                <label for="dpi" class="form-label">
                                    <i class="bi bi-card-text me-1"></i>DPI
                                </label>
                                <input type="number" class="form-control" id="dpi" name="dpi" placeholder="Número de DPI">
                            </div>
                        </div>

                        <!-- Correo -->
                        <div class="row mb-3">
                            <div class="col-12">
                                <label for="correo" class="form-label">
                                    <i class="bi bi-envelope me-1"></i>Correo Electrónico *
                                </label>
                                <input type="email" class="form-control" id="correo" name="correo" placeholder="ejemplo@gmail.com" required>
                            </div>
                        </div>

                        <!-- Contraseña -->
                        <div class="row mb-3">
                            <div class="col-lg-6">
                                <label for="usuario_clave" class="form-label">
                                    <i class="bi bi-lock me-1"></i>Contraseña *
                                </label>
                                <div class="input-group">
                                    <input type="password" class="form-control" id="usuario_clave" name="usuario_clave" placeholder="Contraseña segura" required>
                                    <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                                        <i class="bi bi-eye" id="eyeIcon"></i>
                                    </button>
                                </div>
                                <small class="text-muted">Mínimo 10 caracteres</small>
                            </div>
                            <div class="col-lg-6">
                                <label for="confirmar_clave" class="form-label">
                                    <i class="bi bi-lock-fill me-1"></i>Confirmar Contraseña *
                                </label>
                                <input type="password" class="form-control" id="confirmar_clave" name="confirmar_clave" placeholder="Confirme la contraseña" required>
                            </div>
                        </div>

                        <!-- Fotografía -->
                        <div class="row mb-4">
                            <div class="col-12 text-center">
                                <label for="fotografia" class="form-label">
                                    <i class="bi bi-camera me-1"></i>Fotografía del Usuario
                                </label>
                                <div class="mb-3">
                                    <!-- Input de archivo -->
                                    <input type="file" class="form-control" id="fotografia" name="fotografia" accept="image/*" style="display: none;">
                                    <!-- Botones para manejo de imagen -->
                                    <div class="d-flex justify-content-center gap-2">
                                        <button type="button" class="btn btn-outline-primary btn-sm">
                                            <i class="bi bi-upload me-1"></i>Seleccionar
                                        </button>
                                        <button type="button" class="btn btn-outline-danger btn-sm" id="btnEliminarFoto">
                                            <i class="bi bi-trash me-1"></i>Eliminar
                                        </button>
                                    </div>
                                    <small class="text-muted d-block mt-2">
                                        Formatos permitidos: JPG, PNG, GIF. Tamaño máximo: 2MB
                                    </small>
                                </div>
                            </div>
                        </div>

                        <!-- Términos y condiciones -->
                        <div class="form-check d-flex justify-content-center mb-4">
                            <input class="form-check-input me-2" type="checkbox" value="" id="aceptarTerminos" required />
                            <label class="form-check-label" for="aceptarTerminos">
                                <i class="bi bi-shield-check me-1"></i>
                                Acepto los <a href="#!" class="text-decoration-none">Términos y Condiciones</a> del sistema
                            </label>
                        </div>

                        <!-- Botones -->
                        <div class="row justify-content-center mt-4">
                            <div class="col-auto">
                                <button class="btn btn-success" type="submit" id="BtnGuardar">
                                    <i class="bi bi-person-plus me-2"></i>Registrar Usuario
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-warning d-none" type="button" id="BtnModificar">
                                    <i class="bi bi-pen me-2"></i>Modificar Usuario
                                </button>
                            </div>

                            <div class="col-auto">
                                <button class="btn btn-secondary" type="reset" id="BtnLimpiar">
                                    <i class="bi bi-arrow-clockwise me-2"></i>Limpiar
                                </button>
                            </div>
                        </div>

                        <!-- Nota informativa -->
                        <div class="row mt-3">
                            <div class="col-12">
                                <div class="alert alert-info" role="alert">
                                    <i class="bi bi-info-circle me-2"></i>
                                    <strong>Nota:</strong> Los campos marcados con (*) son obligatorios.
                                    El usuario recibirá sus credenciales por correo electrónico.
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>


<script src="<?= asset('build/js/registro/index.js') ?>"></script>