<?php
// ARCHIVO: views/empleado/perfil/index.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/app03_dgcm/empleado">Dashboard</a></li>
            <li class="breadcrumb-item active">Mi Perfil</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Sidebar de Navegación -->
        <div class="col-md-3">
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0"><i class="bi bi-person-gear me-2"></i>Mi Perfil de Empleado</h6>
                </div>
                <div class="list-group list-group-flush">
                    <a href="#informacion" class="list-group-item list-group-item-action active" data-section="informacion">
                        <i class="bi bi-person me-2"></i>Información Personal
                    </a>
                    <a href="#configuracion" class="list-group-item list-group-item-action" data-section="configuracion">
                        <i class="bi bi-gear me-2"></i>Configuración
                    </a>
                    <a href="#seguridad" class="list-group-item list-group-item-action" data-section="seguridad">
                        <i class="bi bi-shield-lock me-2"></i>Seguridad
                    </a>
                    <a href="#estadisticas" class="list-group-item list-group-item-action" data-section="estadisticas">
                        <i class="bi bi-graph-up me-2"></i>Mis Estadísticas
                    </a>
                </div>
            </div>
        </div>

        <!-- Contenido Principal -->
        <div class="col-md-9">
            <!-- Sección: Información Personal -->
            <div id="seccion-informacion" class="content-section">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-person me-2"></i>Información Personal y Laboral</h5>
                    </div>
                    <div class="card-body">
                        <form id="FormPerfilEmpleado">
                            <!-- Información Personal -->
                            <h6 class="fw-bold text-primary mb-3">Datos Personales</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nombre1" class="form-label">Primer Nombre</label>
                                    <input type="text" class="form-control" id="nombre1" name="nombre1"
                                        value="<?= htmlspecialchars($_SESSION['user']['nombre1'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="apellido1" class="form-label">Primer Apellido</label>
                                    <input type="text" class="form-control" id="apellido1" name="apellido1"
                                        value="<?= htmlspecialchars($_SESSION['user']['apellido1'] ?? '') ?>">
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="telefono" class="form-label">Teléfono</label>
                                    <input type="text" class="form-control" id="telefono" name="telefono"
                                        value="<?= htmlspecialchars($_SESSION['user']['telefono'] ?? '') ?>">
                                </div>
                                <div class="col-md-6">
                                    <label for="correo" class="form-label">Correo Electrónico</label>
                                    <input type="email" class="form-control" id="correo" name="correo"
                                        value="<?= htmlspecialchars($_SESSION['user']['correo'] ?? '') ?>">
                                </div>
                            </div>

                            <!-- Información Laboral -->
                            <h6 class="fw-bold text-primary mb-3 mt-4">Datos Laborales</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="departamento" class="form-label">Departamento</label>
                                    <input type="text" class="form-control" id="departamento" name="departamento"
                                        value="<?= htmlspecialchars($empleado_info['departamento'] ?? 'Ventas') ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="puesto" class="form-label">Puesto</label>
                                    <input type="text" class="form-control" id="puesto" name="puesto"
                                        value="<?= htmlspecialchars($empleado_info['puesto'] ?? 'Empleado de Ventas') ?>" readonly>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="fecha_ingreso" class="form-label">Fecha de Ingreso</label>
                                    <input type="text" class="form-control" id="fecha_ingreso"
                                        value="<?= htmlspecialchars($empleado_info['fecha_ingreso'] ?? date('Y-m-d')) ?>" readonly>
                                </div>
                                <div class="col-md-6">
                                    <label for="rol" class="form-label">Rol en el Sistema</label>
                                    <input type="text" class="form-control" id="rol"
                                        value="<?= ucfirst($_SESSION['user']['rol'] ?? 'empleado') ?>" readonly>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Actualizar Información
                            </button>
                            <small class="text-muted d-block mt-2">
                                * Los datos laborales solo pueden ser modificados por un administrador
                            </small>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sección: Configuración -->
            <div id="seccion-configuracion" class="content-section d-none">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-gear me-2"></i>Configuración de Trabajo</h5>
                    </div>
                    <div class="card-body">
                        <form id="FormConfiguracionEmpleado">
                            <h6 class="fw-bold text-primary mb-3">Preferencias del Sistema</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="idioma" class="form-label">Idioma</label>
                                    <select class="form-select" id="idioma" name="idioma">
                                        <option value="es">Español</option>
                                        <option value="en">English</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="tema_preferido" class="form-label">Tema</label>
                                    <select class="form-select" id="tema_preferido" name="tema_preferido">
                                        <option value="claro">Claro</option>
                                        <option value="oscuro">Oscuro</option>
                                        <option value="auto">Automático</option>
                                    </select>
                                </div>
                            </div>

                            <h6 class="fw-bold text-primary mb-3">Notificaciones</h6>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notificaciones_email" name="notificaciones_email" checked>
                                        <label class="form-check-label" for="notificaciones_email">
                                            Recibir notificaciones por email
                                        </label>
                                    </div>
                                    <div class="form-check form-switch">
                                        <input class="form-check-input" type="checkbox" id="notificaciones_sms" name="notificaciones_sms">
                                        <label class="form-check-label" for="notificaciones_sms">
                                            Recibir notificaciones por SMS
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <h6 class="fw-bold text-primary mb-3">Configuración de Ventas</h6>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="metodo_pago_default" class="form-label">Método de Pago por Defecto</label>
                                    <select class="form-select" id="metodo_pago_default" name="metodo_pago_default">
                                        <option value="efectivo">Efectivo</option>
                                        <option value="tarjeta">Tarjeta</option>
                                        <option value="transferencia">Transferencia</option>
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label for="mostrar_stock" class="form-label">Mostrar Stock en Ventas</label>
                                    <select class="form-select" id="mostrar_stock" name="mostrar_stock">
                                        <option value="1">Sí, mostrar stock</option>
                                        <option value="0">No mostrar stock</option>
                                    </select>
                                </div>
                            </div>

                            <button type="submit" class="btn btn-primary">
                                <i class="bi bi-save me-1"></i>Guardar Configuración
                            </button>
                        </form>
                    </div>
                </div>
            </div>

            <!-- Sección: Seguridad -->
            <div id="seccion-seguridad" class="content-section d-none">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-shield-lock me-2"></i>Seguridad de la Cuenta</h5>
                    </div>
                    <div class="card-body">
                        <form id="FormSeguridadEmpleado">
                            <h6 class="fw-bold text-primary mb-3">Cambiar Contraseña</h6>
                            <div class="row mb-3">
                                <div class="col-12">
                                    <label for="clave_actual" class="form-label">Contraseña Actual</label>
                                    <input type="password" class="form-control" id="clave_actual" name="clave_actual" required>
                                </div>
                            </div>
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <label for="nueva_clave" class="form-label">Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="nueva_clave" name="nueva_clave" required>
                                </div>
                                <div class="col-md-6">
                                    <label for="confirmar_nueva_clave" class="form-label">Confirmar Nueva Contraseña</label>
                                    <input type="password" class="form-control" id="confirmar_nueva_clave" name="confirmar_nueva_clave" required>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-warning">
                                <i class="bi bi-key me-1"></i>Cambiar Contraseña
                            </button>
                        </form>

                        <hr class="my-4">

                        <h6 class="fw-bold text-primary mb-3">Sesiones Activas</h6>
                        <div class="table-responsive">
                            <table class="table table-sm">
                                <thead>
                                    <tr>
                                        <th>Dispositivo</th>
                                        <th>Última Actividad</th>
                                        <th>IP</th>
                                        <th>Estado</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td><i class="bi bi-laptop me-1"></i> Navegador Escritorio</td>
                                        <td>Ahora</td>
                                        <td>192.168.1.100</td>
                                        <td><span class="badge bg-success">Actual</span></td>
                                    </tr>
                                    <!-- Más sesiones se cargan dinámicamente -->
                                </tbody>
                            </table>
                        </div>

                        <div class="alert alert-warning mt-3">
                            <i class="bi bi-exclamation-triangle me-2"></i>
                            <strong>Importante:</strong> Si detectas actividad sospechosa, cambia tu contraseña inmediatamente y contacta al administrador.
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sección: Estadísticas -->
            <div id="seccion-estadisticas" class="content-section d-none">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Mis Estadísticas de Trabajo</h5>
                    </div>
                    <div class="card-body">
                        <!-- Resumen General -->
                        <div class="row mb-4">
                            <div class="col-md-3">
                                <div class="card bg-primary text-white text-center">
                                    <div class="card-body">
                                        <i class="bi bi-cash-coin display-6"></i>
                                        <h4><?= $estadisticas['ventas_totales'] ?? 0 ?></h4>
                                        <small>Ventas Totales</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-success text-white text-center">
                                    <div class="card-body">
                                        <i class="bi bi-tools display-6"></i>
                                        <h4><?= $estadisticas['reparaciones_completadas'] ?? 0 ?></h4>
                                        <small>Reparaciones</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-warning text-dark text-center">
                                    <div class="card-body">
                                        <i class="bi bi-people display-6"></i>
                                        <h4><?= $estadisticas['clientes_atendidos'] ?? 0 ?></h4>
                                        <small>Clientes</small>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-3">
                                <div class="card bg-info text-white text-center">
                                    <div class="card-body">
                                        <i class="bi bi-currency-dollar display-6"></i>
                                        <h4>Q.<?= number_format($estadisticas['monto_vendido'] ?? 0, 0) ?></h4>
                                        <small>Total Vendido</small>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Gráfico de Rendimiento -->
                        <h6 class="fw-bold text-primary mb-3">Rendimiento Mensual (Último Año)</h6>
                        <div class="row mb-4">
                            <div class="col-12">
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <canvas id="chartRendimiento" width="400" height="200"></canvas>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Comparación de Períodos -->
                        <div class="row mb-4">
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3">Este Mes</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-cash me-1"></i>Ventas procesadas:</span>
                                        <strong class="text-primary"><?= $estadisticas['ventas_mes'] ?? 0 ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-tools me-1"></i>Reparaciones completadas:</span>
                                        <strong class="text-success"><?= $estadisticas['reparaciones_mes'] ?? 0 ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-currency-dollar me-1"></i>Total vendido:</span>
                                        <strong class="text-info">Q.<?= number_format($estadisticas['monto_mes'] ?? 0, 2) ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-people me-1"></i>Clientes atendidos:</span>
                                        <strong class="text-warning"><?= $estadisticas['clientes_mes'] ?? 0 ?></strong>
                                    </li>
                                </ul>
                            </div>
                            <div class="col-md-6">
                                <h6 class="fw-bold text-primary mb-3">Esta Semana</h6>
                                <ul class="list-group list-group-flush">
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-cash me-1"></i>Ventas procesadas:</span>
                                        <strong class="text-primary"><?= $estadisticas['ventas_semana'] ?? 0 ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-tools me-1"></i>Reparaciones completadas:</span>
                                        <strong class="text-success"><?= $estadisticas['reparaciones_semana'] ?? 0 ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-currency-dollar me-1"></i>Total vendido:</span>
                                        <strong class="text-info">Q.<?= number_format($estadisticas['monto_semana'] ?? 0, 2) ?></strong>
                                    </li>
                                    <li class="list-group-item d-flex justify-content-between">
                                        <span><i class="bi bi-people me-1"></i>Clientes atendidos:</span>
                                        <strong class="text-warning"><?= $estadisticas['clientes_semana'] ?? 0 ?></strong>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <!-- Metas y Logros -->
                        <div class="row">
                            <div class="col-12">
                                <h6 class="fw-bold text-primary mb-3">Metas del Mes</h6>
                                <div class="card bg-light">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="small">Meta de Ventas</span>
                                                        <span class="small"><?= $estadisticas['ventas_mes'] ?? 0 ?>/<?= $estadisticas['meta_ventas'] ?? 50 ?></span>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-primary" style="width: <?= min(100, (($estadisticas['ventas_mes'] ?? 0) / ($estadisticas['meta_ventas'] ?? 50)) * 100) ?>%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="mb-3">
                                                    <div class="d-flex justify-content-between mb-1">
                                                        <span class="small">Meta de Reparaciones</span>
                                                        <span class="small"><?= $estadisticas['reparaciones_mes'] ?? 0 ?>/<?= $estadisticas['meta_reparaciones'] ?? 30 ?></span>
                                                    </div>
                                                    <div class="progress">
                                                        <div class="progress-bar bg-success" style="width: <?= min(100, (($estadisticas['reparaciones_mes'] ?? 0) / ($estadisticas['meta_reparaciones'] ?? 30)) * 100) ?>%"></div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Botón para Exportar Reporte -->
                        <div class="row mt-4">
                            <div class="col-12 text-center">
                                <button type="button" class="btn btn-outline-primary" id="btnExportarEstadisticas">
                                    <i class="bi bi-download me-1"></i>Descargar Reporte de Rendimiento
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/empleado/perfil.js') ?>"></script>