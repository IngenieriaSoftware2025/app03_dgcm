import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

const FormDetalleVenta = document.getElementById('FormDetalleVenta');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnVerLista = document.getElementById('BtnVerLista');
const BtnNuevo = document.getElementById('BtnNuevo');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');
const seccionFormulario = FormDetalleVenta.closest('.row');
const seccionTabla = document.getElementById('seccionTabla');

// DataTable
const tabla = new DataTable('#TableDetalleVentas', {
    dom: 'Bfrtip',
    language: lenguaje,
    data: [],
    columns: [
        { title: '#', data: 'id_detalle', render: (data, type, row, meta) => meta.row + 1 },
        { title: 'Venta', data: 'id_venta' },
        { title: 'Descripción', data: 'descripcion' },
        { title: 'Cantidad', data: 'cantidad' },
        { title: 'Precio Unitario', data: 'precio_unitario' },
        { title: 'Descuento', data: 'descuento_item' },
        { title: 'Subtotal', data: 'subtotal_item' },
        {
            title: 'Opciones',
            data: null,
            render: (data, type, row) => `
                <button class="btn btn-warning btn-sm editar" data-id="${row.id_detalle}">Editar</button>
                <button class="btn btn-danger btn-sm eliminar" data-id="${row.id_detalle}">Eliminar</button>
            `
        }
    ]
});

// Mostrar formulario
const mostrarFormulario = () => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
};

// Mostrar tabla
const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');
    cargarDatos();
};

// Limpiar formulario
const limpiarFormulario = () => {
    FormDetalleVenta.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
};

// Guardar detalle
const guardarDetalle = async (e) => {
    e.preventDefault();
    if (!validarFormulario(FormDetalleVenta, ['id_detalle'])) return;

    BtnGuardar.disabled = true;
    const body = new FormData(FormDetalleVenta);

    const respuesta = await fetch('/app03_carbajal_clase/guardar_detalle_venta', { method: 'POST', body });
    const datos = await respuesta.json();

    if (datos.codigo === 1) {
        Swal.fire('Éxito', datos.mensaje, 'success');
        limpiarFormulario();
        mostrarTabla();
    } else {
        Swal.fire('Error', datos.mensaje, 'error');
    }
    BtnGuardar.disabled = false;
};

// Buscar detalles
const cargarDatos = async () => {
    const respuesta = await fetch('/app03_carbajal_clase/buscar_detalle_ventas');
    const datos = await respuesta.json();

    tabla.clear().draw();
    if (datos.codigo === 1) {
        tabla.rows.add(datos.data).draw();
    }
};

// Modificar detalle
const cargarDetalle = async (id) => {
    const respuesta = await fetch(`/app03_carbajal_clase/buscar_detalle_venta?id=${id}`);
    const { data } = await respuesta.json();

    for (let key in data) {
        if (FormDetalleVenta[key]) {
            FormDetalleVenta[key].value = data[key];
        }
    }
    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');
    mostrarFormulario();
};

const modificarDetalle = async () => {
    if (!validarFormulario(FormDetalleVenta)) return;

    BtnModificar.disabled = true;
    const body = new FormData(FormDetalleVenta);

    const respuesta = await fetch('/app03_carbajal_clase/modificar_detalle_venta', { method: 'POST', body });
    const datos = await respuesta.json();

    if (datos.codigo === 1) {
        Swal.fire('Modificado', datos.mensaje, 'success');
        limpiarFormulario();
        mostrarTabla();
    } else {
        Swal.fire('Error', datos.mensaje, 'error');
    }
    BtnModificar.disabled = false;
};

// Eliminar detalle
const eliminarDetalle = async (id) => {
    const confirmacion = await Swal.fire({
        title: '¿Eliminar?',
        text: 'Esta acción no se puede deshacer',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        confirmButtonText: 'Eliminar'
    });

    if (confirmacion.isConfirmed) {
        const body = new FormData();
        body.append('id_detalle', id);

        const respuesta = await fetch('/app03_carbajal_clase/eliminar_detalle_venta', { method: 'POST', body });
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            Swal.fire('Eliminado', datos.mensaje, 'success');
            cargarDatos();
        } else {
            Swal.fire('Error', datos.mensaje, 'error');
        }
    }
};

// Eventos
FormDetalleVenta.addEventListener('submit', guardarDetalle);
BtnModificar.addEventListener('click', modificarDetalle);
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnVerLista.addEventListener('click', mostrarTabla);
BtnNuevo.addEventListener('click', () => { limpiarFormulario(); mostrarFormulario(); });
BtnActualizarTabla.addEventListener('click', cargarDatos);

// Eventos tabla
tabla.on('click', '.editar', function () {
    const id = this.dataset.id;
    cargarDetalle(id);
});

tabla.on('click', '.eliminar', function () {
    const id = this.dataset.id;
    eliminarDetalle(id);
});

// Inicializamos
document.addEventListener('DOMContentLoaded', () => {
    mostrarFormulario();
    // Aquí podríamos precargar selects si es necesario para venta, celular y reparación
});
