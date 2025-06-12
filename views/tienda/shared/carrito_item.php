<?php
// ARCHIVO: views/tienda/shared/carrito-item.php
// Template para items del carrito
?>
<div class="d-flex align-items-center border-bottom py-3 carrito-item" data-id="<?= $item['id'] ?>">
    <div class="me-3">
        <img src="<?= asset('images/productos/' . ($item['imagen'] ?? 'default-phone.jpg')) ?>"
            alt="<?= htmlspecialchars($item['nombre']) ?>"
            class="rounded" style="width: 80px; height: 80px; object-fit: cover;">
    </div>

    <div class="flex-grow-1">
        <h6 class="mb-1"><?= htmlspecialchars($item['nombre']) ?></h6>
        <p class="text-muted mb-1 small"><?= htmlspecialchars($item['marca'] ?? '') ?></p>
        <strong class="text-success">Q.<?= number_format($item['precio'], 2) ?></strong>
    </div>

    <div class="text-center me-3">
        <label class="form-label small">Cantidad:</label>
        <div class="input-group input-group-sm" style="width: 120px;">
            <button class="btn btn-outline-secondary btn-decrementar"
                data-id="<?= $item['id'] ?>" type="button">-</button>
            <input type="number" class="form-control text-center cantidad-input"
                value="<?= $item['cantidad'] ?>" min="1" max="<?= $item['stock'] ?>"
                data-id="<?= $item['id'] ?>">
            <button class="btn btn-outline-secondary btn-incrementar"
                data-id="<?= $item['id'] ?>" type="button">+</button>
        </div>
        <small class="text-muted">Disponible: <?= $item['stock'] ?></small>
    </div>

    <div class="text-end">
        <div class="fw-bold text-success">Q.<?= number_format($item['precio'] * $item['cantidad'], 2) ?></div>
        <button class="btn btn-sm btn-outline-danger btn-eliminar-item mt-1"
            data-id="<?= $item['id'] ?>">
            <i class="bi bi-trash"></i>
        </button>
    </div>
</div>