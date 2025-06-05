import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

const FormClientes = document.getElementById('FormClientes');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const validarTelefono = document.getElementById('telefono');
const validarSAR = document.getElementById('sar');

const validacionTelefono = () => {
    const cantidadDigitos = validarTelefono.value;

    if (cantidadDigitos.length < 1) {
        validarTelefono.classList.remove('is-valid', 'is-invalid');
    } else {
        if (cantidadDigitos.length != 8) {
            Swal.fire({
                position: "center",
                icon: "warning",
                title: "Datos malos",
                text: "Ingresa exactamente 8 digitos",
                showConfirmButton: false,
                timer: 1000
            });

            validarTelefono.classList.remove('is-valid');
            validarTelefono.classList.add('is-invalid');
        } else {
            validarTelefono.classList.remove('is-invalid');
            validarTelefono.classList.add('is-valid');
        }
    }
}

function validandoSAR() {
    const sarValid = sar.value.trim();

    let nd, add = 0;

    if (nd = /^(\d+)-?([\dkK])$/.exec(sarValid)) {
        nd[2] = (nd[2].toLowerCase() === 'k') ? 10 : parseInt(nd[2], 10);

        for (let i = 0; i < nd[1].length; i++) {
            add += ((((i - nd[1].length) * -1) + 1) * parseInt(nd[1][i], 10));
        }
        return ((11 - (add % 11)) % 11) === nd[2];
    } else {
        return false;
    }
}

const validacionSAR = () => {
    validandoSAR();

    if (validandoSAR()) {
        sar.classList.add('is-valid');
        sar.classList.remove('is-invalid');
    } else {
        sar.classList.remove('is-valid');
        sar.classList.add('is-invalid');
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Datos malos",
            text: "SAR invalido",
            showConfirmButton: false,
            timer: 1000
        });
    }
}

const datosDeTabla = new DataTable('#TableClientes', {
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
            title: 'N°',
            data: 'id_cliente',
            width: '%',
            render: (data, type, row, meta) => meta.row + 1
        },
        { title: 'Nombres', data: 'nombres' },
        { title: 'Apellidos', data: 'apellidos' },
        { title: 'N° Telefono', data: 'telefono' },
        { title: 'N° SAR', data: 'sar' },
        { title: 'Correo', data: 'correo' },
        {
            title: 'Opciones',
            data: 'id_cliente',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                <div class='d-flex justify-content-center'>
                    <button class='btn btn-warning modificar mx-1' 
                        data-id="${data}" 
                        data-nombres="${row.nombres}"  
                        data-apellidos="${row.apellidos}"
                        data-telefono="${row.telefono}"  
                        data-sar="${row.sar}"   
                        data-correo="${row.correo}"  
                        <i class='bi bi-pencil-square me-1'></i> Modificar
                    </button>
                    <button class='btn btn-danger eliminar mx-1' 
                        data-id="${data}">
                        <i class="bi bi-trash3 me-1"></i>Eliminar
                    </button>
                </div>
                `;
            }
        },
    ],
});

const guardaCliente = async (e) => {
    // Controla el envio de formulario
    e.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormClientes, ['id_cliente'])) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Formulario incompleto",
            text: "Llene todos los campos",
            showConfirmButton: false,
            timer: 1000
        });
        BtnGuardar.disabled = false;
    }
    // Crea una instancia de la clase FormData
    const body = new FormData(FormClientes);
    const url = '/app03_dgcm/guarda_cliente';
    const config = {
        method: 'POST',
        body
    }

    // Tratar de Guardar un cliente
    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();

        const { codigo, mensaje } = datos;

        if (codigo === 1) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Exito",
                text: mensaje,
                showConfirmButton: false,
                timer: 1000
            });

            limpiarFormulario();
            buscaCliente();

        } else {
            Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: false,
                timer: 1000
            });
        }

    } catch (error) {
        console.log(error);
    }
    BtnGuardar.disabled = false;
}

const buscaCliente = async () => {
    const url = '/app03_dgcm/busca_cliente';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje, data } = datos;

        if (codigo === 1) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Exito",
                text: mensaje,
                showConfirmButton: false,
                timer: 1000
            });

            datosDeTabla.clear().draw();
            datosDeTabla.rows.add(data).draw();

        } else {
            Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: false,
                timer: 1000
            });
            return;
        }

    } catch (error) {
        console.log(error);
    }
}

const llenarFormulario = (e) => {
    const datos = e.currentTarget.dataset;

    document.getElementById('id_cliente').value = datos.id;
    document.getElementById('nombres').value = datos.nombres;
    document.getElementById('apellidos').value = datos.apellidos;
    document.getElementById('telefono').value = datos.telefono;
    document.getElementById('sar').value = datos.sar;
    document.getElementById('correo').value = datos.correo;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    window.scrollTo({
        top: 0
    });
}

const limpiarFormulario = () => {
    FormClientes.reset();
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');
}

const modificaCliente = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormClientes, [''])) {
        Swal.fire({
            position: "center",
            icon: "success",
            title: "Exito",
            text: mensaje,
            showConfirmButton: false,
            timer: 1000
        });
        BtnGuardar.disabled = false;
    }

    const body = new FormData(FormClientes);
    const url = '/app03_dgcm/modifica_cliente';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();
        const { codigo, mensaje } = datos;

        if (codigo === 1) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "Exito",
                text: mensaje
            });

            limpiarFormulario();
            buscaCliente();

        } else {
            Swal.fire({
                position: "center",
                icon: "info",
                title: "Error",
                text: mensaje,
                showConfirmButton: false,
                timer: 1000
            });
            return;
        }

    } catch (error) {
        console.log(error);
    }
    BtnModificar.disabled = false;
}

// Eventos
buscaCliente();
// datosDeTabla.on('click', '.eliminar', eliminarCliente);
validarTelefono.addEventListener('change', validacionTelefono);
validarSAR.addEventListener('change', validacionSAR);

// FormClientes
FormClientes.addEventListener('submit', guardaCliente);

// Botones
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnModificar.addEventListener('click', modificaCliente);

// datosDeTabla
datosDeTabla.on('click', '.modificar', llenarFormulario);