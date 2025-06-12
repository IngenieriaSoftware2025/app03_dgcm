<?php
// ARCHIVO: views/tienda/shared/pedido-card.php
// Template para mostrar pedidos en formato card
?>
<div class="col-12 mb-3">
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="row align-items-center">
                <div class="col-md-2">
                    <div class="text-center">
                        <i class="bi bi-<?= $pedido['tipo'] === 'C' ? 'phone' : 'tools' ?> display-6 text-primary"></i>
                        <small class="d-block text-muted">
                            <?= $pedido['tipo'] === 'C' ? 'Celular' : 'Reparación' ?>
                        </small>
                    </div>
                </div>

                <div class="col-md-6">
                    <h6 class="mb-1">Pedido #<?= $pedido['id_venta'] ?></h6>
                    <p class="text-muted mb-1">
                        <?= htmlspecialchars($pedido['producto_nombre'] ?? 'Servicio de reparación') ?>
                    </p>
                    <small class="text-muted">
                        <i class="bi bi-calendar me-1"></i>
                        <?= date('d/m/Y H:i', strtotime($pedido['fecha_venta'])) ?>
                    </small>
                </div>

                <div class="col-md-2 text-center">
                    <span class="badge bg-<?=
                                            $pedido['situacion'] == 1 ? 'success' : 'secondary'
                                            ?> fs-6">
                        <?= $pedido['situacion'] == 1 ? 'Activo' : 'Inactivo' ?>
                    </span>
                </div>

                <div class="col-md-2 text-end">
                    <h5 class="text-success mb-1">Q.<?= number_format($pedido['total'], 2) ?></h5>
                    <div class="btn-group btn-group-sm">
                        <button class="btn btn-outline-primary btn-ver-pedido"
                            data-id="<?= $pedido['id_venta'] ?>">
                            <i class="bi bi-eye"></i>
                        </button>
                        <button class="btn btn-outline-secondary btn-descargar-factura"
                            data-id="<?= $pedido['id_venta'] ?>">
                            <i class="bi bi-download"></i>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>