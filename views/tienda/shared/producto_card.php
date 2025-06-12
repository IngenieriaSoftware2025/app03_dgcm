<?php

// ARCHIVO: views/tienda/shared/producto_card.php

// Template para mostrar productos en formato card
?>
<div class="col-md-6 col-lg-4 mb-4 producto-item" data-marca="<?= $producto['marca_nombre'] ?>" data-precio="<?= $producto['precio_venta'] ?>">
    <div class="card h-100 shadow-sm producto-card">
        <div class="position-relative">
            <img src="<?= asset('images/productos/' . ($producto['imagen'] ?? 'default-phone.jpg')) ?>"
                class="card-img-top" alt="<?= htmlspecialchars($producto['modelo']) ?>"
                style="height: 250px; object-fit: cover;">

            <!-- Badge de Stock -->
            <?php if ($producto['cantidad'] <= 0): ?>
                <span class="position-absolute top-0 end-0 badge bg-danger m-2">Agotado</span>
            <?php elseif ($producto['cantidad'] <= 5): ?>
                <span class="position-absolute top-0 end-0 badge bg-warning m-2">Últimas unidades</span>
            <?php endif; ?>

            <!-- Badge de Marca -->
            <span class="position-absolute top-0 start-0 badge bg-primary m-2">
                <?= htmlspecialchars($producto['marca_nombre']) ?>
            </span>
        </div>

        <div class="card-body d-flex flex-column">
            <h6 class="card-title"><?= htmlspecialchars($producto['modelo']) ?></h6>
            <p class="card-text text-muted small flex-grow-1">
                <?= htmlspecialchars(substr($producto['descripcion'] ?? '', 0, 100)) ?>
                <?= strlen($producto['descripcion'] ?? '') > 100 ? '...' : '' ?>
            </p>

            <div class="mt-auto">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span class="h5 text-success mb-0">Q.<?= number_format($producto['precio_venta'], 2) ?></span>
                    <small class="text-muted">Stock: <?= $producto['cantidad'] ?></small>
                </div>

                <div class="d-grid gap-2">
                    <?php if ($producto['cantidad'] > 0): ?>
                        <button class="btn btn-primary btn-agregar-carrito"
                            data-id="<?= $producto['id_celular'] ?>"
                            data-nombre="<?= htmlspecialchars($producto['modelo']) ?>"
                            data-precio="<?= $producto['precio_venta'] ?>"
                            data-stock="<?= $producto['cantidad'] ?>">
                            <i class="bi bi-cart-plus me-1"></i>Agregar al Carrito
                        </button>
                    <?php else: ?>
                        <button class="btn btn-secondary" disabled>
                            <i class="bi bi-x-circle me-1"></i>No Disponible
                        </button>
                    <?php endif; ?>

                    <button class="btn btn-outline-info btn-sm btn-ver-detalle"
                        data-id="<?= $producto['id_celular'] ?>">
                        <i class="bi bi-eye me-1"></i>Ver Detalles
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>