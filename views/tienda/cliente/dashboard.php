<?php

// ARCHIVO: views/tienda/cliente/dashboard.php

if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<div class="container">
    <!-- Bienvenida -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-success border-0 shadow-sm">
                <h2><i class="bi bi-person-heart me-2"></i>Mi Panel de Cliente</h2>
                <p class="mb-0">Bienvenido/a, <strong><?= htmlspecialchars($_SESSION['user']['nombre1'] . ' ' . $_SESSION['user']['apellido1']) ?></strong></p>
            </div>
        </div>
    </div>

    <!-- Resumen de Cuenta -->
    <div class="row g-4 mb-5">
        <div class="col-md-3">
            <div class="card bg-primary text-white h-100">
                <div class="card-body text-center">
                    <i class="bi bi-bag-check display-4 mb-3"></i>
                    <h5>Mis Pedidos</h5>
                    <p class="display-6 mb-0"><?= $totalPedidos ?? 0 ?></p>
                    <small>Pedidos realizados</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white h-100">
                <div class="card-body text-center">
                    <i class="bi bi-tools display-4 mb-3"></i>
                    <h5>Reparaciones</h5>
                    <p class="display-6 mb-0"><?= $totalReparaciones ?? 0 ?></p>
                    <small>Servicios técnicos</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-dark h-100">
                <div class="card-body text-center">
                    <i class="bi bi-clock display-4 mb-3"></i>
                    <h5>Pendientes</h5>
                    <p class="display-6 mb-0"><?= $reparacionesPendientes ?? 0 ?></p>
                    <small>En proceso</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white h-100">
                <div class="card-body text-center">
                    <i class="bi bi-credit-card display-4 mb-3"></i>
                    <h5>Total Gastado</h5>
                    <p class="display-6 mb-0">Q.<?= number_format($totalGastado ?? 0, 2) ?></p>
                    <small>Este año</small>
                </div>
            </div>
        </div>
    </div>

    <!-- Acciones Rápidas -->
    <div class="row mb-5">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones Rápidas</h5>
                </div>
                <div class="card-body">
                    <div class="row g-3">
                        <div class="col-md-3">
                            <a href="/app03_dgcm/tienda/productos" class="btn btn-outline-primary w-100">
                                <i class="bi bi-shop me-2"></i>Comprar Celulares
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="/app03_dgcm/tienda/mis-pedidos" class="btn btn-outline-success w-100">
                                <i class="bi bi-bag-check me-2"></i>Ver Mis Pedidos
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="/app03_dgcm/tienda/mi-perfil" class="btn btn-outline-warning w-100">
                                <i class="bi bi-person-gear me-2"></i>Editar Perfil
                            </a>
                        </div>
                        <div class="col-md-3">
                            <a href="/app03_dgcm/tienda/carrito" class="btn btn-outline-info w-100">
                                <i class="bi bi-cart3 me-2"></i>Mi Carrito
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Últimos Pedidos y Reparaciones -->
    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-clock-history me-2"></i>Últimos Pedidos</h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($ultimosPedidos)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach (array_slice($ultimosPedidos, 0, 5) as $pedido): ?>
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <small class="text-muted"><?= date('d/m/Y', strtotime($pedido['fecha_venta'])) ?></small>
                                            <p class="mb-0"><?= htmlspecialchars($pedido['producto'] ?? 'Pedido') ?></p>
                                        </div>
                                        <span class="badge bg-primary">Q.<?= number_format($pedido['total'] ?? 0, 2) ?></span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                        <div class="text-center mt-3">
                            <a href="/app03_dgcm/tienda/mis-pedidos" class="btn btn-sm btn-outline-primary">Ver Todos</a>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-bag-x display-4 text-muted mb-3"></i>
                            <p class="text-muted">No tienes pedidos aún</p>
                            <a href="/app03_dgcm/tienda/productos" class="btn btn-primary">Hacer mi primer pedido</a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h6 class="mb-0"><i class="bi bi-tools me-2"></i>Estado de Reparaciones</h6>
                </div>
                <div class="card-body">
                    <?php if (!empty($reparacionesActivas)): ?>
                        <div class="list-group list-group-flush">
                            <?php foreach ($reparacionesActivas as $reparacion): ?>
                                <div class="list-group-item border-0 px-0">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <div>
                                            <p class="mb-1"><?= htmlspecialchars($reparacion['motivo']) ?></p>
                                            <small class="text-muted"><?= htmlspecialchars($reparacion['modelo'] ?? '') ?></small>
                                        </div>
                                        <span class="badge bg-<?= $reparacion['estado'] === 'Terminado' ? 'success' : ($reparacion['estado'] === 'En Proceso' ? 'warning' : 'info') ?>">
                                            <?= $reparacion['estado'] ?>
                                        </span>
                                    </div>
                                </div>
                            <?php endforeach; ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="bi bi-tools display-4 text-muted mb-3"></i>
                            <p class="text-muted">No tienes reparaciones activas</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/tienda/dashboard.js') ?>"></script>