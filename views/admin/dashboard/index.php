<?php
// ARCHIVO: views/admin/dashboard/index.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<div class="container-fluid p-4">
    <!-- Encabezado del Dashboard -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white mb-4 shadow">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-8">
                            <h2><i class="bi bi-shield-fill-check me-2"></i>Panel de Administración</h2>
                            <p class="mb-0">
                                Bienvenido, <strong><?= htmlspecialchars($_SESSION['user']['nombre1'] . ' ' . $_SESSION['user']['apellido1']) ?></strong>
                                <br><small>Último acceso: <?= date('d/m/Y H:i') ?></small>
                            </p>
                        </div>
                        <div class="col-md-4 text-end">
                            <div class="btn-group">
                                <a href="/app03_dgcm/empleado" class="btn btn-light btn-sm">
                                    <i class="bi bi-eye me-1"></i>Ver como Empleado
                                </a>
                                <a href="/app03_dgcm/tienda" class="btn btn-outline-light btn-sm">
                                    <i class="bi bi-shop me-1"></i>Ver Tienda
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Métricas Principales -->
    <div class="row g-3 mb-4">
        <div class="col-md-3">
            <div class="card bg-success text-white h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Usuarios</h5>
                        <h2 class="card-text"><?= $usuariosCount ?? 0 ?></h2>
                        <small>Total registrados</small>
                    </div>
                    <i class="bi bi-people-fill display-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Ventas Hoy</h5>
                        <h2 class="card-text">Q.<?= number_format($ventasHoy ?? 0, 0) ?></h2>
                        <small><?= $cantidadVentasHoy ?? 0 ?> transacciones</small>
                    </div>
                    <i class="bi bi-cash-coin display-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Inventario</h5>
                        <h2 class="card-text"><?= $inventarioCount ?? 0 ?></h2>
                        <small><?= $stockBajo ?? 0 ?> con stock bajo</small>
                    </div>
                    <i class="bi bi-box-seam display-4"></i>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white h-100 shadow-sm">
                <div class="card-body d-flex justify-content-between align-items-center">
                    <div>
                        <h5 class="card-title mb-1">Reparaciones</h5>
                        <h2 class="card-text"><?= $reparacionesPendientes ?? 0 ?></h2>
                        <small>Pendientes</small>
                    </div>
                    <i class="bi bi-tools display-4"></i>
                </div>
            </div>
        </div>
    </div>

    <!-- Gráficos y Estadísticas -->
    <div class="row mb-4">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-graph-up me-2"></i>Ventas Últimos 30 Días</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartVentas" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-pie-chart me-2"></i>Ventas por Categoría</h5>
                </div>
                <div class="card-body">
                    <canvas id="chartCategorias" width="300" height="300"></canvas>
                </div>
            </div>
        </div>
    </div>

    <!-- Actividad Reciente y Alertas -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-clock-history me-2"></i>Actividad Reciente</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php if (!empty($actividadReciente)): ?>
                            <?php foreach (array_slice($actividadReciente, 0, 8) as $actividad): ?>
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex justify-content-between align-items-start">
                                        <div>
                                            <p class="mb-1"><?= htmlspecialchars($actividad['descripcion']) ?></p>
                                            <small class="text-muted">
                                                <i class="bi bi-person me-1"></i><?= htmlspecialchars($actividad['usuario']) ?>
                                            </small>
                                        </div>
                                        <small class="text-muted"><?= $actividad['tiempo'] ?></small>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">No hay actividad reciente</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-exclamation-triangle me-2"></i>Alertas del Sistema</h5>
                </div>
                <div class="card-body">
                    <div class="list-group list-group-flush">
                        <?php if (!empty($alertasSistema)): ?>
                            <?php foreach ($alertasSistema as $alerta): ?>
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex align-items-center">
                                        <i class="bi bi-<?= $alerta['icono'] ?> text-<?= $alerta['tipo'] ?> me-3"></i>
                                        <div>
                                            <p class="mb-1"><?= htmlspecialchars($alerta['mensaje']) ?></p>
                                            <small class="text-muted"><?= $alerta['fecha'] ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <div class="text-center py-3">
                                <i class="bi bi-check-circle text-success display-4"></i>
                                <p class="text-muted mt-2">Sistema funcionando correctamente</p>
                            </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Accesos Rápidos -->
    <div class="row mt-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Accesos Rápidos</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-2">
                            <a href="/app03_dgcm/admin/usuarios" class="btn btn-outline-primary w-100">
                                <i class="bi bi-people-fill d-block mb-1"></i>
                                <small>Usuarios</small>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="/app03_dgcm/admin/celulares" class="btn btn-outline-success w-100">
                                <i class="bi bi-phone d-block mb-1"></i>
                                <small>Inventario</small>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="/app03_dgcm/admin/ventas" class="btn btn-outline-warning w-100">
                                <i class="bi bi-cash-coin d-block mb-1"></i>
                                <small>Ventas</small>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="/app03_dgcm/admin/reparaciones" class="btn btn-outline-info w-100">
                                <i class="bi bi-tools d-block mb-1"></i>
                                <small>Reparaciones</small>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="/app03_dgcm/admin/estadisticas" class="btn btn-outline-danger w-100">
                                <i class="bi bi-graph-up d-block mb-1"></i>
                                <small>Reportes</small>
                            </a>
                        </div>
                        <div class="col-md-2">
                            <a href="/app03_dgcm/admin/configuracion" class="btn btn-outline-secondary w-100">
                                <i class="bi bi-gear d-block mb-1"></i>
                                <small>Configuración</small>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/admin/dashboard.js') ?>"></script>