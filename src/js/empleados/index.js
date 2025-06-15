import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

const FormEmpleados = document.getElementById("FormEmpleados");
const BtnGuardar = document.getElementById("BtnGuardar");
const BtnModificar = document.getElementById("BtnModificar");
const BtnLimpiar = document.getElementById("BtnLimpiar");
const BtnVerRegistros = document.getElementById("BtnVerRegistros");
const BtnCrearNuevo = document.getElementById("BtnCrearNuevo");
const BtnActualizarTabla = document.getElementById("BtnActualizarTabla");

const seccionFormulario = document.getElementById("seccionFormulario");
const seccionTabla = document.getElementById("seccionTabla");
const tituloFormulario = document.getElementById("tituloFormulario");

const mostrarFormulario = (titulo = "Registrar Empleado") => {
    seccionFormulario.classList.remove("d-none");
    seccionTabla.classList.add("d-none");
    tituloFormulario.textContent = titulo;
};

const mostrarTabla = () => {
    seccionFormulario.classList.add("d-none");
    seccionTabla.classList.remove("d-none");
    buscarEmpleados();
};

const datosDeTabla = new DataTable("#TableEmpleados", {
    language: lenguaje,
    data: [],
    columns: [
        {
            title: "N°",
            data: "id_empleado",
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: "Código", data: "codigo_empleado" },
        { title: "Puesto", data: "puesto" },
        { title: "Salario", data: "salario" },
        { title: "Ingreso", data: "fecha_ingreso" },
        { title: "Especialidad", data: "especialidad" },
        {
            title: "Opciones",
            data: "id_empleado",
            render: (data, type, row) => {
                return `
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-warning modificar mx-1" 
                            data-id="${data}"
                            data-id_usuario="${row.id_usuario}"
                            data-codigo_empleado="${row.codigo_empleado}"
                            data-puesto="${row.puesto || ''}"
                            data-salario="${row.salario || ''}"
                            data-fecha_ingreso="${row.fecha_ingreso || ''}"
                            data-especialidad="${row.especialidad || ''}">
                            <i class="bi bi-pencil-square me-1"></i> Modificar
                        </button>
                        <button class="btn btn-danger eliminar mx-1" data-id="${data}">
                            <i class="bi bi-trash3 me-1"></i> Eliminar
                        </button>
                    </div>`;
            }
        },
    ],
});

const buscarUsuarios = async () => {
    const url = "/app03_carbajal_clase/busca_usuario";
    const res = await fetch(url);
    const { data } = await res.json();

    const select = document.getElementById("id_usuario");
    select.innerHTML = `<option value="">Seleccione...</option>`;
    data.forEach((usuario) => {
        const nombre = `${usuario.nombre1} ${usuario.apellido1}`;
        select.innerHTML += `<option value="${usuario.id_usuario}">${nombre}</option>`;
    });
};

const guardarEmpleado = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormEmpleados)) {
        Swal.fire("Atención", "Complete los campos obligatorios", "warning");
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormEmpleados);
    const res = await fetch("/app03_carbajal_clase/guardar_empleado", {
        method: "POST",
        body
    });

    const datos = await res.json();
    if (datos.codigo === 1) {
        Swal.fire("Éxito", datos.mensaje, "success");
        limpiarFormulario();
        mostrarTabla();
    } else {
        Swal.fire("Error", datos.mensaje, "error");
    }

    BtnGuardar.disabled = false;
};

const buscarEmpleados = async () => {
    const url = "/app03_carbajal_clase/buscar_empleados";
    const res = await fetch(url);
    const { data } = await res.json();
    datosDeTabla.clear().rows.add(data).draw();
};

const llenarFormulario = (e) => {
    const datos = e.currentTarget.dataset;

    document.getElementById("id_empleado").value = datos.id;
    document.getElementById("id_usuario").value = datos.id_usuario;
    document.getElementById("codigo_empleado").value = datos.codigo_empleado;
    document.getElementById("puesto").value = datos.puesto;
    document.getElementById("salario").value = datos.salario;
    document.getElementById("fecha_ingreso").value = datos.fecha_ingreso;
    document.getElementById("especialidad").value = datos.especialidad;

    BtnGuardar.classList.add("d-none");
    BtnModificar.classList.remove("d-none");
    mostrarFormulario("Modificar Empleado");
};

const limpiarFormulario = () => {
    FormEmpleados.reset();
    BtnGuardar.classList.remove("d-none");
    BtnModificar.classList.add("d-none");
};

const modificarEmpleado = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormEmpleados)) {
        Swal.fire("Atención", "Complete los campos obligatorios", "warning");
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormEmpleados);
    const res = await fetch("/app03_carbajal_clase/modificar_empleado", {
        method: "POST",
        body
    });

    const datos = await res.json();
    if (datos.codigo === 1) {
        Swal.fire("Modificado", datos.mensaje, "success");
        limpiarFormulario();
        mostrarTabla();
    } else {
        Swal.fire("Error", datos.mensaje, "error");
    }

    BtnModificar.disabled = false;
};

const eliminarEmpleado = async (e) => {
    const id = e.currentTarget.dataset.id;

    const confirm = await Swal.fire({
        title: "¿Seguro?",
        text: "El registro será eliminado",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    });

    if (!confirm.isConfirmed) return;

    const body = new FormData();
    body.append("id_empleado", id);

    const res = await fetch("/app03_carbajal_clase/eliminar_empleado", {
        method: "POST",
        body
    });

    const datos = await res.json();
    if (datos.codigo === 1) {
        Swal.fire("Eliminado", datos.mensaje, "success");
        buscarEmpleados();
    } else {
        Swal.fire("Error", datos.mensaje, "error");
    }
};

// Eventos
FormEmpleados.addEventListener("submit", guardarEmpleado);
BtnModificar.addEventListener("click", modificarEmpleado);
BtnLimpiar.addEventListener("click", limpiarFormulario);
BtnVerRegistros.addEventListener("click", mostrarTabla);
BtnCrearNuevo.addEventListener("click", () => {
    limpiarFormulario();
    mostrarFormulario();
});
BtnActualizarTabla.addEventListener("click", buscarEmpleados);

datosDeTabla.on("click", ".modificar", llenarFormulario);
datosDeTabla.on("click", ".eliminar", eliminarEmpleado);

// Inicialización
document.addEventListener("DOMContentLoaded", () => {
    buscarUsuarios();
    mostrarFormulario();
});
