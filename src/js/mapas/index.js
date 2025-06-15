import { Dropdown } from "bootstrap";
import L from 'leaflet';

console.log('Cargando mapa interactivo...');

let map;

// Coordenadas de la tienda (Ajusta la latitud y longitud según tu ubicación)
const ubicacionTienda = [15.7835, -90.2308]; // Ajusta la ubicación de tu tienda

const inicializarMapa = () => {
    try {
        // Crear el mapa centrado en la ubicación de la tienda
        map = L.map('mapaTiendas').setView(ubicacionTienda, 16); // Zoom 16 para ver bien la tienda

        // Agregar capa satelital (usando Mapbox)
        L.tileLayer('https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token={accessToken}', {
            attribution: '© <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, © <a href="https://www.mapbox.com/about/maps/">Mapbox</a>',
            maxZoom: 19,
            id: 'mapbox/satellite-v9', // Estilo satelital de Mapbox
            accessToken: 'tu-mapbox-access-token' // Asegúrate de tener tu token de Mapbox
        }).addTo(map);

        // Agregar un marcador en la ubicación de la tienda
        const marker = L.marker(ubicacionTienda).addTo(map);
        marker.bindPopup('<b>Nuestra Tienda</b><br>¡Te esperamos!').openPopup();

        // Despliegue el mapa hacia la ubicación
        map.setView(ubicacionTienda, 16); // Focaliza y hace zoom hacia la tienda

        console.log('Mapa cargado correctamente con satélite.');

    } catch (error) {
        console.error('Error al inicializar el mapa:', error);
    }
};

// Inicializar mapa al cargar el DOM
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        inicializarMapa();
    }, 100);
});
