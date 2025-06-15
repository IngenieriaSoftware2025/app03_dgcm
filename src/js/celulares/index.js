import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

// Variables globales
const FormCelulares = document.getElementById('FormCelulares');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnVerRegistros = document.getElementById('BtnVerRegistros');
const BtnCrearNuevo = document.getElementById('BtnCrearNuevo');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');

const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');
const tituloFormulario = document.getElementById('tituloFormulario');

// Mostrar formulario
const mostrarFormulario = (titulo = 'Registrar Celular') => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    tituloFormulario.textContent = titulo;
}

// Mostrar tabla
const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');
    cargarDatosTabla();
}

// Inicializar DataTable
const tabla = new DataTable('#TableCelulares', {
    dom: `
        <"row justify-content-between mb-3"
            <"col" l>
            <"col-3" f>
        >
        t
        <"row justify-content-between mt-3"
            <"col-md-3" i>
            <"col-md-6" p>
        >
    `,
    language: lenguaje,
    data: [],
    columns: [
        { title: "#", data: "id_celular", render: (data, type, row, meta) => meta.row + 1 },
        { title: "Marca", data: "nombre_marca" },
        { title: "Modelo", data: "modelo" },
        { title: "Precio Venta", data: "precio_venta" },
        { title: "Stock", data: "stock_actual" },
        {
            title: "Opciones", data: null, render: (data, type, row) => {
                return `
                    <div class="d-flex justify-content-center">
                        <button class="btn btn-warning modificar mx-1" 
                            data-id="${row.id_celular}" 
                            data-id_marca="${row.id_marca}" 
                            data-modelo="${row.modelo}"
                            data-precio_compra="${row.precio_compra}" 
                            data-precio_venta="${row.precio_venta}"
                            data-stock_actual="${row.stock_actual}" 
                            data-stock_minimo="${row.stock_minimo}"
                            data-color="${row.color}" 
                            data-almacenamiento="${row.almacenamiento}" 
                            data-ram="${row.ram}" 
                            data-estado="${row.estado}"
                            data-fecha_ingreso="${row.fecha_ingreso}">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                        <button class="btn btn-danger eliminar mx-1" data-id="${row.id_celular}">
                            <i class="bi bi-trash3"></i>
                        </button>
                    </div>
                `;
            }
        }
    ]
});

// Cargar marcas al select
const cargarMarcas = async () => {
    try {
        const res = await fetch("/app03_carbajal_clase/busca_marca");
        const datos = await res.json();

        if (datos.codigo === 1) {
            const select = document.getElementById("id_marca");
            select.innerHTML = `<option value="">Seleccione la marca</option>`;
            datos.data.forEach(marca => {
                const option = document.createElement("option");
                option.value = marca.id_marca;
                option.text = marca.nombre_marca;
                select.add(option);
            });
        }
    } catch (err) {
        console.error(err);
    }
}

// Guardar celular
const guardarCelular = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormCelulares, ['id_celular'])) {
        Swal.fire("Campos requeridos", "Debe llenar todos los campos", "warning");
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormCelulares);
    const url = "/app03_carbajal_clase/guarda_celular";

    try {
        const res = await fetch(url, { method: 'POST', body });
        const datos = await res.json();

        if (datos.codigo === 1) {
            Swal.fire("Éxito", datos.mensaje, "success");
            limpiarFormulario();
            mostrarTabla();
        } else {
            Swal.fire("Error", datos.mensaje, "error");
        }
    } catch (err) {
        console.error(err);
    }

    BtnGuardar.disabled = false;
}

// Cargar datos tabla
const cargarDatosTabla = async () => {
    try {
        const res = await fetch("/app03_carbajal_clase/busca_celular");
        const datos = await res.json();

        if (datos.codigo === 1) {
            tabla.clear().rows.add(datos.data).draw();
        }
    } catch (err) {
        console.error(err);
    }
}

// Modificar celular
const llenarFormulario = (e) => {
    const datos = e.currentTarget.dataset;

    document.getElementById("id_celular").value = datos.id;
    document.getElementById("id_marca").value = datos.id_marca;
    document.getElementById("modelo").value = datos.modelo;
    document.getElementById("precio_compra").value = datos.precio_compra;
    document.getElementById("precio_venta").value = datos.precio_venta;
    document.getElementById("color").value = datos.color;
    document.getElementById("almacenamiento").value = datos.almacenamiento;
    document.getElementById("ram").value = datos.ram;
    document.getElementById("estado").value = datos.estado;
    document.getElementById("fecha_ingreso").value = datos.fecha_ingreso;

    BtnGuardar.classList.add("d-none");
    BtnModificar.classList.remove("d-none");
    mostrarFormulario("Modificar Celular");
}

const modificarCelular = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormCelulares, [])) {
        Swal.fire("Campos requeridos", "Debe llenar todos los campos", "warning");
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormCelulares);
    const url = "/app03_carbajal_clase/modifica_celular";

    try {
        const res = await fetch(url, { method: 'POST', body });
        const datos = await res.json();

        if (datos.codigo === 1) {
            Swal.fire("Actualizado", datos.mensaje, "success");
            limpiarFormulario();
            mostrarTabla();
        } else {
            Swal.fire("Error", datos.mensaje, "error");
        }
    } catch (err) {
        console.error(err);
    }

    BtnModificar.disabled = false;
}

// Eliminar celular
const eliminarCelular = async (e) => {
    const id = e.currentTarget.dataset.id;

    const confirma = await Swal.fire({
        title: "¿Eliminar?",
        text: "Esta acción no se puede deshacer",
        icon: "warning",
        showCancelButton: true,
        confirmButtonText: "Sí, eliminar",
        cancelButtonText: "Cancelar"
    });

    if (!confirma.isConfirmed) return;

    const body = new FormData();
    body.append("id_celular", id);

    try {
        const res = await fetch("/app03_carbajal_clase/elimina_celular", { method: "POST", body });
        const datos = await res.json();

        if (datos.codigo === 1) {
            Swal.fire("Eliminado", datos.mensaje, "success");
            cargarDatosTabla();
        } else {
            Swal.fire("Error", datos.mensaje, "error");
        }
    } catch (err) {
        console.error(err);
    }
}

// Limpiar formulario
const limpiarFormulario = () => {
    FormCelulares.reset();
    BtnGuardar.classList.remove("d-none");
    BtnModificar.classList.add("d-none");
    tituloFormulario.textContent = "Registrar Celular";
}

// EVENTOS

document.addEventListener("DOMContentLoaded", () => {
    cargarMarcas();
    mostrarFormulario();
});

// Submit
FormCelulares.addEventListener("submit", guardarCelular);
BtnModificar.addEventListener("click", modificarCelular);
BtnLimpiar.addEventListener("click", limpiarFormulario);

// Botones vista tabla
BtnVerRegistros.addEventListener("click", mostrarTabla);
BtnCrearNuevo.addEventListener("click", () => {
    limpiarFormulario();
    mostrarFormulario("Registrar Celular");
});
BtnActualizarTabla.addEventListener("click", () => {
    cargarDatosTabla();
    Swal.fire("Actualizado", "Datos actualizados", "success");
});

// Delegación eventos tabla
tabla.on("click", ".modificar", llenarFormulario);
tabla.on("click", ".eliminar", eliminarCelular);
