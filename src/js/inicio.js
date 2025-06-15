import { Dropdown } from "bootstrap";

// JavaScript para la página de inicio

document.addEventListener('DOMContentLoaded', function () {
    // Animar las cards al cargar
    animateCards();

    // Cargar estadísticas si el usuario está logueado
    if (document.getElementById('totalApps')) {
        loadStats();
    }

    // Agregar efectos hover a las cards
    setupHoverEffects();
});

// Función para animar las cards al cargar
function animateCards() {
    const cards = document.querySelectorAll('.hover-card');
    cards.forEach((card, index) => {
        card.style.opacity = '0';
        card.style.transform = 'translateY(20px)';

        setTimeout(() => {
            card.style.transition = 'all 0.5s ease';
            card.style.opacity = '1';
            card.style.transform = 'translateY(0)';
        }, index * 100);
    });
}

// Función para cargar estadísticas (puedes conectar esto a tu API)
function loadStats() {
    // Simular carga de datos
    setTimeout(() => {
        animateNumber('totalApps', 12);
        animateNumber('totalPermisos', 8);
        animateNumber('totalUsuarios', 25);
        animateNumber('totalAsignaciones', 45);
    }, 500);
}

// Función para animar números
function animateNumber(elementId, targetNumber) {
    const element = document.getElementById(elementId);
    if (!element) return;

    let currentNumber = 0;
    const increment = targetNumber / 20;

    const timer = setInterval(() => {
        currentNumber += increment;
        if (currentNumber >= targetNumber) {
            currentNumber = targetNumber;
            clearInterval(timer);
        }
        element.textContent = Math.floor(currentNumber);
    }, 50);
}

// Función para configurar efectos hover
function setupHoverEffects() {
    const hoverCards = document.querySelectorAll('.hover-card');

    hoverCards.forEach(card => {
        card.addEventListener('mouseenter', function () {
            this.style.transform = 'translateY(-8px)';
            this.style.boxShadow = '0 8px 25px rgba(0,0,0,0.15)';
        });

        card.addEventListener('mouseleave', function () {
            this.style.transform = 'translateY(0)';
            this.style.boxShadow = '0 2px 8px rgba(0,0,0,0.1)';
        });
    });
}

// Función para actualizar estadísticas en tiempo real (opcional)
function updateStats() {
    // Aquí puedes hacer una llamada AJAX para actualizar las estadísticas
    // Ejemplo:
    /*
    fetch('/api/stats')
        .then(response => response.json())
        .then(data => {
            document.getElementById('totalApps').textContent = data.apps;
            document.getElementById('totalPermisos').textContent = data.permisos;
            document.getElementById('totalUsuarios').textContent = data.usuarios;
            document.getElementById('totalAsignaciones').textContent = data.asignaciones;
        });
    */
}

// Función para mostrar notificaciones
function showNotification(message, type = 'info') {
    const notification = document.createElement('div');
    notification.className = `alert alert-${type} alert-dismissible fade show position-fixed`;
    notification.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
    notification.innerHTML = `
        ${message}
        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
    `;

    document.body.appendChild(notification);

    // Auto-remove después de 5 segundos
    setTimeout(() => {
        if (notification.parentNode) {
            notification.remove();
        }
    }, 5000);
}

// Función para reload de actividad reciente
function refreshActivity() {
    // Aquí puedes cargar la actividad reciente desde el servidor
    showNotification('Actividad actualizada', 'success');
}

// Event listeners adicionales
document.addEventListener('click', function (e) {
    // Si hay algún botón de refresh en las estadísticas
    if (e.target.classList.contains('refresh-stats')) {
        e.preventDefault();
        updateStats();
        showNotification('Estadísticas actualizadas', 'info');
    }

    // Si hay algún botón de refresh en la actividad
    if (e.target.classList.contains('refresh-activity')) {
        e.preventDefault();
        refreshActivity();
    }
});

// Función para manejar errores de red
function handleNetworkError(error) {
    console.error('Error de red:', error);
    showNotification('Error al conectar con el servidor', 'danger');
}

// Función para formatear fechas en actividad reciente
function formatTimeAgo(date) {
    const now = new Date();
    const diff = now - date;
    const hours = Math.floor(diff / (1000 * 60 * 60));
    const days = Math.floor(diff / (1000 * 60 * 60 * 24));

    if (days > 0) {
        return `Hace ${days} día${days > 1 ? 's' : ''}`;
    } else if (hours > 0) {
        return `Hace ${hours} hora${hours > 1 ? 's' : ''}`;
    } else {
        return 'Hace unos minutos';
    }
}
