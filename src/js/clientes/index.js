import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

// Elementos
const FormCliente = document.getElementById("FormCliente");
const BtnGuardar = document.getElementById("BtnGuardar");
const BtnModificar = document.getElementById("BtnModificar");
const BtnLimpiar = document.getElementById("BtnLimpiar");
const BtnVerClientes = document.getElementById("BtnVerClientes");
const BtnCrearCliente = document.getElementById("BtnCrearCliente");
const BtnActualizarTabla = document.getElementById("BtnActualizarTabla");
const tituloFormulario = document.getElementById("tituloFormulario");

// Secciones
const seccionFormulario = document.getElementById("seccionFormulario");
const seccionTabla = document.getElementById("seccionTabla");

// DataTable
const tablaClientes = new DataTable("#TableClientes", {
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
            title: "N°",
            data: "id_cliente",
            render: (data, type, row, meta) => meta.row + 1,
        },
        { title: "Nombres", data: "nombres" },
        { title: "Apellidos", data: "apellidos" },
        { title: "Teléfono", data: "telefono" },
        { title: "Celular", data: "celular" },
        { title: "NIT", data: "nit" },
        { title: "Correo", data: "correo" },
        { title: "Dirección", data: "direccion" },
        {
            title: "Opciones",
            data: "id_cliente",
            render: (data, type, row) => `
            <div class="d-flex justify-content-center">
                <button class="btn btn-warning modificar mx-1"
                    data-id="${row.id_cliente}"
                    data-nombres="${row.nombres}"
                    data-apellidos="${row.apellidos}"
                    data-telefono="${row.telefono || ''}"
                    data-celular="${row.celular || ''}"
                    data-nit="${row.nit || ''}"
                    data-correo="${row.correo || ''}"
                    data-direccion="${row.direccion || ''}">
                    <i class="bi bi-pencil-square me-1"></i> Modificar
                </button>
                <button class="btn btn-danger eliminar mx-1" data-id="${row.id_cliente}">
                    <i class="bi bi-trash3 me-1"></i> Eliminar
                </button>
            </div>
        `,
        },
    ],
});

// Mostrar Formulario
const mostrarFormulario = (titulo = "Registrar Cliente") => {
    seccionFormulario.classList.remove("d-none");
    seccionTabla.classList.add("d-none");
    tituloFormulario.textContent = titulo;
};

// Mostrar Tabla
const mostrarTabla = () => {
    seccionFormulario.classList.add("d-none");
    seccionTabla.classList.remove("d-none");
    buscarClientes();
};

// Buscar clientes
const buscarClientes = async () => {
    try {
        const res = await fetch("/app03_carbajal_clase/buscar_clientes");
        const datos = await res.json();

        if (datos.codigo === 1) {
            tablaClientes.clear().rows.add(datos.data).draw();
        }
    } catch (error) {
        console.error(error);
    }
};

// Guardar cliente
const guardarCliente = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormCliente, ["id_cliente"])) {
        Swal.fire("Complete los campos requeridos", "", "warning");
        BtnGuardar.disabled = false;
        return;
    }

    const formData = new FormData(FormCliente);
    const res = await fetch("/app03_carbajal_clase/guardar_cliente", {
        method: "POST",
        body: formData,
    });
    const datos = await res.json();

    if (datos.codigo === 1) {
        Swal.fire("Cliente guardado", datos.mensaje, "success");
        limpiarFormulario();
        mostrarTabla();
    } else {
        Swal.fire("Error", datos.mensaje, "error");
    }

    BtnGuardar.disabled = false;
};

// Modificar cliente
const modificarCliente = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormCliente)) {
        Swal.fire("Complete los campos requeridos", "", "warning");
        BtnModificar.disabled = false;
        return;
    }

    const formData = new FormData(FormCliente);
    const res = await fetch("/app03_carbajal_clase/modificar_cliente", {
        method: "POST",
        body: formData,
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

// Eliminar cliente
const eliminarCliente = async (e) => {
    const id = e.currentTarget.dataset.id;

    const confirmacion = await Swal.fire({
        title: "¿Eliminar cliente?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
    });

    if (!confirmacion.isConfirmed) return;

    const formData = new FormData();
    formData.append("id_cliente", id);

    const res = await fetch("/app03_carbajal_clase/eliminar_cliente", {
        method: "POST",
        body: formData,
    });

    const datos = await res.json();

    if (datos.codigo === 1) {
        Swal.fire("Eliminado", datos.mensaje, "success");
        buscarClientes();
    } else {
        Swal.fire("Error", datos.mensaje, "error");
    }
};

// Llenar Formulario para modificar
const llenarFormulario = (e) => {
    const data = e.currentTarget.dataset;

    document.getElementById("id_cliente").value = data.id;
    document.getElementById("nombres").value = data.nombres;
    document.getElementById("apellidos").value = data.apellidos;
    document.getElementById("telefono").value = data.telefono;
    document.getElementById("celular").value = data.celular;
    document.getElementById("nit").value = data.nit;
    document.getElementById("correo").value = data.correo;
    document.getElementById("direccion").value = data.direccion;

    BtnGuardar.classList.add("d-none");
    BtnModificar.classList.remove("d-none");
    mostrarFormulario("Modificar Cliente");
};

// Limpiar formulario
const limpiarFormulario = () => {
    FormCliente.reset();
    BtnGuardar.classList.remove("d-none");
    BtnModificar.classList.add("d-none");
    tituloFormulario.textContent = "Registrar Cliente";
};

// Eventos
FormCliente.addEventListener("submit", guardarCliente);
BtnModificar.addEventListener("click", modificarCliente);
BtnLimpiar.addEventListener("click", limpiarFormulario);
BtnVerClientes.addEventListener("click", mostrarTabla);
BtnCrearCliente.addEventListener("click", () => {
    limpiarFormulario();
    mostrarFormulario("Registrar Cliente");
});
BtnActualizarTabla.addEventListener("click", () => {
    buscarClientes();
    Swal.fire("Lista actualizada", "", "success");
});

// Eventos de la tabla
tablaClientes.on("click", ".modificar", llenarFormulario);
tablaClientes.on("click", ".eliminar", eliminarCliente);

// Inicialización
document.addEventListener("DOMContentLoaded", () => {
    mostrarFormulario();
});
