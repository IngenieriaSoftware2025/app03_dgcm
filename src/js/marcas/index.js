import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

const FormMarca = document.getElementById('FormMarca');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnVerMarcas = document.getElementById('BtnVerMarcas');
const BtnCrearMarca = document.getElementById('BtnCrearMarca');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');
const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');
const tituloFormulario = document.getElementById('tituloFormulario');

const mostrarFormulario = (titulo = 'Registrar Marca') => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    tituloFormulario.textContent = titulo;
}

const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');
    buscaMarcas();
}

const datosDeTabla = new DataTable('#TableMarcas', {
    language: lenguaje,
    data: [],
    columns: [
        { title: "N°", data: "id_marca", render: (data, type, row, meta) => meta.row + 1 },
        { title: "Nombre de Marca", data: "nombre_marca" },
        { title: "País de Origen", data: "pais_origen" },
        {
            title: "Opciones", data: "id_marca", render: (data, type, row) => {
                return `
                <button class="btn btn-warning btn-sm modificar" data-id="${data}" data-nombre="${row.nombre_marca}" data-pais="${row.pais_origen}"><i class="bi bi-pencil"></i></button>
                <button class="btn btn-danger btn-sm eliminar" data-id="${data}"><i class="bi bi-trash"></i></button>`;
            }
        }
    ]
});

const buscaMarcas = async () => {
    const res = await fetch("/app03_carbajal_clase/busca_marca");
    const data = await res.json();
    datosDeTabla.clear().rows.add(data.data).draw();
}

const guardaMarca = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    // Validar formulario (puedes incluir más campos requeridos si es necesario)
    if (!validarFormulario(FormMarca, ['nombre_marca'])) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Formulario incompleto",
            text: "Complete los campos obligatorios",
            showConfirmButton: false,
            timer: 1000
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormMarca);
    const url = '/app03_carbajal_clase/guarda_marca';
    const config = {
        method: 'POST',
        body
    };

    try {
        const respuesta = await fetch(url, config);
        const data = await respuesta.json();

        if (data.codigo === 1) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Marca registrada!",
                text: data.mensaje,
                showConfirmButton: false,
                timer: 1000
            });

            limpiarFormulario();

            setTimeout(async () => {
                const resultado = await Swal.fire({
                    title: '¿Desea ver las marcas registradas?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, ver marcas',
                    cancelButtonText: 'Seguir registrando'
                });

                if (resultado.isConfirmed) {
                    mostrarTabla();
                }
            }, 1000);

        } else {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: data.mensaje,
                showConfirmButton: false,
                timer: 2000
            });
        }

    } catch (error) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor",
            showConfirmButton: false,
            timer: 1000
        });
    }

    BtnGuardar.disabled = false;
};


const modificaMarca = async () => {
    const body = new FormData(FormMarca);
    const res = await fetch("/app03_carbajal_clase/modifica_marca", { method: 'POST', body });
    const data = await res.json();

    if (data.codigo === 1) {
        Swal.fire("Modificado", data.mensaje, "success");
        limpiarFormulario();
    } else {
        Swal.fire("Error", data.mensaje, "error");
    }
}

const eliminarMarca = async id => {
    const conf = await Swal.fire({ title: "¿Eliminar?", showCancelButton: true });
    if (!conf.isConfirmed) return;

    const body = new FormData();
    body.append("id_marca", id);
    const res = await fetch("/app03_carbajal_clase/elimina_marca", { method: 'POST', body });
    const data = await res.json();

    if (data.codigo === 1) {
        Swal.fire("Eliminado", data.mensaje, "success");
        buscaMarcas();
    } else {
        Swal.fire("Error", data.mensaje, "error");
    }
}

const llenarFormulario = e => {
    const dataset = e.currentTarget.dataset;
    document.getElementById("id_marca").value = dataset.id;
    document.getElementById("nombre_marca").value = dataset.nombre;
    document.getElementById("pais_origen").value = dataset.pais;
    BtnGuardar.classList.add("d-none");
    BtnModificar.classList.remove("d-none");
    mostrarFormulario("Modificar Marca");
}

const limpiarFormulario = () => {
    FormMarca.reset();
    BtnGuardar.classList.remove("d-none");
    BtnModificar.classList.add("d-none");
    mostrarFormulario();
}

FormMarca.addEventListener("submit", guardaMarca);
BtnModificar.addEventListener("click", modificaMarca);
BtnLimpiar.addEventListener("click", limpiarFormulario);
BtnVerMarcas.addEventListener("click", mostrarTabla);
BtnCrearMarca.addEventListener("click", () => { limpiarFormulario(); mostrarFormulario(); });
BtnActualizarTabla.addEventListener("click", buscaMarcas);
datosDeTabla.on("click", ".modificar", llenarFormulario);
datosDeTabla.on("click", ".eliminar", e => eliminarMarca(e.currentTarget.dataset.id));
