<?php
// ARCHIVO: views/tienda/cliente/carrito.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/app03_dgcm/tienda">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/app03_dgcm/tienda/productos">Productos</a></li>
            <li class="breadcrumb-item active">Carrito</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold">
                <i class="bi bi-cart3 me-2"></i>Mi Carrito de Compras
            </h1>
        </div>
    </div>

    <div class="row">
        <!-- Productos en el Carrito -->
        <div class="col-lg-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Productos Seleccionados</h5>
                </div>
                <div class="card-body">
                    <div id="productosCarrito">
                        <!-- Se cargan dinámicamente -->
                        <div class="text-center py-5">
                            <i class="bi bi-cart-x display-1 text-muted mb-3"></i>
                            <h5 class="text-muted">Tu carrito está vacío</h5>
                            <p class="text-muted">Agrega productos para comenzar tu compra</p>
                            <a href="/app03_dgcm/tienda/productos" class="btn btn-primary">
                                <i class="bi bi-shop me-1"></i>Ir a Productos
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Resumen del Pedido -->
        <div class="col-lg-4">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">Resumen del Pedido</h5>
                </div>
                <div class="card-body">
                    <div class="d-flex justify-content-between mb-2">
                        <span>Subtotal:</span>
                        <span id="subtotal">Q. 0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Impuestos:</span>
                        <span id="impuestos">Q. 0.00</span>
                    </div>
                    <div class="d-flex justify-content-between mb-2">
                        <span>Envío:</span>
                        <span id="envio">Gratis</span>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between fw-bold h5">
                        <span>Total:</span>
                        <span id="total">Q. 0.00</span>
                    </div>

                    <div class="d-grid gap-2 mt-3">
                        <button type="button" class="btn btn-success btn-lg" id="btnProcederCompra" disabled>
                            <i class="bi bi-credit-card me-2"></i>Proceder al Pago
                        </button>
                        <button type="button" class="btn btn-outline-secondary" id="btnVaciarCarrito">
                            <i class="bi bi-trash me-2"></i>Vaciar Carrito
                        </button>
                    </div>

                    <div class="mt-3">
                        <small class="text-muted">
                            <i class="bi bi-shield-check me-1"></i>
                            Compra 100% segura
                        </small>
                    </div>
                </div>
            </div>

            <!-- Métodos de Pago -->
            <div class="card shadow-sm mt-3">
                <div class="card-header">
                    <h6 class="mb-0">Métodos de Pago Aceptados</h6>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-4">
                            <i class="bi bi-cash display-6 text-success"></i>
                            <small class="d-block">Efectivo</small>
                        </div>
                        <div class="col-4">
                            <i class="bi bi-credit-card display-6 text-primary"></i>
                            <small class="d-block">Tarjeta</small>
                        </div>
                        <div class="col-4">
                            <i class="bi bi-bank display-6 text-info"></i>
                            <small class="d-block">Transferencia</small>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirmar Compra -->
<div class="modal fade" id="modalConfirmarCompra" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header bg-success text-white">
                <h5 class="modal-title">
                    <i class="bi bi-check-circle me-2"></i>Confirmar Compra
                </h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <form id="FormConfirmarCompra">
                    <!-- Información de Entrega -->
                    <h6 class="fw-bold mb-3">Información de Entrega</h6>
                    <div class="row mb-3">
                        <div class="col-12">
                            <label for="direccion_entrega" class="form-label">Dirección de Entrega</label>
                            <textarea class="form-control" id="direccion_entrega" name="direccion_entrega" rows="2" required></textarea>
                        </div>
                    </div>

                    <!-- Método de Pago -->
                    <h6 class="fw-bold mb-3">Método de Pago</h6>
                    <div class="row mb-3">
                        <div class="col-12">
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="pago_efectivo" value="efectivo" checked>
                                <label class="form-check-label" for="pago_efectivo">
                                    <i class="bi bi-cash me-2"></i>Efectivo (Pago en tienda)
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="pago_tarjeta" value="tarjeta">
                                <label class="form-check-label" for="pago_tarjeta">
                                    <i class="bi bi-credit-card me-2"></i>Tarjeta de Crédito/Débito
                                </label>
                            </div>
                            <div class="form-check">
                                <input class="form-check-input" type="radio" name="metodo_pago" id="pago_transferencia" value="transferencia">
                                <label class="form-check-label" for="pago_transferencia">
                                    <i class="bi bi-bank me-2"></i>Transferencia Bancaria
                                </label>
                            </div>
                        </div>
                    </div>

                    <!-- Resumen Final -->
                    <h6 class="fw-bold mb-3">Resumen de la Compra</h6>
                    <div id="resumenFinalCompra">
                        <!-- Se llena dinámicamente -->
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" form="FormConfirmarCompra" class="btn btn-success">
                    <i class="bi bi-check-circle me-1"></i>Confirmar Pedido
                </button>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/tienda/carrito.js') ?>"></script>