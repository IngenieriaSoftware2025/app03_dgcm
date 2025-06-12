// ARCHIVO: build/js/tienda/index.js
// Funcionalidad para la página de inicio de la tienda

import '../../../scss/app.scss';
import { Dropdown } from 'bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    initHomepage();
});

function initHomepage() {
    loadFeaturedProducts();
    setupProductFilters();
    setupNewsletter();
    animateCounters();
}

// ========================================
// 📱 PRODUCTOS DESTACADOS
// ========================================
function loadFeaturedProducts() {
    const container = document.getElementById('productosContainer');
    const loading = document.getElementById('loadingProducts');

    // Simular carga de productos (reemplazar con API real)
    setTimeout(() => {
        const productos = getProductosMock();
        renderProducts(productos);
        loading.remove();
    }, 1500);
}

function getProductosMock() {
    // Mock data - reemplazar con llamada real a la API
    return [
        {
            id: 1,
            nombre: 'Samsung Galaxy S24',
            marca: 'samsung',
            precio: 15000,
            precio_original: 18000,
            imagen: 'samsung-s24.jpg',
            stock: 10,
            destacado: true,
            oferta: true
        },
        {
            id: 2,
            nombre: 'iPhone 15',
            marca: 'apple',
            precio: 22000,
            imagen: 'iphone-15.jpg',
            stock: 5,
            destacado: true,
            oferta: false
        },
        {
            id: 3,
            nombre: 'Xiaomi Redmi Note 13',
            marca: 'xiaomi',
            precio: 4500,
            imagen: 'xiaomi-note13.jpg',
            stock: 15,
            destacado: true,
            oferta: false
        },
        {
            id: 4,
            nombre: 'Samsung Galaxy A54',
            marca: 'samsung',
            precio: 8000,
            precio_original: 9500,
            imagen: 'samsung-a54.jpg',
            stock: 8,
            destacado: true,
            oferta: true
        }
    ];
}

function renderProducts(productos) {
    const container = document.getElementById('productosContainer');

    if (productos.length === 0) {
        container.innerHTML = `
            <div class="col-12 text-center py-5">
                <h5>No se encontraron productos</h5>
                <p class="text-muted">Intenta con otros filtros</p>
            </div>
        `;
        return;
    }

    const productosHtml = productos.map(producto => createProductCard(producto)).join('');
    container.innerHTML = productosHtml;

    // Setup eventos para los botones
    setupProductButtons();
}

function createProductCard(producto) {
    const descuento = producto.precio_original ?
        Math.round(((producto.precio_original - producto.precio) / producto.precio_original) * 100) : 0;

    return `
        <div class="col-lg-3 col-md-4 col-sm-6 product-item" data-marca="${producto.marca}" data-categoria="${producto.categoria || ''}">
            <div class="card h-100 shadow-sm product-card">
                <div class="position-relative">
                    ${producto.oferta ? `<span class="badge bg-danger position-absolute top-0 start-0 m-2">-${descuento}%</span>` : ''}
                    ${producto.stock < 5 ? '<span class="badge bg-warning position-absolute top-0 end-0 m-2">¡Pocas unidades!</span>' : ''}
                    
                    <img src="<?= asset('images/productos/') ?>${producto.imagen}" 
                         class="card-img-top" 
                         alt="${producto.nombre}"
                         style="height: 200px; object-fit: cover;"
                         onerror="this.src='<?= asset('images/default-phone.png') ?>'">
                </div>
                
                <div class="card-body d-flex flex-column">
                    <div class="mb-2">
                        <small class="text-muted text-uppercase">${producto.marca}</small>
                    </div>
                    <h6 class="card-title fw-semibold">${producto.nombre}</h6>
                    
                    <div class="mb-3">
                        <span class="h5 text-primary fw-bold">Q${producto.precio.toLocaleString()}</span>
                        ${producto.precio_original ?
            `<small class="text-muted text-decoration-line-through ms-2">Q${producto.precio_original.toLocaleString()}</small>`
            : ''}
                    </div>
                    
                    <div class="mt-auto">
                        <div class="d-grid gap-2">
                            <button class="btn btn-primary btn-sm btn-add-cart" 
                                    data-id="${producto.id}" 
                                    data-name="${producto.nombre}"
                                    data-price="${producto.precio}"
                                    data-image="${producto.imagen}"
                                    ${producto.stock === 0 ? 'disabled' : ''}>
                                <i class="bi bi-cart-plus me-1"></i>
                                ${producto.stock === 0 ? 'Agotado' : 'Agregar al Carrito'}
                            </button>
                            <button class="btn btn-outline-primary btn-sm btn-view-details" data-id="${producto.id}">
                                <i class="bi bi-eye me-1"></i>Ver Detalles
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    `;
}

function setupProductButtons() {
    // Botones agregar al carrito
    document.querySelectorAll('.btn-add-cart').forEach(btn => {
        btn.addEventListener('click', function () {
            const productData = {
                id: this.dataset.id,
                name: this.dataset.name,
                price: parseFloat(this.dataset.price),
                image: this.dataset.image
            };

            // Usar función del layout
            if (window.addToCart) {
                window.addToCart(productData.id, productData.name, productData.price, productData.image);

                // Feedback visual
                this.innerHTML = '<i class="bi bi-check me-1"></i>¡Agregado!';
                this.classList.remove('btn-primary');
                this.classList.add('btn-success');

                setTimeout(() => {
                    this.innerHTML = '<i class="bi bi-cart-plus me-1"></i>Agregar al Carrito';
                    this.classList.remove('btn-success');
                    this.classList.add('btn-primary');
                }, 2000);
            }
        });
    });

    // Botones ver detalles
    document.querySelectorAll('.btn-view-details').forEach(btn => {
        btn.addEventListener('click', function () {
            const productId = this.dataset.id;
            window.location.href = `/app03_dgcm/tienda/producto/${productId}`;
        });
    });
}

// ========================================
// 🎛️ FILTROS DE PRODUCTOS
// ========================================
function setupProductFilters() {
    const filterButtons = document.querySelectorAll('[data-filter]');

    filterButtons.forEach(btn => {
        btn.addEventListener('click', function () {
            // Actualizar botón activo
            filterButtons.forEach(b => {
                b.classList.remove('active');
                b.classList.add('btn-outline-primary');
                b.classList.remove('btn-primary');
            });

            this.classList.add('active');
            this.classList.remove('btn-outline-primary');
            this.classList.add('btn-primary');

            // Filtrar productos
            const filter = this.dataset.filter;
            filterProducts(filter);
        });
    });
}

function filterProducts(filter) {
    const productos = getProductosMock();
    let filteredProducts = productos;

    if (filter !== 'all') {
        filteredProducts = productos.filter(producto => {
            switch (filter) {
                case 'ofertas':
                    return producto.oferta;
                default:
                    return producto.marca === filter;
            }
        });
    }

    renderProducts(filteredProducts);
}

// ========================================
// 📧 NEWSLETTER
// ========================================
function setupNewsletter() {
    const form = document.getElementById('newsletterForm');

    if (form) {
        form.addEventListener('submit', function (e) {
            e.preventDefault();

            const emailInput = form.querySelector('input[type="email"]');
            const submitBtn = form.querySelector('button[type="submit"]');
            const email = emailInput.value;

            // Feedback visual
            submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm"></span>';
            submitBtn.disabled = true;

            // Simular envío (reemplazar con API real)
            setTimeout(() => {
                if (window.showNotification) {
                    window.showNotification('¡Suscripción exitosa! Revisa tu email.', 'success');
                } else {
                    alert('¡Suscripción exitosa!');
                }

                emailInput.value = '';
                submitBtn.innerHTML = '<i class="bi bi-send"></i> Suscribir';
                submitBtn.disabled = false;
            }, 2000);
        });
    }
}

// ========================================
// 📊 ANIMACIÓN DE CONTADORES
// ========================================
function animateCounters() {
    const counters = document.querySelectorAll('[data-counter]');

    const observerOptions = {
        threshold: 0.5,
        rootMargin: '0px 0px -100px 0px'
    };

    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                const counter = entry.target;
                const target = parseInt(counter.dataset.counter);
                animateValue(counter, 0, target, 2000);
                observer.unobserve(counter);
            }
        });
    }, observerOptions);

    counters.forEach(counter => observer.observe(counter));
}

function animateValue(element, start, end, duration) {
    const range = end - start;
    const increment = end > start ? 1 : -1;
    const stepTime = Math.abs(Math.floor(duration / range));
    let current = start;

    const timer = setInterval(() => {
        current += increment;
        element.textContent = current + (end >= 1000 ? '+' : '');

        if (current === end) {
            clearInterval(timer);
        }
    }, stepTime);
}

// ========================================
// 🎯 FUNCIONES AUXILIARES
// ========================================
function showError(message) {
    if (window.showNotification) {
        window.showNotification(message, 'error');
    } else {
        console.error(message);
    }
}