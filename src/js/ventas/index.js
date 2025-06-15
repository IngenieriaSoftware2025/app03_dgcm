import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

const FormVenta = document.getElementById('FormVenta');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnVerLista = document.getElementById('BtnVerLista');
const BtnNuevo = document.getElementById('BtnNuevo');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');

const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');
const tituloFormulario = document.getElementById('tituloFormulario');

const mostrarFormulario = (titulo = 'Registrar Venta') => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    tituloFormulario.textContent = titulo;
}

const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');
    buscarVentas();
}

const datosDeTabla = new DataTable('#TableVentas', {
    dom: 'Bfrtip',
    language: lenguaje,
    data: [],
    columns: [
        { title: 'N°', data: null, render: (data, type, row, meta) => meta.row + 1 },
        { title: 'Factura', data: 'numero_factura' },
        { title: 'Cliente', data: 'nombre_cliente' },
        { title: 'Empleado', data: 'nombre_empleado' },
        { title: 'Tipo', data: 'tipo_venta' },
        { title: 'Total', data: 'total' },
        {
            title: 'Opciones', data: 'id_venta', render: (data, type, row) => {
                return `
                <button class="btn btn-warning modificar mx-1" data-id="${data}"><i class="bi bi-pencil-square"></i></button>
                <button class="btn btn-danger eliminar mx-1" data-id="${data}"><i class="bi bi-trash"></i></button>`;
            }
        }
    ]
});

const guardarVenta = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormVenta)) {
        Swal.fire({ icon: "warning", title: "Complete todos los campos" });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormVenta);
    const url = '/app03_carbajal_clase/guardar_venta';

    try {
        const respuesta = await fetch(url, { method: 'POST', body });
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            Swal.fire({ icon: "success", title: datos.mensaje });
            limpiarFormulario();
            mostrarTabla();
        } else {
            Swal.fire({ icon: "error", title: datos.mensaje });
        }
    } catch (err) {
        console.error(err);
        Swal.fire({ icon: "error", title: "Error de conexión" });
    }
    BtnGuardar.disabled = false;
}

const buscarVentas = async () => {
    const url = '/app03_carbajal_clase/buscar_ventas';
    try {
        const resp = await fetch(url);
        const datos = await resp.json();
        if (datos.codigo === 1) {
            datosDeTabla.clear().rows.add(datos.data).draw();
        }
    } catch (err) {
        console.error(err);
    }
}

const limpiarFormulario = () => {
    FormVenta.reset();
    document.getElementById('id_venta').value = '';
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    tituloFormulario.textContent = 'Registrar Venta';
}

const llenarFormulario = (e) => {
    const id = e.currentTarget.dataset.id;
    fetch(`/app03_carbajal_clase/buscar_venta?id_venta=${id}`)
        .then(res => res.json())
        .then(datos => {
            if (datos.codigo === 1) {
                const venta = datos.data;
                document.getElementById('id_venta').value = venta.id_venta;
                document.getElementById('id_cliente').value = venta.id_cliente;
                document.getElementById('id_empleado_vendedor').value = venta.id_empleado_vendedor;
                document.getElementById('numero_factura').value = venta.numero_factura;
                document.getElementById('tipo_venta').value = venta.tipo_venta;
                document.getElementById('subtotal').value = venta.subtotal;
                document.getElementById('descuento').value = venta.descuento;
                document.getElementById('total').value = venta.total;
                document.getElementById('metodo_pago').value = venta.metodo_pago;
                document.getElementById('observaciones').value = venta.observaciones;

                BtnGuardar.classList.add('d-none');
                BtnModificar.classList.remove('d-none');
                mostrarFormulario('Modificar Venta');
            }
        });
}

const modificarVenta = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormVenta)) {
        Swal.fire({ icon: "warning", title: "Complete todos los campos" });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormVenta);
    const url = '/app03_carbajal_clase/modificar_venta';

    try {
        const resp = await fetch(url, { method: 'POST', body });
        const datos = await resp.json();

        if (datos.codigo === 1) {
            Swal.fire({ icon: "success", title: datos.mensaje });
            limpiarFormulario();
            mostrarTabla();
        } else {
            Swal.fire({ icon: "error", title: datos.mensaje });
        }
    } catch (err) {
        console.error(err);
        Swal.fire({ icon: "error", title: "Error de conexión" });
    }
    BtnModificar.disabled = false;
}

const eliminarVenta = async (e) => {
    const id = e.currentTarget.dataset.id;
    const confirmar = await Swal.fire({
        title: "¿Eliminar venta?",
        icon: "question",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    });

    if (!confirmar.isConfirmed) return;

    const body = new FormData();
    body.append('id_venta', id);

    try {
        const resp = await fetch('/app03_carbajal_clase/eliminar_venta', { method: 'POST', body });
        const datos = await resp.json();

        if (datos.codigo === 1) {
            Swal.fire({ icon: "success", title: datos.mensaje });
            buscarVentas();
        } else {
            Swal.fire({ icon: "error", title: datos.mensaje });
        }
    } catch (err) {
        console.error(err);
        Swal.fire({ icon: "error", title: "Error al eliminar" });
    }
}

document.addEventListener('DOMContentLoaded', () => {
    mostrarFormulario();
    buscarVentas();
    cargarCombos();
});

FormVenta.addEventListener('submit', guardarVenta);
BtnModificar.addEventListener('click', modificarVenta);
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnVerLista.addEventListener('click', mostrarTabla);
BtnNuevo.addEventListener('click', () => { limpiarFormulario(); mostrarFormulario(); });
BtnActualizarTabla.addEventListener('click', buscarVentas);

datosDeTabla.on('click', '.modificar', llenarFormulario);
datosDeTabla.on('click', '.eliminar', eliminarVenta);

// Cargar combos cliente y empleados
const cargarCombos = async () => {
    const cargar = async (url, selectId) => {
        const resp = await fetch(url);
        const datos = await resp.json();
        const select = document.getElementById(selectId);
        if (datos.codigo === 1) {
            datos.data.forEach(item => {
                const option = document.createElement('option');
                option.value = item.id;
                option.textContent = item.nombre;
                select.appendChild(option);
            });
        }
    }

    await cargar('/app03_carbajal_clase/comboclientes', 'id_cliente');
    await cargar('/app03_carbajal_clase/comboempleados', 'id_empleado_vendedor');
}
