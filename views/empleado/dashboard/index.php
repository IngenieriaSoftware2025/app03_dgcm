<?php
// ARCHIVO: views/empleado/dashboard/index.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<div class="row justify-content-center p-3">
    <div class="col-lg-12">
        <!-- Bienvenida -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-warning border-0 shadow-sm">
                    <h2><i class="bi bi-person-workspace me-2"></i>Panel de Empleado</h2>
                    <p class="mb-0">
                        Bienvenido/a, <strong><?= htmlspecialchars($_SESSION['user']['nombre1'] . ' ' . $_SESSION['user']['apellido1']) ?></strong>
                        <span class="badge bg-primary ms-2"><?= ucfirst($_SESSION['user']['rol']) ?></span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Panel de Resumen -->
        <div class="row g-3 mb-4">
            <div class="col-md-3">
                <div class="card bg-primary text-white h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-cash-coin display-4 mb-3"></i>
                        <h5 class="mt-2">Ventas Hoy</h5>
                        <p class="display-6 mb-0"><?= $ventasHoy ?? 0 ?></p>
                        <small>Ventas procesadas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-tools display-4 mb-3"></i>
                        <h5 class="mt-2">Reparaciones</h5>
                        <p class="display-6 mb-0"><?= $reparacionesAsignadas ?? 0 ?></p>
                        <small>Asignadas a mí</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-clock display-4 mb-3"></i>
                        <h5 class="mt-2">Pendientes</h5>
                        <p class="display-6 mb-0"><?= $reparacionesPendientes ?? 0 ?></p>
                        <small>Por completar</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white h-100 shadow">
                    <div class="card-body text-center">
                        <i class="bi bi-people display-4 mb-3"></i>
                        <h5 class="mt-2">Clientes</h5>
                        <p class="display-6 mb-0"><?= $clientesAtendidos ?? 0 ?></p>
                        <small>Atendidos hoy</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones Rápidas -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones Rápidas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="/app03_dgcm/empleado/ventas" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-cash-coin me-2"></i>Nueva Venta
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/app03_dgcm/empleado/reparaciones" class="btn btn-outline-success w-100">
                                    <i class="bi bi-tools me-2"></i>Gestionar Reparaciones
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/app03_dgcm/empleado/celulares" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-phone me-2"></i>Consultar Inventario
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/app03_dgcm/empleado/clientes" class="btn btn-outline-info w-100">
                                    <i class="bi bi-person-lines-fill me-2"></i>Buscar Cliente
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actividad Reciente -->
        <div class="row mt-4">
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Mis Últimas Ventas</h6>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($ultimasVentas)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach (array_slice($ultimasVentas, 0, 5) as $venta): ?>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <div>
                                                <small class="text-muted"><?= date('H:i', strtotime($venta['fecha_venta'])) ?></small>
                                                <p class="mb-0"><?= htmlspecialchars($venta['cliente_nombre'] ?? 'Cliente') ?></p>
                                                <small class="text-muted"><?= $venta['tipo'] === 'C' ? 'Celular' : 'Reparación' ?></small>
                                            </div>
                                            <span class="badge bg-success">Q.<?= number_format($venta['total'] ?? 0, 2) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">No hay ventas recientes</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-tools me-2"></i>Mis Reparaciones Activas</h6>
                    </div>
                    <div class="card-body">
                        <?php if (!empty($reparacionesActivas)): ?>
                            <div class="list-group list-group-flush">
                                <?php foreach (array_slice($reparacionesActivas, 0, 5) as $reparacion): ?>
                                    <div class="list-group-item border-0 px-0">
                                        <div class="d-flex justify-content-between align-items-start">
                                            <div>
                                                <p class="mb-1"><?= htmlspecialchars($reparacion['motivo']) ?></p>
                                                <small class="text-muted"><?= htmlspecialchars($reparacion['cliente_nombre']) ?></small>
                                            </div>
                                            <span class="badge bg-<?=
                                                                    $reparacion['estado'] === 'Terminado' ? 'success' : ($reparacion['estado'] === 'En Proceso' ? 'warning' : 'info')
                                                                    ?>">
                                                <?= $reparacion['estado'] ?>
                                            </span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center py-3">No hay reparaciones asignadas</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>

        <!-- Estadísticas Personales -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Mi Rendimiento (Últimos 30 días)</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-md-3">
                                <h4 class="text-success"><?= $ventasMes ?? 0 ?></h4>
                                <small class="text-muted">Ventas Procesadas</small>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-primary">Q.<?= number_format($totalVentasMes ?? 0, 2) ?></h4>
                                <small class="text-muted">Total Vendido</small>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-warning"><?= $reparacionesCompletadas ?? 0 ?></h4>
                                <small class="text-muted">Reparaciones Completadas</small>
                            </div>
                            <div class="col-md-3">
                                <h4 class="text-info"><?= $clientesNuevos ?? 0 ?></h4>
                                <small class="text-muted">Clientes Nuevos</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/empleado/dashboard.js') ?>"></script>