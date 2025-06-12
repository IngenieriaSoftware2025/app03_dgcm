<?php
// ARCHIVO: views/tienda/publico/productos.php
?>
<div class="container">
    <!-- Encabezado -->
    <div class="row mb-4">
        <div class="col-12">
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="/app03_dgcm/tienda">Inicio</a></li>
                    <li class="breadcrumb-item active">Productos</li>
                </ol>
            </nav>
            <h1 class="fw-bold">
                <i class="bi bi-phone me-2"></i>Nuestros Productos
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
                            <label for="filtroMarca" class="form-label small">Marca:</label>
                            <select class="form-select" id="filtroMarca">
                                <option value="">Todas las marcas</option>
                                <!-- Se cargan dinámicamente -->
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="filtroPrecio" class="form-label small">Precio máximo:</label>
                            <input type="range" class="form-range" id="filtroPrecio" min="500" max="15000" value="15000">
                            <small class="text-muted">Q. <span id="precioActual">15,000</span></small>
                        </div>
                        <div class="col-md-3">
                            <label for="ordenar" class="form-label small">Ordenar por:</label>
                            <select class="form-select" id="ordenar">
                                <option value="nombre">Nombre</option>
                                <option value="precio_asc">Precio: Menor a Mayor</option>
                                <option value="precio_desc">Precio: Mayor a Menor</option>
                                <option value="marca">Marca</option>
                            </select>
                        </div>
                        <div class="col-md-3">
                            <label for="buscarProducto" class="form-label small">Buscar:</label>
                            <input type="text" class="form-control" id="buscarProducto" placeholder="Modelo, marca...">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Grid de Productos -->
    <div class="row" id="gridProductos">
        <!-- Los productos se cargan dinámicamente -->
        <div class="col-12 text-center">
            <div class="spinner-border text-primary" role="status">
                <span class="visually-hidden">Cargando productos...</span>
            </div>
        </div>
    </div>

    <!-- Paginación -->
    <div class="row mt-4">
        <div class="col-12">
            <nav aria-label="Navegación de productos">
                <ul class="pagination justify-content-center" id="paginacionProductos">
                    <!-- Se genera dinámicamente -->
                </ul>
            </nav>
        </div>
    </div>
</div>

<!-- Modal Detalle Producto -->
<div class="modal fade" id="modalProducto" tabindex="-1">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Detalle del Producto</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body" id="detalleProducto">
                <!-- Se llena dinámicamente -->
            </div>
        </div>
    </div>
</div>

<script src="<?= asset('build/js/tienda/productos.js') ?>"></script>