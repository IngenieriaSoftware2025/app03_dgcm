import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

// === REFERENCIAS DOM ===
const FormMovimiento = document.getElementById("FormMovimientoInventario");
const BtnGuardar = document.getElementById("BtnGuardar");
const BtnModificar = document.getElementById("BtnModificar");
const BtnLimpiar = document.getElementById("BtnLimpiar");
const BtnVerLista = document.getElementById("BtnVerLista");
const BtnNuevo = document.getElementById("BtnNuevo");
const seccionTabla = document.getElementById("seccionTabla");

// === FUNCIONES DE VISTA ===
const mostrarFormulario = () => {
    FormMovimiento.parentElement.parentElement.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    limpiarFormulario();
}

const mostrarTabla = () => {
    FormMovimiento.parentElement.parentElement.classList.add('d-none');
    seccionTabla.classList.remove('d-none');
    obtenerMovimientos();
}

// === LIMPIAR ===
const limpiarFormulario = () => {
    FormMovimiento.reset();
    BtnGuardar.classList.remove("d-none");
    BtnModificar.classList.add("d-none");
}

// === CARGAR CELULARES Y EMPLEADOS ===
const cargarCelulares = async () => {
    const url = "/app03_carbajal_clase/busca_celulares";
    const respuesta = await fetch(url);
    const datos = await respuesta.json();
    const select = document.getElementById("id_celular");

    select.innerHTML = '<option value="">Seleccione</option>';
    datos.data.forEach(cel => {
        select.innerHTML += `<option value="${cel.id_celular}">${cel.modelo}</option>`;
    });
}

const cargarEmpleados = async () => {
    const url = "/app03_carbajal_clase/busca_empleados";
    const respuesta = await fetch(url);
    const datos = await respuesta.json();
    const select = document.getElementById("id_empleado");

    select.innerHTML = '<option value="">Seleccione</option>';
    datos.data.forEach(emp => {
        select.innerHTML += `<option value="${emp.id_empleado}">${emp.codigo_empleado}</option>`;
    });
}

// === GUARDAR MOVIMIENTO ===
const guardarMovimiento = async (e) => {
    e.preventDefault();

    if (!validarFormulario(FormMovimiento)) return;

    const datos = new FormData(FormMovimiento);
    const url = "/app03_carbajal_clase/guarda_movimiento_inventario";

    const respuesta = await fetch(url, { method: "POST", body: datos });
    const resultado = await respuesta.json();

    if (resultado.codigo === 1) {
        Swal.fire("Éxito", resultado.mensaje, "success");
        limpiarFormulario();
        mostrarTabla();
    } else {
        Swal.fire("Error", resultado.mensaje, "error");
    }
}

// === BUSCAR MOVIMIENTOS ===
const datosTabla = new DataTable("#TableMovimientos", {
    language: lenguaje,
    columns: [
        { title: "ID", data: "id_movimiento" },
        { title: "Celular", data: "celular" },
        { title: "Empleado", data: "empleado" },
        { title: "Tipo", data: "tipo_movimiento" },
        { title: "Cantidad", data: "cantidad" },
        { title: "Referencia", data: "referencia" },
        {
            title: "Acciones",
            data: "id_movimiento",
            render: (data, type, row) => {
                return `
                    <button class="btn btn-warning btn-sm editar" data-id="${data}">
                        <i class="bi bi-pencil"></i>
                    </button>
                    <button class="btn btn-danger btn-sm eliminar" data-id="${data}">
                        <i class="bi bi-trash"></i>
                    </button>
                `;
            }
        }
    ]
});

const obtenerMovimientos = async () => {
    const url = "/app03_carbajal_clase/busca_movimientos_inventario";
    const respuesta = await fetch(url);
    const datos = await respuesta.json();

    datosTabla.clear().draw();
    if (datos.codigo === 1) {
        datosTabla.rows.add(datos.data).draw();
    }
}

// === EDITAR MOVIMIENTO ===
const editarMovimiento = async (id) => {
    const url = `/app03_carbajal_clase/busca_movimiento_inventario?id_movimiento=${id}`;
    const respuesta = await fetch(url);
    const datos = await respuesta.json();

    if (datos.codigo === 1) {
        const mov = datos.data[0];

        document.getElementById("id_movimiento").value = mov.id_movimiento;
        document.getElementById("id_celular").value = mov.id_celular;
        document.getElementById("id_empleado").value = mov.id_empleado;
        document.getElementById("tipo_movimiento").value = mov.tipo_movimiento;
        document.getElementById("cantidad").value = mov.cantidad;
        document.getElementById("referencia").value = mov.referencia;
        document.getElementById("motivo").value = mov.motivo;

        BtnGuardar.classList.add("d-none");
        BtnModificar.classList.remove("d-none");
        mostrarFormulario();
    }
}

// === MODIFICAR MOVIMIENTO ===
const modificarMovimiento = async (e) => {
    e.preventDefault();

    if (!validarFormulario(FormMovimiento)) return;

    const datos = new FormData(FormMovimiento);
    const url = "/app03_carbajal_clase/modifica_movimiento_inventario";

    const respuesta = await fetch(url, { method: "POST", body: datos });
    const resultado = await respuesta.json();

    if (resultado.codigo === 1) {
        Swal.fire("Modificado", resultado.mensaje, "success");
        limpiarFormulario();
        mostrarTabla();
    } else {
        Swal.fire("Error", resultado.mensaje, "error");
    }
}

// === ELIMINAR MOVIMIENTO ===
const eliminarMovimiento = async (id) => {
    const confirmacion = await Swal.fire({
        title: "¿Eliminar movimiento?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Eliminar"
    });

    if (confirmacion.isConfirmed) {
        const datos = new FormData();
        datos.append("id_movimiento", id);

        const url = "/app03_carbajal_clase/elimina_movimiento_inventario";
        const respuesta = await fetch(url, { method: "POST", body: datos });
        const resultado = await respuesta.json();

        if (resultado.codigo === 1) {
            Swal.fire("Eliminado", resultado.mensaje, "success");
            obtenerMovimientos();
        } else {
            Swal.fire("Error", resultado.mensaje, "error");
        }
    }
}

// === EVENTOS ===
FormMovimiento.addEventListener("submit", guardarMovimiento);
BtnModificar.addEventListener("click", modificarMovimiento);
BtnLimpiar.addEventListener("click", limpiarFormulario);
BtnVerLista.addEventListener("click", mostrarTabla);
BtnNuevo.addEventListener("click", mostrarFormulario);

datosTabla.on("click", ".editar", (e) => {
    const id = e.currentTarget.dataset.id;
    editarMovimiento(id);
});

datosTabla.on("click", ".eliminar", (e) => {
    const id = e.currentTarget.dataset.id;
    eliminarMovimiento(id);
});

// === INICIALIZACIÓN ===
document.addEventListener("DOMContentLoaded", async () => {
    await cargarCelulares();
    await cargarEmpleados();
    mostrarFormulario();
});
