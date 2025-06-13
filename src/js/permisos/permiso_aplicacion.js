import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

// === VARIABLES GLOBALES ===
const Form = document.getElementById('FormPermisoAplicacion');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnVerTabla = document.getElementById('BtnVerTabla');
const BtnCrearNuevaRelacion = document.getElementById('BtnCrearNuevaRelacion');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');

const selectPermiso = document.getElementById('id_permiso');
const selectApp = document.getElementById('id_app');

const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');

// === DATATABLE ===
const tabla = new DataTable('#TablePermisoAplicacion', {
    dom: `<"row mt-3 justify-content-between"<"col" l><"col" B><"col-3" f>>t<"row mt-3 justify-content-between"<"col-md-3" i><"col-md-8" p>>`,
    language: lenguaje,
    data: [],
    columns: [
        { title: '#', data: 'id_permiso_app', render: (data, type, row, meta) => meta.row + 1 },
        { title: 'Permiso', data: 'nombre_permiso' },
        { title: 'Clave', data: 'clave_permiso' },
        { title: 'Descripción', data: 'descripcion_permiso' },
        { title: 'Aplicación', data: 'nombre_aplicacion' },
        {
            title: 'Acciones',
            data: 'id_permiso_app',
            render: data => `<button class="btn btn-danger btn-sm eliminar" data-id="${data}"><i class="bi bi-trash3"></i></button>`
        }
    ]
});

// === FUNCIONES PARA CAMBIO DE VISTA ===
const mostrarFormulario = () => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    Form.reset();
};

const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');
    buscar();
};

// === CARGA DE PERMISOS ===
const cargarPermisos = async () => {
    const resp = await fetch('/app03_carbajal_clase/busca_permiso');
    const data = await resp.json();
    selectPermiso.innerHTML = '<option value="">Seleccione un permiso</option>';
    data.data.forEach(p => {
        const opt = document.createElement('option');
        opt.value = p.id_permiso;
        opt.textContent = `${p.nombre_permiso} (${p.descripcion})`;
        selectPermiso.appendChild(opt);
    });
};

// === CARGA DE APLICACIONES ===
const cargarAplicaciones = async () => {
    const resp = await fetch('/app03_carbajal_clase/busca_aplicacion');
    const data = await resp.json();
    selectApp.innerHTML = '<option value="">Seleccione una aplicación</option>';
    data.data.forEach(app => {
        const opt = document.createElement('option');
        opt.value = app.id_app;
        opt.textContent = app.nombre_app_md;
        selectApp.appendChild(opt);
    });
};

// === BUSCAR DATOS ===
const buscar = async () => {
    const resp = await fetch('/app03_carbajal_clase/busca_permiso_aplicacion');
    const data = await resp.json();
    tabla.clear().rows.add(data.data).draw();
};

// === GUARDAR DATOS ===
const guardar = async (e) => {
    e.preventDefault();
    if (!validarFormulario(Form, [])) {
        Swal.fire("Complete todos los campos", "", "warning");
        return;
    }
    const body = new FormData(Form);
    const resp = await fetch('/app03_carbajal_clase/guarda_permiso_aplicacion', { method: 'POST', body });
    const data = await resp.json();
    if (data.codigo === 1) {
        Swal.fire("Guardado!", "", "success");
        buscar();
        Form.reset();
    } else {
        Swal.fire("Error!", data.mensaje, "error");
    }
};

// === ELIMINAR REGISTRO ===
const eliminar = async (e) => {
    const id = e.target.dataset.id;
    const confirm = await Swal.fire({ title: "¿Eliminar?", showCancelButton: true, confirmButtonColor: "#d33" });
    if (!confirm.isConfirmed) return;

    const body = new FormData();
    body.append('id_permiso_app', id);
    const resp = await fetch('/app03_carbajal_clase/elimina_permiso_aplicacion', { method: 'POST', body });
    const data = await resp.json();

    if (data.codigo === 1) {
        Swal.fire("Eliminado!", "", "success");
        buscar();
    } else {
        Swal.fire("Error!", data.mensaje, "error");
    }
};

// === EVENTOS ===
tabla.on('click', '.eliminar', eliminar);
Form.addEventListener('submit', guardar);
BtnVerTabla.addEventListener('click', mostrarTabla);
BtnCrearNuevaRelacion.addEventListener('click', mostrarFormulario);
BtnActualizarTabla.addEventListener('click', () => {
    buscar();
    Swal.fire("Actualizado!", "", "success");
});

// === INICIALIZACIÓN ===
document.addEventListener('DOMContentLoaded', async () => {
    await cargarPermisos();
    await cargarAplicaciones();
    mostrarFormulario();
});
