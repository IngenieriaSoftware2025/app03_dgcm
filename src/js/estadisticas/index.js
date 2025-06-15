import { Dropdown } from "bootstrap";

document.addEventListener('DOMContentLoaded', () => {
    cargarEstadisticas();
});

async function cargarEstadisticas() {
    try {
        const respuesta = await fetch('/app03_carbajal_clase/estadisticas_datos');
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            const info = datos.data;
            document.getElementById('totalClientes').textContent = info.clientes;
            document.getElementById('totalVentas').textContent = info.ventas;
            document.getElementById('totalReparaciones').textContent = info.reparaciones;
            document.getElementById('totalInventario').textContent = info.inventario;
            document.getElementById('ingresosVentas').textContent = parseFloat(info.ingresosVentas).toFixed(2);
            document.getElementById('ingresosReparaciones').textContent = parseFloat(info.ingresosReparaciones).toFixed(2);
        }
    } catch (error) {
        console.error('Error al obtener estadísticas:', error);
    }
}
