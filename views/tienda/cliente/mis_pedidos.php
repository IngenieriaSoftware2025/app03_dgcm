<?php
// ARCHIVO: views/tienda/cliente/mis_pedidos.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="/app03_dgcm/tienda">Inicio</a></li>
            <li class="breadcrumb-item"><a href="/app03_dgcm/tienda/dashboard">Mi Panel</a></li>
            <li class="breadcrumb-item active">Mis Pedidos</li>
        </ol>
    </nav>

    <div class="row mb-4">
        <div class="col-12">
            <h1 class="fw-bold">
                <i class="bi bi-bag-check me-2"></i>Mis Pedidos
            </h1>
        </div>
    </div>

    <!-- Filtros -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col-md-3">
                            <label for="filtroEstado" class="form-label small">Estado:</label>
                            <select class="form-select" id="filtroEstado">
                                <option value="">Todos los estados</option>
                                <option value="Pendiente">Pendiente</option>
                                <option value="Procesando">Procesando</option>
                                <option value="Completado">Completado</option>
                                <option value="Cancelado">Cancelado</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filtroTipo" class="form-label small">Tipo:</label>
                            <select class="form-select" id="filtroTipo">
                                <option value="">Todos los tipos</option>
                                <option value="C">Celulares</option>
                                <option value="R">Reparaciones</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="fechaDesde" class="form-label small">Desde:</label>
                            <input type="date" class="form-control" id="fechaDesde">
                        </div>
                        <div class="col-md-3">
                            <label for="fechaHasta" class="form-label small">Hasta:</label>
                            <input type="date" class="form-control" id="fechaHasta">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Lista de Pedidos -->
    <div class="row" id="listaPedidos">
        <!-- Se cargan dinámicamente -->
        <div class="col-12 text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando pedidos...</span>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Navegación de pedidos">
                <ul class="pagination justify-content-center" id="paginacionPedidos">
                    <!-- Se genera dinámicamente -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal Detalle Pedido -->
<div class="modal fade" id="modalDetallePedido" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle del Pedido</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detallePedidoContent">
                <!-- Se llena dinámicamente -->
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-outline-primary" id="btnDescargarFactura">
                    <i class="bi bi-download me-1"></i>Descargar Factura
                </button>
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/tienda/mis-pedidos.js') ?>"></script>