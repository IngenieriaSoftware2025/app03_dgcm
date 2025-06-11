<?php
// C:\docker\app03_dgcm\views\tienda\dashboard.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<div class="row justify-content-center p-3">
    <div class="col-lg-12">
        <!-- Panel de resumen -->
        <div class="row g-3">
            <div class="col-md-3">
                <div class="card custom-card shadow-lg mb-4 border-primary rounded"
                    style="border-radius:10px; border:1px solid #007bff;">
                    <div class="card-body p-3 text-center">
                        <i class="bi bi-basket display-4 text-primary"></i>
                        <h5 class="mt-2 text-primary">Productos</h5>
                        <p class="display-6 mb-0"><?= $productosCount ?? 0 ?></p>
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
                    </div>
                </div>
            </div>
        </div>

        <!-- Aquí podrías añadir tablas de últimos pedidos, gráficos, etc. -->
    </div>
</div>

<script src="<?= asset('build/js/tienda/index.js') ?>"></script>