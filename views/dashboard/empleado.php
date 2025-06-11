<?php

// C:\docker\app03_dgcm\views\dashboard\empleado.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<div class="row justify-content-center p-3">
    <div class="col-lg-12">
        <!-- Bienvenida -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="alert alert-primary border-0 shadow-sm">
                    <h2><i class="bi bi-person-workspace me-2"></i>Panel de Empleado</h2>
                    <p class="mb-0">Bienvenido, <strong><?= htmlspecialchars($_SESSION['user']['nombre'] ?? 'Empleado') ?></strong></p>
                </div>
            </div>
        </div>

        <!-- Panel de resumen -->
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card custom-card shadow-lg mb-4 border-primary rounded"
                    style="border-radius:10px; border:1px solid #007bff;">
                    <div class="card-body p-3 text-center">
                        <i class="bi bi-box-seam display-4 text-primary"></i>
                        <h5 class="mt-2 text-primary">Productos</h5>
                        <p class="display-6 mb-0"><?= $productosCount ?? 0 ?></p>
                        <small class="text-muted">Total en inventario</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card custom-card shadow-lg mb-4 border-success rounded"
                    style="border-radius:10px; border:1px solid #28a745;">
                    <div class="card-body p-3 text-center">
                        <i class="bi bi-tags display-4 text-success"></i>
                        <h5 class="mt-2 text-success">Categorías</h5>
                        <p class="display-6 mb-0"><?= $categoriasCount ?? 0 ?></p>
                        <small class="text-muted">Categorías activas</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card custom-card shadow-lg mb-4 border-warning rounded"
                    style="border-radius:10px; border:1px solid #ffc107;">
                    <div class="card-body p-3 text-center">
                        <i class="bi bi-bag-check display-4 text-warning"></i>
                        <h5 class="mt-2 text-warning">Pedidos</h5>
                        <p class="display-6 mb-0"><?= $pedidosCount ?? 0 ?></p>
                        <small class="text-muted">Pedidos pendientes</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card custom-card shadow-lg mb-4 border-info rounded"
                    style="border-radius:10px; border:1px solid #17a2b8;">
                    <div class="card-body p-3 text-center">
                        <i class="bi bi-people display-4 text-info"></i>
                        <h5 class="mt-2 text-info">Clientes</h5>
                        <p class="display-6 mb-0"><?= $clientesCount ?? 0 ?></p>
                        <small class="text-muted">Clientes registrados</small>
                    </div>
                </div>
            </div>
        </div>

        <!-- Acciones rápidas -->
        <div class="row mt-4">
            <div class="col-12">
                <div class="card shadow-sm">
                    <div class="card-header bg-primary text-white">
                        <h5 class="mb-0"><i class="bi bi-lightning me-2"></i>Acciones Rápidas</h5>
                    </div>
                    <div class="card-body">
                        <div class="row g-3">
                            <div class="col-md-3">
                                <a href="/app03_dgcm/empleado/productos/crear" class="btn btn-outline-primary w-100">
                                    <i class="bi bi-plus-circle me-2"></i>Nuevo Producto
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/app03_dgcm/empleado/categorias/crear" class="btn btn-outline-success w-100">
                                    <i class="bi bi-tag me-2"></i>Nueva Categoría
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/app03_dgcm/empleado/pedidos" class="btn btn-outline-warning w-100">
                                    <i class="bi bi-list-check me-2"></i>Ver Pedidos
                                </a>
                            </div>
                            <div class="col-md-3">
                                <a href="/app03_dgcm/empleado/clientes" class="btn btn-outline-info w-100">
                                    <i class="bi bi-person-lines-fill me-2"></i>Gestionar Clientes
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Actividad reciente -->
        <div class="row mt-4">
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
                                                <small class="text-muted">#<?= $pedido['id'] ?></small>
                                                <p class="mb-0"><?= htmlspecialchars($pedido['cliente_nombre'] ?? 'Cliente') ?></p>
                                            </div>
                                            <span class="badge bg-primary">$<?= number_format($pedido['total'] ?? 0, 2) ?></span>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php else: ?>
                            <p class="text-muted text-center">No hay pedidos recientes</p>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="card shadow-sm">
                    <div class="card-header bg-light">
                        <h6 class="mb-0"><i class="bi bi-graph-up me-2"></i>Estadísticas</h6>
                    </div>
                    <div class="card-body">
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-success"><?= $ventasHoy ?? 0 ?></h4>
                                <small class="text-muted">Ventas Hoy</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-primary"><?= $productosStock ?? 0 ?></h4>
                                <small class="text-muted">Productos en Stock</small>
                            </div>
                        </div>
                        <hr>
                        <div class="row text-center">
                            <div class="col-6">
                                <h4 class="text-warning"><?= $pedidosPendientes ?? 0 ?></h4>
                                <small class="text-muted">Pedidos Pendientes</small>
                            </div>
                            <div class="col-6">
                                <h4 class="text-info"><?= $clientesActivos ?? 0 ?></h4>
                                <small class="text-muted">Clientes Activos</small>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/empleado/dashboard.js') ?>"></script>