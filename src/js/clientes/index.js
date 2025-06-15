import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

document.addEventListener("DOMContentLoaded", () => {
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



    // Buscar clientes
    const buscarClientes = async () => {
        try {
            const res = await fetch("/app03_carbajal_clase/busca_cliente");
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

        // Validar formulario
        if (!validarFormulario(FormCliente, ['id_cliente'])) {
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

        const body = new FormData(FormCliente);
        const url = '/app03_carbajal_clase/guarda_cliente';
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
                    title: "¡Cliente registrado!",
                    text: data.mensaje,
                    showConfirmButton: false,
                    timer: 1000
                });

                limpiarFormulario();

                setTimeout(async () => {
                    const resultado = await Swal.fire({
                        title: '¿Desea ver los clientes registrados?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, ver clientes',
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

    // Modificar cliente
    const modificarCliente = async (e) => {
        e.preventDefault();
        BtnModificar.disabled = true;

        // Validar formulario
        if (!validarFormulario(FormCliente)) {
            Swal.fire({
                position: "center",
                icon: "warning",
                title: "Formulario incompleto",
                text: "Complete los campos obligatorios",
                showConfirmButton: false,
                timer: 1000
            });
            BtnModificar.disabled = false;
            return;
        }

        const body = new FormData(FormCliente);
        const url = '/app03_carbajal_clase/modifica_cliente';
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
                    title: "¡Cliente modificado!",
                    text: data.mensaje,
                    showConfirmButton: false,
                    timer: 1000
                });

                limpiarFormulario();

                setTimeout(() => {
                    mostrarTabla();
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

        BtnModificar.disabled = false;
    };
    // Eliminar cliente
    const eliminarCliente = async (e) => {
        const id = e.currentTarget.dataset.id;

        // Confirmación 
        const confirmacion = await Swal.fire({
            title: "¿Eliminar cliente?",
            text: "Esta acción no se puede deshacer",
            icon: "warning",
            showCancelButton: true,
            confirmButtonText: "Sí, eliminar",
            cancelButtonText: "Cancelar",
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6"
        });

        if (!confirmacion.isConfirmed) return;

        const body = new FormData();
        body.append("id_cliente", id);
        const url = '/app03_carbajal_clase/elimina_cliente';
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
                    title: "¡Cliente eliminado!",
                    text: data.mensaje,
                    showConfirmButton: false,
                    timer: 1000
                });

                setTimeout(async () => {
                    const resultado = await Swal.fire({
                        title: '¿Desea ver los clientes restantes?',
                        icon: 'question',
                        showCancelButton: true,
                        confirmButtonText: 'Sí, ver clientes',
                        cancelButtonText: 'Continuar'
                    });

                    if (resultado.isConfirmed) {
                        buscarClientes();
                    } else {
                        buscarClientes(); // Actualizar la tabla de todas formas
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



    // listeners
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

    tablaClientes.on("click", ".modificar", llenarFormulario);
    tablaClientes.on("click", ".eliminar", eliminarCliente);

    // Inicialización de vista
    mostrarFormulario();
});