import * as bootstrap from 'bootstrap';
import '../scss/app.scss';

// 1️⃣ Inicialización global de Bootstrap (queda como global para el DOM dinámico)
window.bootstrap = bootstrap;

// 2️⃣ Inicializar todos los dropdowns de forma automática y reutilizable
function initializeDropdowns() {
    const dropdownElements = document.querySelectorAll('[data-bs-toggle="dropdown"]');
    dropdownElements.forEach(el => {
        if (!bootstrap.Dropdown.getInstance(el)) {
            new bootstrap.Dropdown(el);
        }
    });
}

// 3️⃣ Marcar los links activos en la navegación
function highlightActiveLinks() {
    const currentPath = window.location.pathname;
    document.querySelectorAll('.nav-link, .dropdown-item').forEach(link => {
        link.classList.remove('active');
        if (link.getAttribute('href') === currentPath) {
            link.classList.add('active');
            const dropdownToggle = link.closest('.dropdown')?.querySelector('.dropdown-toggle');
            dropdownToggle?.classList.add('active');
        }
    });
}

// 4️⃣ Sidebar toggle (para móviles)
window.toggleSidebar = () => {
    document.getElementById('sidebar')?.classList.toggle('active');
};

// 5️⃣ Lógica de inicialización
function fullInitialization() {
    initializeDropdowns();
    highlightActiveLinks();
}

// 6️⃣ Inicialización en múltiples eventos para robustez
document.addEventListener('DOMContentLoaded', fullInitialization);
window.addEventListener('load', fullInitialization);
setTimeout(fullInitialization, 100);

// 7️⃣ Observer para DOM dinámico (por si agregas contenido con JS)
const observer = new MutationObserver(() => {
    initializeDropdowns();
});
observer.observe(document.body, { childList: true, subtree: true });

// 8️⃣ Progress bar
document.onreadystatechange = () => {
    const progressBar = document.getElementById('progressBar');
    const progressContainer = document.querySelector('.progress-bar-custom');
    if (!progressBar || !progressContainer) return;

    switch (document.readyState) {
        case "loading":
            progressBar.style.width = '0%';
            progressContainer.style.display = 'block';
            break;
        case "interactive":
            progressBar.style.width = '35%';
            break;
        case "complete":
            progressBar.style.width = '100%';
            setTimeout(() => { progressContainer.style.display = 'none'; }, 1000);
            break;
    }
};
