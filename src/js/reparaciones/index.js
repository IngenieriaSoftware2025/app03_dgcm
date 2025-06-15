import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

// Formulario y elementos
const FormReparacion = document.getElementById('FormReparacion');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnVerLista = document.getElementById('BtnVerLista');
const BtnNuevo = document.getElementById('BtnNuevo');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');

const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');
const tituloFormulario = document.getElementById('tituloFormulario');

// Inicializar DataTable
const datosDeTabla = new DataTable('#TableReparaciones', {
    dom: "<'row justify-content-between'<'col'l><'col'B><'col-3'f>>t<'row justify-content-between'<'col-md-3'i><'col-md-8'p>>",
    language: lenguaje,
    data: [],
    columns: [
        { title: 'N°', data: 'id_reparacion', render: (data, type, row, meta) => meta.row + 1 },
        { title: 'Cliente', data: 'cliente_nombre' },
        { title: 'Modelo', data: 'modelo_celular' },
        { title: 'Motivo', data: 'motivo' },
        { title: 'Estado', data: 'estado' },
        { title: 'Prioridad', data: 'prioridad' },
        {
            title: 'Opciones', data: 'id_reparacion', render: (data, type, row) => {
                return `
                    <button class="btn btn-warning btn-sm modificar" data-id="${data}"><i class="bi bi-pencil-fill"></i></button>
                    <button class="btn btn-danger btn-sm eliminar" data-id="${data}"><i class="bi bi-trash3-fill"></i></button>
                `;
            }
        }
    ]
});

// Cambiar entre formulario y tabla
const mostrarFormulario = (titulo = 'Registrar Reparación') => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    tituloFormulario.textContent = titulo;
}

const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');
    buscaReparaciones();
}

// Limpiar formulario
const limpiarFormulario = () => {
    FormReparacion.reset();
    document.getElementById('id_reparacion').value = '';
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
    tituloFormulario.textContent = 'Registrar Reparación';
}

// Cargar combos iniciales
const cargarCombos = async () => {
    await cargarClientes();
    await cargarServicios();
}

const cargarClientes = async () => {
    const respuesta = await fetch('/app03_carbajal_clase/api/clientes');
    const datos = await respuesta.json();

    const select = document.getElementById('id_cliente');
    select.innerHTML = '<option value="">Seleccione un cliente</option>';

    datos?.data?.forEach(c => {
        select.innerHTML += `<option value="${c.id_cliente}">${c.nombres} ${c.apellidos}</option>`;
    });
}

const cargarServicios = async () => {
    const respuesta = await fetch('/app03_carbajal_clase/api/tipos_servicios');
    const datos = await respuesta.json();

    const select = document.getElementById('id_tipo_servicio');
    select.innerHTML = '<option value="">Seleccione un servicio</option>';

    datos?.data?.forEach(s => {
        select.innerHTML += `<option value="${s.id_tipo_servicio}">${s.descripcion}</option>`;
    });
}

// Guardar nueva reparación
const guardaReparacion = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormReparacion)) {
        Swal.fire({ icon: 'warning', text: 'Complete todos los campos obligatorios' });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormReparacion);
    const url = '/app03_carbajal_clase/guarda_reparacion';

    const respuesta = await fetch(url, { method: 'POST', body });
    const datos = await respuesta.json();

    if (datos.codigo === 1) {
        Swal.fire({ icon: 'success', text: datos.mensaje });
        limpiarFormulario();
        mostrarTabla();
    } else {
        Swal.fire({ icon: 'error', text: datos.mensaje });
    }

    BtnGuardar.disabled = false;
}

// Buscar reparaciones
const buscaReparaciones = async () => {
    const respuesta = await fetch('/app03_carbajal_clase/busca_reparacion');
    const datos = await respuesta.json();

    datosDeTabla.clear().draw();
    if (datos?.data?.length) {
        datosDeTabla.rows.add(datos.data).draw();
    }
}

// Modificar reparación
const modificaReparacion = async () => {
    BtnModificar.disabled = true;

    if (!validarFormulario(FormReparacion)) {
        Swal.fire({ icon: 'warning', text: 'Complete todos los campos' });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormReparacion);
    const respuesta = await fetch('/app03_carbajal_clase/modifica_reparacion', {
        method: 'POST',
        body
    });
    const datos = await respuesta.json();

    if (datos.codigo === 1) {
        Swal.fire({ icon: 'success', text: datos.mensaje });
        limpiarFormulario();
        mostrarTabla();
    } else {
        Swal.fire({ icon: 'error', text: datos.mensaje });
    }

    BtnModificar.disabled = false;
}

// Llenar formulario para modificar
const llenarFormulario = (data) => {
    document.getElementById('id_reparacion').value = data.id_reparacion;
    document.getElementById('id_cliente').value = data.id_cliente;
    document.getElementById('tipo_celular').value = data.tipo_celular;
    document.getElementById('marca_celular').value = data.marca_celular;
    document.getElementById('modelo_celular').value = data.modelo_celular;
    document.getElementById('imei').value = data.imei;
    document.getElementById('id_tipo_servicio').value = data.id_tipo_servicio;
    document.getElementById('motivo').value = data.motivo;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');
    mostrarFormulario('Modificar Reparación');
}

// Eliminar reparación
const eliminaReparacion = async (id) => {
    const confirmacion = await Swal.fire({
        icon: 'question',
        title: '¿Eliminar?',
        text: 'Esta reparación será eliminada',
        showCancelButton: true
    });

    if (!confirmacion.isConfirmed) return;

    const body = new FormData();
    body.append('id_reparacion', id);

    const respuesta = await fetch('/app03_carbajal_clase/elimina_reparacion', {
        method: 'POST',
        body
    });

    const datos = await respuesta.json();
    if (datos.codigo === 1) {
        Swal.fire({ icon: 'success', text: datos.mensaje });
        buscaReparaciones();
    } else {
        Swal.fire({ icon: 'error', text: datos.mensaje });
    }
}

// Eventos
FormReparacion.addEventListener('submit', guardaReparacion);
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnModificar.addEventListener('click', modificaReparacion);
BtnVerLista.addEventListener('click', mostrarTabla);
BtnNuevo.addEventListener('click', () => { limpiarFormulario(); mostrarFormulario(); });
BtnActualizarTabla.addEventListener('click', buscaReparaciones);

datosDeTabla.on('click', '.modificar', async function () {
    const id = this.dataset.id;
    const respuesta = await fetch(`/app03_carbajal_clase/get_reparacion?id=${id}`);
    const datos = await respuesta.json();
    if (datos.codigo === 1) {
        llenarFormulario(datos.data);
    }
});

datosDeTabla.on('click', '.eliminar', function () {
    eliminaReparacion(this.dataset.id);
});

// Inicialización
document.addEventListener('DOMContentLoaded', async () => {
    await cargarCombos();
    mostrarFormulario();
});
