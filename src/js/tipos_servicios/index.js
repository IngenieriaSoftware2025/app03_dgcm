import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

// Elementos
const FormTipoServicio = document.getElementById('FormTipoServicio');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnVerLista = document.getElementById('BtnVerLista');
const BtnNuevo = document.getElementById('BtnNuevo');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');

const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');
const tituloFormulario = document.getElementById('tituloFormulario');

// Funciones de visualización
const mostrarFormulario = (titulo = 'Registrar Tipo de Servicio') => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    tituloFormulario.textContent = titulo;
}

const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');
    buscarServicios();
}

// DataTable
const tablaServicios = new DataTable('#TableServicios', {
    language: lenguaje,
    data: [],
    columns: [
        { title: 'N°', data: 'id_tipo_servicio', render: (data, type, row, meta) => meta.row + 1 },
        { title: 'Descripción', data: 'descripcion' },
        { title: 'Precio Base', data: 'precio_base' },
        { title: 'Tiempo Estimado (h)', data: 'tiempo_estimado' },
        { title: 'Categoría', data: 'categoria' },
        {
            title: 'Opciones',
            data: 'id_tipo_servicio',
            render: (data, type, row) => {
                return `
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-warning modificar mx-1" 
                            data-id="${data}" 
                            data-descripcion="${row.descripcion}"
                            data-precio_base="${row.precio_base}"
                            data-tiempo_estimado="${row.tiempo_estimado}"
                            data-categoria="${row.categoria}">
                            <i class="bi bi-pencil-square me-1"></i>Modificar
                        </button>
                        <button class="btn btn-danger eliminar mx-1" data-id="${data}">
                            <i class="bi bi-trash3 me-1"></i>Eliminar
                        </button>
                    </div>
                `;
            }
        }
    ]
});

// Guardar
const guardarServicio = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormTipoServicio, ['id_tipo_servicio'])) {
        Swal.fire("Campos requeridos", "Debe completar los campos obligatorios", "warning");
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormTipoServicio);
    const url = '/app03_carbajal_clase/guardar_tipo_servicio';
    const config = { method: 'POST', body };

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            Swal.fire("¡Éxito!", datos.mensaje, "success");
            limpiarFormulario();
            mostrarTabla();
        } else {
            Swal.fire("Error", datos.mensaje, "error");
        }
    } catch (error) {
        console.error(error);
        Swal.fire("Error", "No se pudo conectar al servidor", "error");
    }
    BtnGuardar.disabled = false;
}

// Buscar
const buscarServicios = async () => {
    try {
        const respuesta = await fetch('/app03_carbajal_clase/buscar_tipo_servicio');
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            tablaServicios.clear().rows.add(datos.data).draw();
        }
    } catch (error) {
        console.error(error);
    }
}

// Llenar formulario para modificar
const llenarFormulario = (e) => {
    const datos = e.currentTarget.dataset;

    document.getElementById('id_tipo_servicio').value = datos.id;
    document.getElementById('descripcion').value = datos.descripcion;
    document.getElementById('precio_base').value = datos.precio_base;
    document.getElementById('tiempo_estimado').value = datos.tiempo_estimado;
    document.getElementById('categoria').value = datos.categoria;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');
    mostrarFormulario('Modificar Tipo de Servicio');
}

// Modificar
const modificarServicio = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormTipoServicio, [])) {
        Swal.fire("Campos requeridos", "Debe completar los campos obligatorios", "warning");
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormTipoServicio);
    const url = '/app03_carbajal_clase/modificar_tipo_servicio';
    const config = { method: 'POST', body };

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            Swal.fire("¡Actualizado!", datos.mensaje, "success");
            limpiarFormulario();
            mostrarTabla();
        } else {
            Swal.fire("Error", datos.mensaje, "error");
        }
    } catch (error) {
        console.error(error);
        Swal.fire("Error", "No se pudo conectar al servidor", "error");
    }
    BtnModificar.disabled = false;
}

// Eliminar
const eliminarServicio = async (e) => {
    const id = e.currentTarget.dataset.id;

    const confirma = await Swal.fire({
        title: "¿Eliminar?",
        text: "El registro será eliminado",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    });

    if (!confirma.isConfirmed) return;

    const body = new FormData();
    body.append('id_tipo_servicio', id);

    try {
        const respuesta = await fetch('/app03_carbajal_clase/eliminar_tipo_servicio', {
            method: 'POST',
            body
        });
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            Swal.fire("¡Eliminado!", datos.mensaje, "success");
            buscarServicios();
        } else {
            Swal.fire("Error", datos.mensaje, "error");
        }
    } catch (error) {
        console.error(error);
        Swal.fire("Error", "No se pudo conectar al servidor", "error");
    }
}

// Limpiar
const limpiarFormulario = () => {
    FormTipoServicio.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    tituloFormulario.textContent = 'Registrar Tipo de Servicio';
}

// Eventos
FormTipoServicio.addEventListener('submit', guardarServicio);
BtnModificar.addEventListener('click', modificarServicio);
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnVerLista.addEventListener('click', mostrarTabla);
BtnNuevo.addEventListener('click', () => {
    limpiarFormulario();
    mostrarFormulario();
});
BtnActualizarTabla.addEventListener('click', buscarServicios);
tablaServicios.on('click', '.modificar', llenarFormulario);
tablaServicios.on('click', '.eliminar', eliminarServicio);

// Inicial
document.addEventListener('DOMContentLoaded', () => {
    mostrarFormulario();
});
