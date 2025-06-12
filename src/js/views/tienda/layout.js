// ARCHIVO: build/js/tienda/layout.js

import '../../../scss/app.scss';
import { Dropdown } from 'bootstrap';

document.addEventListener('DOMContentLoaded', function () {
    // Inicializar componentes
    initProgressBar();
    initSearch();
    initCart();
});

// ========================================
// 📊 BARRA DE PROGRESO
// ========================================
function initProgressBar() {
    const progressBar = document.getElementById('bar');

    if (progressBar) {
        window.addEventListener('scroll', function () {
            const winScroll = document.body.scrollTop || document.documentElement.scrollTop;
            const height = document.documentElement.scrollHeight - document.documentElement.clientHeight;
            const scrolled = (winScroll / height) * 100;
            progressBar.style.width = scrolled + "%";
        });
    }
}

// ========================================
// 🔍 BÚSQUEDA SIMPLE
// ========================================
function initSearch() {
    const searchInput = document.getElementById('searchInput');

    if (searchInput) {
        // Búsqueda al presionar Enter
        searchInput.addEventListener('keypress', function (e) {
            if (e.key === 'Enter') {
                e.preventDefault();
                performSearch();
            }
        });

        // Búsqueda con botón
        const searchBtn = document.querySelector('button[type="button"] i.bi-search');
        if (searchBtn && searchBtn.parentElement) {
            searchBtn.parentElement.addEventListener('click', performSearch);
        }
    }
}

function performSearch() {
    const searchInput = document.getElementById('searchInput');
    const query = searchInput.value.trim();

    if (query.length > 0) {
        // Redirigir a página de búsqueda
        window.location.href = `/app03_dgcm/tienda/buscar?q=${encodeURIComponent(query)}`;
    }
}

// ========================================
// 🛒 CARRITO FUNCIONALIDAD
// ========================================
function initCart() {
    updateCartCounter();

    // Verificar si hay productos en localStorage
    const cartItems = getCartFromStorage();
    if (cartItems.length > 0) {
        updateCartCounter(cartItems.length);
    }
}

function getCartFromStorage() {
    try {
        const cart = localStorage.getItem('tienda_carrito');
        return cart ? JSON.parse(cart) : [];
    } catch (error) {
        console.error('Error leyendo carrito:', error);
        return [];
    }
}

function saveCartToStorage(items) {
    try {
        localStorage.setItem('tienda_carrito', JSON.stringify(items));
        updateCartCounter(items.length);
    } catch (error) {
        console.error('Error guardando carrito:', error);
    }
}

function updateCartCounter(count = null) {
    const counter = document.getElementById('contadorCarrito');

    if (counter) {
        if (count === null) {
            // Obtener del servidor si está logueado, sino del localStorage
            const cartItems = getCartFromStorage();
            count = cartItems.length;
        }

        counter.textContent = count;

        // Mostrar/ocultar badge
        if (count > 0) {
            counter.classList.remove('d-none');
        } else {
            counter.classList.add('d-none');
        }
    }
}

// ========================================
// 🛒 FUNCIONES PÚBLICAS DEL CARRITO
// ========================================
function addToCart(productId, productName, price, image) {
    const cartItems = getCartFromStorage();

    // Verificar si el producto ya existe
    const existingItem = cartItems.find(item => item.id === productId);

    if (existingItem) {
        existingItem.quantity += 1;
        showNotification(`Se agregó otra unidad de ${productName}`, 'info');
    } else {
        cartItems.push({
            id: productId,
            name: productName,
            price: price,
            image: image,
            quantity: 1,
            added_at: new Date().toISOString()
        });
        showNotification(`${productName} agregado al carrito`, 'success');
    }

    saveCartToStorage(cartItems);

    // Animar el botón del carrito
    animateCartIcon();
}

function removeFromCart(productId) {
    const cartItems = getCartFromStorage();
    const filteredItems = cartItems.filter(item => item.id !== productId);

    saveCartToStorage(filteredItems);
    showNotification('Producto eliminado del carrito', 'info');
}

function clearCart() {
    localStorage.removeItem('tienda_carrito');
    updateCartCounter(0);
    showNotification('Carrito vaciado', 'info');
}

// ========================================
// 🎨 ANIMACIONES SIMPLES
// ========================================
function animateCartIcon() {
    const cartLink = document.querySelector('a[href*="carrito"]');

    if (cartLink) {
        cartLink.classList.add('animate__animated', 'animate__pulse');

        setTimeout(() => {
            cartLink.classList.remove('animate__animated', 'animate__pulse');
        }, 1000);
    }
}

// ========================================
// 🔔 NOTIFICACIONES SIMPLES
// ========================================
function showNotification(message, type = 'info') {
    // Crear toast simple
    const toastHtml = `
        <div class="toast align-items-center text-white bg-${getBootstrapColor(type)} border-0" role="alert" style="position: fixed; top: 20px; right: 20px; z-index: 9999;">
            <div class="d-flex">
                <div class="toast-body">
                    <i class="bi bi-${getIcon(type)} me-2"></i>${message}
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" onclick="this.parentElement.parentElement.remove()"></button>
            </div>
        </div>
    `;

    document.body.insertAdjacentHTML('beforeend', toastHtml);

    // Auto-eliminar después de 3 segundos
    setTimeout(() => {
        const toast = document.body.lastElementChild;
        if (toast && toast.classList.contains('toast')) {
            toast.remove();
        }
    }, 3000);
}

function getBootstrapColor(type) {
    switch (type) {
        case 'success': return 'success';
        case 'error': return 'danger';
        case 'warning': return 'warning';
        default: return 'primary';
    }
}

function getIcon(type) {
    switch (type) {
        case 'success': return 'check-circle';
        case 'error': return 'x-circle';
        case 'warning': return 'exclamation-triangle';
        default: return 'info-circle';
    }
}

// ========================================
// 🌐 FUNCIONES GLOBALES
// ========================================
// Hacer funciones disponibles globalmente
window.tiendaLayout = {
    addToCart,
    removeFromCart,
    clearCart,
    updateCartCounter,
    showNotification,
    performSearch
};

// Para compatibilidad con otros scripts
window.addToCart = addToCart;
window.showNotification = showNotification;