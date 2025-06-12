<?php
// ARCHIVO: views/tienda/publico/index.php
?>
<div class="container-fluid px-0">
    <!-- Hero Section que compagina con el navbar -->
    <section class="bg-primary text-white py-5 mb-0" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%) !important;">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <h1 class="display-4 fw-bold mb-4">
                        📱 Tienda de Celulares
                    </h1>
                    <p class="lead mb-4" style="color: rgba(255,255,255,0.9);">
                        Los mejores smartphones, accesorios y servicios de reparación en Guatemala.
                        Precios competitivos y garantía oficial.
                    </p>
                    <div class="d-flex gap-3 flex-wrap">
                        <a href="/app03_dgcm/tienda/categoria?cat=smartphones" class="btn btn-light btn-lg">
                            <i class="bi bi-phone me-2"></i>Ver Productos
                        </a>
                        <a href="/app03_dgcm/tienda/ofertas" class="btn btn-outline-light btn-lg">
                            <i class="bi bi-tags me-2"></i>Ofertas
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center">
                    <img src="<?= asset('images/hero-phone.png') ?>" alt="Smartphones" class="img-fluid" style="max-height: 400px; filter: drop-shadow(0 10px 20px rgba(0,0,0,0.2));">
                </div>
            </div>
        </div>
    </section>

    <!-- Estadísticas con colores coordinados -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row text-center">
                <div class="col-6 col-md-3 mb-3">
                    <div class="p-3">
                        <h3 class="mb-1" style="color: #007bff;" data-counter="5000">5000+</h3>
                        <small class="text-muted fw-semibold">Clientes Satisfechos</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="p-3">
                        <h3 class="mb-1" style="color: #28a745;" data-counter="200">200+</h3>
                        <small class="text-muted fw-semibold">Productos Disponibles</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="p-3">
                        <h3 class="mb-1" style="color: #17a2b8;" data-counter="15">15+</h3>
                        <small class="text-muted fw-semibold">Marcas Reconocidas</small>
                    </div>
                </div>
                <div class="col-6 col-md-3 mb-3">
                    <div class="p-3">
                        <h3 class="mb-1" style="color: #ffc107;" data-counter="10">10+</h3>
                        <small class="text-muted fw-semibold">Años de Experiencia</small>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Nuestros Servicios con mejor diseño -->
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="fw-bold mb-3" style="color: #343a40;">Nuestros Servicios</h2>
                    <p class="text-muted lead">Todo lo que necesitas para tu celular en un solo lugar</p>
                </div>
            </div>

            <div class="row g-4">
                <!-- Venta de Celulares -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm" style="transition: transform 0.3s ease;">
                        <div class="card-body text-center p-4">
                            <div class="mb-4">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px; background: linear-gradient(135deg, #007bff, #0056b3);">
                                    <i class="bi bi-phone fs-1 text-white"></i>
                                </div>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Venta de Celulares</h5>
                            <p class="card-text text-muted mb-4">
                                Amplio catálogo de las mejores marcas: Samsung, Apple, Xiaomi, Huawei y más.
                            </p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Garantía oficial</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Mejores precios</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Stock actualizado</li>
                            </ul>
                            <a href="/app03_dgcm/tienda/categoria?cat=smartphones" class="btn btn-primary px-4">
                                Ver Catálogo
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Reparaciones -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm" style="transition: transform 0.3s ease;">
                        <div class="card-body text-center p-4">
                            <div class="mb-4">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px; background: linear-gradient(135deg, #28a745, #1e7e34);">
                                    <i class="bi bi-tools fs-1 text-white"></i>
                                </div>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Reparaciones Técnicas</h5>
                            <p class="card-text text-muted mb-4">
                                Servicio especializado con técnicos certificados y repuestos originales.
                            </p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Diagnóstico gratuito</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Repuestos originales</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Garantía 6 meses</li>
                            </ul>
                            <a href="/app03_dgcm/tienda/categoria?cat=reparaciones" class="btn btn-success px-4">
                                Solicitar Reparación
                            </a>
                        </div>
                    </div>
                </div>

                <!-- Soporte -->
                <div class="col-lg-4 col-md-6">
                    <div class="card h-100 border-0 shadow-sm" style="transition: transform 0.3s ease;">
                        <div class="card-body text-center p-4">
                            <div class="mb-4">
                                <div class="rounded-circle d-inline-flex align-items-center justify-content-center"
                                    style="width: 80px; height: 80px; background: linear-gradient(135deg, #17a2b8, #117a8b);">
                                    <i class="bi bi-headset fs-1 text-white"></i>
                                </div>
                            </div>
                            <h5 class="card-title fw-bold mb-3">Soporte Premium</h5>
                            <p class="card-text text-muted mb-4">
                                Atención personalizada y soporte técnico especializado para nuestros clientes.
                            </p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Atención rápida</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Asesoría especializada</li>
                                <li class="mb-2"><i class="bi bi-check-circle text-success me-2"></i>Múltiples canales</li>
                            </ul>
                            <a href="/app03_dgcm/tienda/contacto" class="btn btn-info px-4">
                                Contactar Soporte
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Productos Destacados con mejor diseño -->
    <section class="py-5 bg-white">
        <div class="container">
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <h2 class="fw-bold mb-3" style="color: #343a40;">Productos Destacados</h2>
                    <p class="text-muted lead">Los smartphones más populares del momento</p>
                </div>
            </div>

            <!-- Filtros mejorados -->
            <div class="row mb-5">
                <div class="col-12 text-center">
                    <div class="btn-group shadow-sm" role="group">
                        <button type="button" class="btn btn-primary active" data-filter="all">Todos</button>
                        <button type="button" class="btn btn-outline-primary" data-filter="samsung">Samsung</button>
                        <button type="button" class="btn btn-outline-primary" data-filter="apple">Apple</button>
                        <button type="button" class="btn btn-outline-primary" data-filter="xiaomi">Xiaomi</button>
                        <button type="button" class="btn btn-outline-primary" data-filter="ofertas">Ofertas</button>
                    </div>
                </div>
            </div>

            <!-- Grid de Productos -->
            <div id="productosContainer" class="row g-4">
                <!-- Loading inicial -->
                <div class="col-12 text-center" id="loadingProducts">
                    <div class="py-5">
                        <div class="spinner-border text-primary mb-3" style="width: 3rem; height: 3rem;"></div>
                        <h5 style="color: #343a40;">Cargando productos...</h5>
                        <p class="text-muted">Preparando los mejores productos para ti</p>
                    </div>
                </div>
            </div>

            <!-- Botón Ver Más mejorado -->
            <div class="row mt-5">
                <div class="col-12 text-center">
                    <a href="/app03_dgcm/tienda/categoria?cat=smartphones" class="btn btn-primary btn-lg shadow-sm px-5">
                        <i class="bi bi-eye me-2"></i>Ver Todo el Catálogo
                        <span class="badge bg-light text-primary ms-2">200+</span>
                    </a>
                </div>
            </div>
        </div>
    </section>

    <!-- Newsletter con gradiente coordinado -->
    <section class="py-5 text-white" style="background: linear-gradient(135deg, #007bff 0%, #0056b3 100%);">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-6 mb-3 mb-lg-0">
                    <h3 class="fw-bold mb-3">¡Mantente informado!</h3>
                    <p class="mb-0" style="color: rgba(255,255,255,0.9);">
                        Recibe ofertas exclusivas y noticias de nuevos productos directamente en tu correo.
                    </p>
                </div>
                <div class="col-lg-6">
                    <form id="newsletterForm" class="row g-2">
                        <div class="col-8">
                            <input type="email" class="form-control form-control-lg border-0"
                                placeholder="tu@email.com" required
                                style="border-radius: 25px 0 0 25px !important;">
                        </div>
                        <div class="col-4">
                            <button type="submit" class="btn btn-light btn-lg w-100 border-0"
                                style="border-radius: 0 25px 25px 0 !important; color: #007bff;">
                                <i class="bi bi-send"></i> Suscribir
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </section>

    <!-- ¿Por qué elegirnos? con mejor diseño -->
    <section class="py-5" style="background-color: #f8f9fa;">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center mb-5">
                    <h3 class="fw-bold" style="color: #343a40;">¿Por qué elegirnos?</h3>
                    <p class="text-muted">Razones para confiar en nosotros</p>
                </div>
            </div>
            <div class="row text-center">
                <div class="col-md-3 col-6 mb-4">
                    <div class="p-3">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; background: rgba(40, 167, 69, 0.1);">
                            <i class="bi bi-shield-check fs-3 text-success"></i>
                        </div>
                        <h6 class="fw-bold">Garantía</h6>
                        <small class="text-muted">Productos con garantía oficial</small>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="p-3">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; background: rgba(0, 123, 255, 0.1);">
                            <i class="bi bi-truck fs-3 text-primary"></i>
                        </div>
                        <h6 class="fw-bold">Entrega</h6>
                        <small class="text-muted">Entrega rápida en tienda</small>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="p-3">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; background: rgba(23, 162, 184, 0.1);">
                            <i class="bi bi-credit-card fs-3 text-info"></i>
                        </div>
                        <h6 class="fw-bold">Pagos</h6>
                        <small class="text-muted">Múltiples formas de pago</small>
                    </div>
                </div>
                <div class="col-md-3 col-6 mb-4">
                    <div class="p-3">
                        <div class="rounded-circle d-inline-flex align-items-center justify-content-center mb-3"
                            style="width: 60px; height: 60px; background: rgba(255, 193, 7, 0.1);">
                            <i class="bi bi-people fs-3 text-warning"></i>
                        </div>
                        <h6 class="fw-bold">Experiencia</h6>
                        <small class="text-muted">Más de 10 años en el mercado</small>
                    </div>
                </div>
            </div>
        </div>
    </section>
</div>

<style>
    /* Efectos hover para las cards */
    .card:hover {
        transform: translateY(-5px);
    }

    /* Mejorar los botones del filtro */
    .btn-group .btn {
        padding: 0.5rem 1.5rem;
        font-weight: 500;
    }

    .btn-group .btn.active {
        box-shadow: 0 2px 10px rgba(0, 123, 255, 0.3);
    }
</style>

<script src="<?= asset('build/js/tienda/index.js') ?>"></script>