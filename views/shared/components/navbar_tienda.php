<?php
// ARCHIVO: views/shared/components/navbar_tienda.php
if (session_status() !== PHP_SESSION_ACTIVE) session_start();
?>
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand d-flex align-items-center" href="/app03_dgcm/tienda">
            <img src="<?= asset('images/cit.png') ?>" width="35" class="me-2" alt="Logo">
            <span class="fw-bold text-primary">Tienda de Celulares</span>
        </a>

        <button class="navbar-toggler" type="button"
            data-bs-toggle="collapse" data-bs-target="#navbarTienda"
            aria-controls="navbarTienda" aria-expanded="false"
            aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>

        <div class="collapse navbar-collapse" id="navbarTienda">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <!-- Inicio -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'inicio' ? 'active' : '' ?>"
                        href="/app03_dgcm/tienda">
                        <i class="bi bi-house me-1"></i>Inicio
                    </a>
                </li>

                <!-- Productos -->
                <li class="nav-item">
                    <a class="nav-link <?= $current_page === 'productos' ? 'active' : '' ?>"
                        href="/app03_dgcm/tienda/productos">
                        <i class="bi bi-phone me-1"></i>Productos
                    </a>
                </li>

                <!-- Marcas -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle <?= $current_page === 'marcas' ? 'active' : '' ?>"
                        href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-tags me-1"></i>Marcas
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/tienda/productos?marca=samsung">
                                <i class="bi bi-phone me-2"></i>Samsung
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/tienda/productos?marca=apple">
                                <i class="bi bi-phone me-2"></i>Apple
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/tienda/productos?marca=xiaomi">
                                <i class="bi bi-phone me-2"></i>Xiaomi
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/tienda/productos?marca=huawei">
                                <i class="bi bi-phone me-2"></i>Huawei
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/tienda/productos">
                                <i class="bi bi-grid me-2"></i>Ver Todas las Marcas
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Servicios -->
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                        <i class="bi bi-tools me-1"></i>Servicios
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/tienda/servicios/reparaciones">
                                <i class="bi bi-wrench me-2"></i>Reparaciones
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/tienda/servicios/mantenimiento">
                                <i class="bi bi-gear me-2"></i>Mantenimiento
                            </a>
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/tienda/servicios/accesorios">
                                <i class="bi bi-headphones me-2"></i>Accesorios
                            </a>
                        </li>
                        <li>
                            <hr class="dropdown-divider">
                        </li>
                        <li>
                            <a class="dropdown-item" href="/app03_dgcm/tienda/servicios/garantias">
                                <i class="bi bi-shield-check me-2"></i>Garantías
                            </a>
                        </li>
                    </ul>
                </li>

                <!-- Ofertas -->
                <li class="nav-item">
                    <a class="nav-link text-danger fw-bold" href="/app03_dgcm/tienda/ofertas">
                        <i class="bi bi-percent me-1"></i>Ofertas
                        <span class="badge bg-danger ms-1">¡Hot!</span>
                    </a>
                </li>
            </ul>

            <!-- Búsqueda -->
            <form class="d-flex me-3" role="search">
                <div class="input-group">
                    <input class="form-control" type="search" placeholder="Buscar productos..."
                        id="busquedaNavbar" name="busqueda">
                    <button class="btn btn-outline-primary" type="submit">
                        <i class="bi bi-search"></i>
                    </button>
                </div>
            </form>

            <!-- Menú de Usuario -->
            <ul class="navbar-nav">
                <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'cliente'): ?>
                    <!-- Cliente autenticado -->

                    <!-- Carrito -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="/app03_dgcm/tienda/carrito">
                            <i class="bi bi-cart3 fs-5"></i>
                            <span id="contadorCarrito" class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                                <?= $_SESSION['carrito_items'] ?? 0 ?>
                            </span>
                        </a>
                    </li>

                    <!-- Favoritos -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="/app03_dgcm/tienda/favoritos">
                            <i class="bi bi-heart fs-5"></i>
                            <span id="contadorFavoritos" class="badge bg-success rounded-pill position-absolute top-0 start-100 translate-middle">
                                <?= $_SESSION['favoritos_count'] ?? 0 ?>
                            </span>
                        </a>
                    </li>

                    <!-- Perfil de Cliente -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle d-flex align-items-center"
                            href="#" data-bs-toggle="dropdown">
                            <div class="me-2">
                                <?php if (!empty($_SESSION['user']['fotografia'])): ?>
                                    <img src="<?= $_SESSION['user']['fotografia'] ?>"
                                        class="rounded-circle" width="32" height="32" alt="Foto">
                                <?php else: ?>
                                    <i class="bi bi-person-circle fs-4"></i>
                                <?php endif; ?>
                            </div>
                            <span class="fw-bold"><?= htmlspecialchars($_SESSION['user']['nombre1'] ?? 'Cliente') ?></span>
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li class="dropdown-header">
                                <div class="text-center">
                                    <strong><?= htmlspecialchars($_SESSION['user']['nombre1'] . ' ' . $_SESSION['user']['apellido1']) ?></strong><br>
                                    <small class="text-muted"><?= htmlspecialchars($_SESSION['user']['correo']) ?></small>
                                </div>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/tienda/dashboard">
                                    <i class="bi bi-speedometer2 me-2"></i>Mi Panel
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/tienda/mi-perfil">
                                    <i class="bi bi-person-gear me-2"></i>Mi Perfil
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/tienda/mis-pedidos">
                                    <i class="bi bi-bag-check me-2"></i>Mis Pedidos
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/tienda/favoritos">
                                    <i class="bi bi-heart me-2"></i>Mis Favoritos
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/tienda/soporte">
                                    <i class="bi bi-headset me-2"></i>Soporte
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item text-danger" href="/app03_dgcm/logout">
                                    <i class="bi bi-box-arrow-right me-2"></i>Cerrar Sesión
                                </a>
                            </li>
                        </ul>
                    </li>

                <?php else: ?>
                    <!-- Usuario no autenticado -->

                    <!-- Carrito para invitados -->
                    <li class="nav-item">
                        <a class="nav-link position-relative" href="/app03_dgcm/tienda/carrito">
                            <i class="bi bi-cart3 fs-5"></i>
                            <span id="contadorCarritoInvitado" class="badge bg-danger rounded-pill position-absolute top-0 start-100 translate-middle">
                                0
                            </span>
                        </a>
                    </li>

                    <!-- Menú de Autenticación -->
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="#" data-bs-toggle="dropdown">
                            <i class="bi bi-person me-1"></i>Mi Cuenta
                        </a>
                        <ul class="dropdown-menu dropdown-menu-end">
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/login">
                                    <i class="bi bi-box-arrow-in-right me-2"></i>Iniciar Sesión
                                </a>
                            </li>
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/tienda/registro">
                                    <i class="bi bi-person-plus me-2"></i>Crear Cuenta
                                </a>
                            </li>
                            <li>
                                <hr class="dropdown-divider">
                            </li>
                            <li>
                                <a class="dropdown-item" href="/app03_dgcm/tienda/ayuda">
                                    <i class="bi bi-question-circle me-2"></i>¿Necesitas ayuda?
                                </a>
                            </li>
                        </ul>
                    </li>

                    <!-- Botón CTA -->
                    <li class="nav-item">
                        <a class="nav-link btn btn-primary text-white ms-2 px-3"
                            href="/app03_dgcm/tienda/registro">
                            <i class="bi bi-person-plus me-1"></i>Únete
                        </a>
                    </li>
                <?php endif; ?>
            </ul>
        </div>
    </div>
</nav>

<!-- Barra de promoción (opcional) -->
<div class="bg-success text-white text-center py-2 d-none" id="barraPromocion">
    <div class="container">
        <small>
            <i class="bi bi-gift me-1"></i>
            <strong>¡Promoción especial!</strong> Envío gratis en compras mayores a Q.500
            <button type="button" class="btn-close btn-close-white btn-sm ms-2"
                onclick="ocultarPromocion()"></button>
        </small>
    </div>
</div>

<!-- JavaScript específico para la tienda -->
<script>
    // Búsqueda en tiempo real
    document.getElementById('busquedaNavbar')?.addEventListener('input', function(e) {
        const termino = e.target.value;
        if (termino.length > 2) {
            buscarProductosEnTiempoReal(termino);
        }
    });

    function buscarProductosEnTiempoReal(termino) {
        // Implementar búsqueda AJAX
        fetch(`/app03_dgcm/api/productos/buscar?q=${encodeURIComponent(termino)}`)
            .then(response => response.json())
            .then(data => {
                mostrarResultadosBusqueda(data);
            })
            .catch(error => console.error('Error en búsqueda:', error));
    }

    function mostrarResultadosBusqueda(productos) {
        // Mostrar dropdown con resultados
        // Implementar según necesidades
    }

    // Actualizar contador del carrito
    function actualizarContadorCarrito(cantidad) {
        const contador = document.getElementById('contadorCarrito') ||
            document.getElementById('contadorCarritoInvitado');
        if (contador) {
            contador.textContent = cantidad;
            contador.style.display = cantidad > 0 ? 'inline' : 'none';
        }
    }

    // Actualizar contador de favoritos
    function actualizarContadorFavoritos(cantidad) {
        const contador = document.getElementById('contadorFavoritos');
        if (contador) {
            contador.textContent = cantidad;
            contador.style.display = cantidad > 0 ? 'inline' : 'none';
        }
    }

    // Ocultar barra de promoción
    function ocultarPromocion() {
        document.getElementById('barraPromocion').style.display = 'none';
        localStorage.setItem('promocion_oculta', 'true');
    }

    // Mostrar barra de promoción si no está oculta
    document.addEventListener('DOMContentLoaded', function() {
        if (!localStorage.getItem('promocion_oculta')) {
            document.getElementById('barraPromocion')?.classList.remove('d-none');
        }

        // Cargar contadores del carrito y favoritos
        cargarContadores();
    });

    function cargarContadores() {
        // Cargar desde localStorage para invitados o desde sesión para usuarios
        <?php if (isset($_SESSION['user'])): ?>
            // Usuario autenticado - cargar desde servidor
            fetch('/app03_dgcm/api/carrito/contador')
                .then(response => response.json())
                .then(data => {
                    actualizarContadorCarrito(data.carrito || 0);
                    actualizarContadorFavoritos(data.favoritos || 0);
                });
        <?php else: ?>
            // Invitado - cargar desde localStorage
            const carritoLocal = JSON.parse(localStorage.getItem('carrito_invitado') || '[]');
            actualizarContadorCarrito(carritoLocal.length);
        <?php endif; ?>
    }

    // Añadir producto al carrito (función global)
    function agregarAlCarrito(productoId, cantidad = 1) {
        <?php if (isset($_SESSION['user'])): ?>
            // Usuario autenticado
            fetch('/app03_dgcm/api/carrito/agregar', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                    },
                    body: JSON.stringify({
                        producto_id: productoId,
                        cantidad: cantidad
                    })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        actualizarContadorCarrito(data.total_items);
                        mostrarNotificacion('Producto agregado al carrito', 'success');
                    }
                });
        <?php else: ?>
            // Invitado - guardar en localStorage
            let carritoLocal = JSON.parse(localStorage.getItem('carrito_invitado') || '[]');
            const productoExistente = carritoLocal.find(item => item.id == productoId);

            if (productoExistente) {
                productoExistente.cantidad += cantidad;
            } else {
                carritoLocal.push({
                    id: productoId,
                    cantidad: cantidad,
                    fecha_agregado: new Date().toISOString()
                });
            }

            localStorage.setItem('carrito_invitado', JSON.stringify(carritoLocal));
            actualizarContadorCarrito(carritoLocal.length);
            mostrarNotificacion('Producto agregado al carrito', 'success');
        <?php endif; ?>
    }

    // Mostrar notificaciones
    function mostrarNotificacion(mensaje, tipo = 'info') {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                text: mensaje,
                icon: tipo,
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000
            });
        }
    }
</script>