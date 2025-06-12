import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario, Toast } from "../../../funciones";
import { lenguaje } from "../../../lenguaje";

// Elementos del formulario
const FormMarcas = document.getElementById('FormMarcas');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');

// Botones de navegación
const BtnVerMarcas = document.getElementById('BtnVerMarcas');
const BtnCrearMarca = document.getElementById('BtnCrearMarca');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');

// Botones de filtro
const BtnActivas = document.getElementById('BtnActivas');
const BtnInactivas = document.getElementById('BtnInactivas');

// Secciones del formulario y tabla
const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');
const tituloFormulario = document.getElementById('tituloFormulario');

// Elementos de estadísticas
const totalMarcas = document.getElementById('totalMarcas');
const marcasActivas = document.getElementById('marcasActivas');
const marcasConProductos = document.getElementById('marcasConProductos');
const marcasSinProductos = document.getElementById('marcasSinProductos');

// Variables globales
let datosDeTabla;
let filtroActual = 'activas'; // activas, inactivas, todas

// FUNCIONES DE NAVEGACIÓN

const mostrarFormulario = (titulo = 'Gestión de Marcas') => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    tituloFormulario.textContent = titulo;

    // Scroll al formulario
    seccionFormulario.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');

    // Actualizar datos automáticamente
    buscaMarcas();

    // Scroll a la tabla
    seccionTabla.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// CONFIGURACIÓN DE DATATABLE

const inicializarDataTable = () => {
    datosDeTabla = new DataTable('#TableMarcas', {
        dom: `
            <"row mt-3 justify-content-between"
                <"col" l>
                <"col" B>
                <"col-3" f>
            >
            t
            <"row mt-3 justify-content-between"
                <"col-md-3 d-flex align-items-center" i>
                <"col-md-8 d-flex justify-content-end" p>
            >
        `,
        language: lenguaje,
        data: [],
        columns: [
            {
                title: 'N°',
                data: 'id_marca',
                width: '5%',
                render: (data, type, row, meta) => meta.row + 1
            },
            {
                title: 'Nombre de la Marca',
                data: 'marca_nombre',
                width: '40%',
                render: (data, type, row) => {
                    const estado = row.situacion == 1 ? 'success' : 'secondary';
                    const icono = row.situacion == 1 ? 'check-circle' : 'x-circle';
                    return `
                        <div class="d-flex align-items-center">
                            <i class="bi bi-${icono} text-${estado} me-2"></i>
                            <strong>${data}</strong>
                        </div>
                    `;
                }
            },
            {
                title: 'Estado',
                data: 'situacion',
                width: '15%',
                render: (data, type, row) => {
                    if (data == 1) {
                        return '<span class="badge bg-success"><i class="bi bi-check-circle me-1"></i>Activa</span>';
                    } else {
                        return '<span class="badge bg-secondary"><i class="bi bi-x-circle me-1"></i>Inactiva</span>';
                    }
                }
            },
            {
                title: 'Productos',
                data: 'productos_count',
                width: '15%',
                render: (data, type, row) => {
                    const cantidad = data || 0;
                    const color = cantidad > 0 ? 'primary' : 'muted';
                    return `
                        <div class="text-center">
                            <span class="badge bg-${color}">${cantidad} celulares</span>
                        </div>
                    `;
                }
            },
            {
                title: 'Acciones',
                data: 'id_marca',
                searchable: false,
                orderable: false,
                width: '25%',
                render: (data, type, row, meta) => {
                    return `
                    <div class='d-flex justify-content-center gap-1'>
                        <button class='btn btn-warning btn-sm modificar' 
                            data-id="${data}" 
                            data-marca_nombre="${row.marca_nombre}"
                            data-situacion="${row.situacion}"
                            title="Modificar marca">
                            <i class='bi bi-pencil-square'></i>
                        </button>
                        <button class='btn btn-danger btn-sm eliminar' 
                            data-id="${data}"
                            data-marca="${row.marca_nombre}"
                            title="Eliminar marca">
                            <i class="bi bi-trash3"></i>
                        </button>
                        <button class='btn btn-info btn-sm ver-productos' 
                            data-id="${data}"
                            data-marca="${row.marca_nombre}"
                            title="Ver productos de esta marca">
                            <i class="bi bi-phone"></i>
                        </button>
                    </div>
                    `;
                }
            },
        ],
        order: [[1, 'asc']], // Ordenar por nombre de marca
        pageLength: 10,
        responsive: true
    });
}

// FUNCIONES DE API

const guardarMarca = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormMarcas, ['id_marca'])) {
        Toast.fire({
            icon: 'warning',
            title: 'Complete todos los campos obligatorios'
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormMarcas);
    const url = '/app03_dgcm/api/marcas/guardar';
    const config = { method: 'POST', body };

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            Toast.fire({
                icon: 'success',
                title: datos.mensaje
            });

            limpiarFormulario();

            setTimeout(async () => {
                const resultado = await Swal.fire({
                    title: '¿Desea ver las marcas registradas?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, ver marcas',
                    cancelButtonText: 'Seguir creando'
                });

                if (resultado.isConfirmed) {
                    mostrarTabla();
                }
            }, 1000);

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: datos.mensaje
            });
        }

    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor'
        });
    }

    BtnGuardar.disabled = false;
}

const buscaMarcas = async () => {
    try {
        let url = '/app03_dgcm/api/marcas/buscar';

        // Aplicar filtro según el estado activo
        if (filtroActual === 'inactivas') {
            // Para inactivas, necesitaríamos una API específica o modificar la existente
            url = '/app03_dgcm/api/marcas/buscar?estado=0';
        }

        const respuesta = await fetch(url);
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            // Limpiar y llenar tabla
            datosDeTabla.clear().draw();

            if (datos.data && datos.data.length > 0) {
                // Filtrar datos según el filtro actual
                let datosFiltrados = datos.data;

                if (filtroActual === 'activas') {
                    datosFiltrados = datos.data.filter(marca => marca.situacion == 1);
                } else if (filtroActual === 'inactivas') {
                    datosFiltrados = datos.data.filter(marca => marca.situacion == 0);
                }

                datosDeTabla.rows.add(datosFiltrados).draw();
                actualizarEstadisticas(datos.data);
            } else {
                actualizarEstadisticas([]);
            }

            // Actualizar estilos de botones de filtro
            actualizarBotonesFiltro();
        }

    } catch (error) {
        console.error('Error:', error);
        Toast.fire({
            icon: 'error',
            title: 'Error al cargar marcas'
        });
    }
}

const modificarMarca = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormMarcas, [])) {
        Toast.fire({
            icon: 'warning',
            title: 'Complete todos los campos obligatorios'
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormMarcas);
    const url = '/app03_dgcm/api/marcas/modificar';
    const config = { method: 'POST', body };

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            Toast.fire({
                icon: 'success',
                title: datos.mensaje
            });

            limpiarFormulario();

            setTimeout(() => {
                mostrarTabla();
            }, 1000);

        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: datos.mensaje
            });
        }

    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor'
        });
    }

    BtnModificar.disabled = false;
}

const eliminarMarca = async (e) => {
    const idMarca = e.currentTarget.dataset.id;
    const nombreMarca = e.currentTarget.dataset.marca;

    const resultado = await Swal.fire({
        title: '¿Estás seguro?',
        html: `Se eliminará la marca: <strong>${nombreMarca}</strong><br><small>Esta acción no se puede deshacer</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Sí, eliminar',
        cancelButtonText: 'Cancelar'
    });

    if (!resultado.isConfirmed) return;

    const body = new FormData();
    body.append('id_marca', idMarca);

    try {
        const respuesta = await fetch('/app03_dgcm/api/marcas/eliminar', {
            method: 'POST',
            body
        });

        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            Toast.fire({
                icon: 'success',
                title: datos.mensaje
            });
            buscaMarcas(); // Recargar tabla
        } else {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: datos.mensaje
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error de conexión',
            text: 'No se pudo conectar con el servidor'
        });
    }
}

// FUNCIONES DE FORMULARIO

const llenarFormulario = (e) => {
    const datos = e.currentTarget.dataset;

    document.getElementById('id_marca').value = datos.id;
    document.getElementById('marca_nombre').value = datos.marca_nombre;
    document.getElementById('situacion').value = datos.situacion;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    mostrarFormulario('Modificar Marca');
}

const limpiarFormulario = () => {
    FormMarcas.reset();

    // Limpiar validaciones
    const inputs = FormMarcas.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });

    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');

    tituloFormulario.textContent = 'Gestión de Marcas';
}

// FUNCIONES DE ESTADÍSTICAS

const actualizarEstadisticas = (marcas) => {
    const stats = {
        total: marcas.length,
        activas: marcas.filter(m => m.situacion == 1).length,
        conProductos: marcas.filter(m => (m.productos_count || 0) > 0).length,
        sinProductos: marcas.filter(m => (m.productos_count || 0) === 0).length
    };

    if (totalMarcas) totalMarcas.textContent = stats.total;
    if (marcasActivas) marcasActivas.textContent = stats.activas;
    if (marcasConProductos) marcasConProductos.textContent = stats.conProductos;
    if (marcasSinProductos) marcasSinProductos.textContent = stats.sinProductos;
}

const actualizarBotonesFiltro = () => {
    // Remover clases activas
    BtnActivas?.classList.remove('active');
    BtnInactivas?.classList.remove('active');

    // Agregar clase activa según filtro
    if (filtroActual === 'activas') {
        BtnActivas?.classList.add('active');
    } else if (filtroActual === 'inactivas') {
        BtnInactivas?.classList.add('active');
    }
}

// FUNCIONES ADICIONALES

const verProductosDeMarca = async (e) => {
    const idMarca = e.currentTarget.dataset.id;
    const nombreMarca = e.currentTarget.dataset.marca;

    // Aquí podrías hacer una llamada para obtener los productos de la marca
    // Por ahora, mostrar un modal informativo
    Swal.fire({
        title: `Productos de ${nombreMarca}`,
        html: 'Esta funcionalidad se implementará cuando el módulo de celulares esté completo.',
        icon: 'info',
        confirmButtonText: 'Entendido'
    });
}

// VALIDACIONES ESPECÍFICAS

const validarNombreMarca = () => {
    const marcaNombre = document.getElementById('marca_nombre');
    const valor = marcaNombre.value.trim();

    if (valor.length < 2) {
        marcaNombre.classList.add('is-invalid');
        Toast.fire({
            icon: 'warning',
            title: 'El nombre debe tener al menos 2 caracteres'
        });
        return false;
    } else {
        marcaNombre.classList.remove('is-invalid');
        marcaNombre.classList.add('is-valid');
        return true;
    }
}

// EVENT LISTENERS

// Formulario
FormMarcas?.addEventListener('submit', guardarMarca);
BtnModificar?.addEventListener('click', modificarMarca);
BtnLimpiar?.addEventListener('click', limpiarFormulario);

// Navegación
BtnVerMarcas?.addEventListener('click', mostrarTabla);
BtnCrearMarca?.addEventListener('click', () => {
    limpiarFormulario();
    mostrarFormulario('Crear Nueva Marca');
});

// Tabla
BtnActualizarTabla?.addEventListener('click', () => {
    buscaMarcas();
    Toast.fire({
        icon: 'success',
        title: 'Tabla actualizada'
    });
});

// Filtros
BtnActivas?.addEventListener('click', () => {
    filtroActual = 'activas';
    buscaMarcas();
});

BtnInactivas?.addEventListener('click', () => {
    filtroActual = 'inactivas';
    buscaMarcas();
});

// Validaciones en tiempo real
document.getElementById('marca_nombre')?.addEventListener('blur', validarNombreMarca);

// INICIALIZACIÓN

document.addEventListener('DOMContentLoaded', () => {
    inicializarDataTable();
    mostrarFormulario('Gestión de Marcas');

    // Event listeners de DataTable (después de inicializar)
    if (datosDeTabla) {
        datosDeTabla.on('click', '.modificar', llenarFormulario);
        datosDeTabla.on('click', '.eliminar', eliminarMarca);
        datosDeTabla.on('click', '.ver-productos', verProductosDeMarca);
    }
});