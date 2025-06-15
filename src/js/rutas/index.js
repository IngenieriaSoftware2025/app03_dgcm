import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

const FormRuta = document.getElementById("FormRuta");
const BtnGuardar = document.getElementById("BtnGuardar");
const BtnModificar = document.getElementById("BtnModificar");
const BtnLimpiar = document.getElementById("BtnLimpiar");
const BtnVerLista = document.getElementById("BtnVerLista");
const BtnNuevo = document.getElementById("BtnNuevo");
const seccionTabla = document.getElementById("seccionTabla");

// Vista
const mostrarFormulario = () => {
    FormRuta.parentElement.parentElement.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    limpiarFormulario();
};

const mostrarTabla = () => {
    FormRuta.parentElement.parentElement.classList.add('d-none');
    seccionTabla.classList.remove('d-none');
    obtenerRutas();
};

const limpiarFormulario = () => {
    FormRuta.reset();
    BtnGuardar.classList.remove("d-none");
    BtnModificar.classList.add("d-none");
};

// Cargar aplicaciones para el select
const cargarAplicaciones = async () => {
    const url = "/app03_carbajal_clase/busca_aplicaciones";
    const respuesta = await fetch(url);
    const datos = await respuesta.json();
    const select = document.getElementById("id_app");

    select.innerHTML = '<option value="">Seleccione</option>';
    datos.data.forEach(app => {
        select.innerHTML += `<option value="${app.id_app}">${app.nombre_app_md}</option>`;
    });
};

// Guardar ruta
const guardarRuta = async (e) => {
    e.preventDefault();

    if (!validarFormulario(FormRuta)) return;

    const datos = new FormData(FormRuta);
    const url = "/app03_carbajal_clase/guarda_ruta";

    const respuesta = await fetch(url, { method: "POST", body: datos });
    const resultado = await respuesta.json();

    if (resultado.codigo === 1) {
        Swal.fire("Éxito", resultado.mensaje, "success");
        limpiarFormulario();
        mostrarTabla();
    } else {
        Swal.fire("Error", resultado.mensaje, "error");
    }
};

// Buscar rutas
const datosTabla = new DataTable("#TableRutas", {
    language: lenguaje,
    columns: [
        { title: "ID", data: "id_ruta" },
        { title: "Aplicación", data: "nombre_app_md" },
        { title: "Descripción", data: "descripcion" },
        {
            title: "Acciones",
            data: "id_ruta",
            render: (data) => {
                return `
                    <button class="btn btn-warning btn-sm editar" data-id="${data}"><i class="bi bi-pencil"></i></button>
                    <button class="btn btn-danger btn-sm eliminar" data-id="${data}"><i class="bi bi-trash"></i></button>
                `;
            }
        }
    ]
});

const obtenerRutas = async () => {
    const url = "/app03_carbajal_clase/busca_rutas";
    const respuesta = await fetch(url);
    const datos = await respuesta.json();

    datosTabla.clear().draw();
    if (datos.codigo === 1) {
        datosTabla.rows.add(datos.data).draw();
    }
};

// Editar ruta
const editarRuta = async (id) => {
    const url = `/app03_carbajal_clase/busca_ruta?id_ruta=${id}`;
    const respuesta = await fetch(url);
    const datos = await respuesta.json();

    if (datos.codigo === 1) {
        const ruta = datos.data[0];
        document.getElementById("id_ruta").value = ruta.id_ruta;
        document.getElementById("id_app").value = ruta.id_app;
        document.getElementById("descripcion").value = ruta.descripcion;

        BtnGuardar.classList.add("d-none");
        BtnModificar.classList.remove("d-none");
        mostrarFormulario();
    }
};

// Modificar ruta
const modificarRuta = async (e) => {
    e.preventDefault();

    if (!validarFormulario(FormRuta)) return;

    const datos = new FormData(FormRuta);
    const url = "/app03_carbajal_clase/modifica_ruta";

    const respuesta = await fetch(url, { method: "POST", body: datos });
    const resultado = await respuesta.json();

    if (resultado.codigo === 1) {
        Swal.fire("Modificado", resultado.mensaje, "success");
        limpiarFormulario();
        mostrarTabla();
    } else {
        Swal.fire("Error", resultado.mensaje, "error");
    }
};

// Eliminar ruta
const eliminarRuta = async (id) => {
    const confirmacion = await Swal.fire({
        title: "¿Eliminar ruta?",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Eliminar"
    });

    if (confirmacion.isConfirmed) {
        const datos = new FormData();
        datos.append("id_ruta", id);

        const url = "/app03_carbajal_clase/elimina_ruta";
        const respuesta = await fetch(url, { method: "POST", body: datos });
        const resultado = await respuesta.json();

        if (resultado.codigo === 1) {
            Swal.fire("Eliminado", resultado.mensaje, "success");
            obtenerRutas();
        } else {
            Swal.fire("Error", resultado.mensaje, "error");
        }
    }
};

// Eventos
FormRuta.addEventListener("submit", guardarRuta);
BtnModificar.addEventListener("click", modificarRuta);
BtnLimpiar.addEventListener("click", limpiarFormulario);
BtnVerLista.addEventListener("click", mostrarTabla);
BtnNuevo.addEventListener("click", mostrarFormulario);

datosTabla.on("click", ".editar", (e) => editarRuta(e.currentTarget.dataset.id));
datosTabla.on("click", ".eliminar", (e) => eliminarRuta(e.currentTarget.dataset.id));

// Inicialización
document.addEventListener("DOMContentLoaded", async () => {
    await cargarAplicaciones();
    mostrarFormulario();
});
