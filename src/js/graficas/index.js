import { Dropdown } from "bootstrap";
import Swal from 'sweetalert2';
import { validarFormulario } from '../funciones';
import { lenguaje } from "../lenguaje";
import Chart from "chart.js/auto";

const miGraficoProductos = document.getElementById('miGraficoProductos').getContext('2d');
const miGraficoVentas = document.getElementById('miGraficoVentas').getContext('2d');
const miGraficoClientes = document.getElementById('miGraficoClientes').getContext('2d');

// Función para obtener datos de las gráficas
const obtenerDatosGraficas = async () => {
    const url = '/app03_carbajal_clase/graficas/datos';
    const config = { method: 'GET' };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        if (data.codigo === 1) {
            console.log("Datos para gráficos:", data);

            // Gráfico de productos más vendidos
            const etiquetasProductos = data.productos.map(d => d.producto_nombre);
            const cantidadesProductos = data.productos.map(d => d.cantidad_total);

            new Chart(miGraficoProductos, {
                type: 'bar',
                data: {
                    labels: etiquetasProductos,
                    datasets: [{
                        label: 'Productos más vendidos',
                        data: cantidadesProductos,
                        backgroundColor: 'rgba(75, 192, 192, 0.2)',
                        borderColor: 'rgba(75, 192, 192, 1)',
                        borderWidth: 1
                    }]
                }
            });

            // Gráfico de ventas por mes
            const etiquetasVentas = data.ventasMeses.map(d => `${d.mes}/${d.anio}`);
            const ingresosVentas = data.ventasMeses.map(d => d.ingresos);

            new Chart(miGraficoVentas, {
                type: 'line',
                data: {
                    labels: etiquetasVentas,
                    datasets: [{
                        label: 'Ventas por mes',
                        data: ingresosVentas,
                        borderColor: '#FF5733',
                        backgroundColor: 'rgba(255, 87, 51, 0.2)',
                        borderWidth: 1
                    }]
                }
            });

            // Gráfico de clientes con más productos
            const clientesNombres = data.clientes.map(d => d.cliente_nombre);
            const productosClientes = data.clientes.map(d => d.total_productos);

            new Chart(miGraficoClientes, {
                type: 'pie',
                data: {
                    labels: clientesNombres,
                    datasets: [{
                        label: 'Clientes con más productos comprados',
                        data: productosClientes,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#FF9F40', '#4BC0C0']
                    }]
                }
            });
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: data.mensaje
            });
        }
    } catch (error) {
        console.error('Error al obtener los datos:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudieron cargar los datos para las gráficas.'
        });
    }
};

// Llamamos a la función al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    obtenerDatosGraficas();
});
