import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

// ============ ELEMENTOS DEL DOM ============
const FormRoles = document.getElementById('FormRoles');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');

// Botones de navegación
const BtnVerRoles = document.getElementById('BtnVerRoles');
const BtnCrearRol = document.getElementById('BtnCrearRol');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');

// Secciones del formulario y tabla
const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');
const tituloFormulario = document.getElementById('tituloFormulario');

// ============ NAVEGACIÓN ENTRE VISTAS ============
const mostrarFormulario = (titulo = 'Registrar Rol') => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    tituloFormulario.textContent = titulo;

    // Scroll suave al formulario
    seccionFormulario.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');

    // Actualizar datos automáticamente
    buscaRol();

    // Scroll suave a la tabla
    seccionTabla.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// ============ VALIDACIONES ESPECÍFICAS DE ROLES ============
const validarRolNombre = () => {
    const rolNombre = document.getElementById('rol_nombre');
    const valor = rolNombre.value.trim();

    if (valor.length === 0) {
        rolNombre.classList.remove('is-valid', 'is-invalid');
        return true; // Vacío está bien (se valida en submit)
    }

    if (valor.length < 3) {
        rolNombre.classList.remove('is-valid');
        rolNombre.classList.add('is-invalid');
        rolNombre.title = "El nombre debe tener al menos 3 caracteres";
        return false;
    } else {
        rolNombre.classList.remove('is-invalid');
        rolNombre.classList.add('is-valid');
        rolNombre.title = "Nombre válido";
        return true;
    }
}

// ============ DATATABLE CONFIGURACIÓN ============
const datosDeTabla = new DataTable('#TableRoles', {
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
            data: 'id_rol',
            width: '8%',
            render: (data, type, row, meta) => meta.row + 1
        },
        {
            title: 'Nombre del Rol',
            data: 'rol_nombre',
            width: '25%'
        },
        {
            title: 'Descripción',
            data: 'descripcion',
            width: '45%',
            render: (data, type, row) => {
                return data || '<span class="text-muted fst-italic">Sin descripción</span>';
            }
        },
        {
            title: 'Estado',
            data: 'situacion',
            width: '12%',
            render: (data, type, row) => {
                return data == 1
                    ? '<span class="badge bg-success">Activo</span>'
                    : '<span class="badge bg-danger">Inactivo</span>';
            }
        },
        {
            title: 'Opciones',
            data: 'id_rol',
            width: '10%',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                <div class='d-flex justify-content-center'>
                    <button class='btn btn-warning btn-sm modificar mx-1' 
                        data-id="${data}" 
                        data-rol_nombre="${row.rol_nombre}"  
                        data-descripcion="${row.descripcion || ''}"
                        title="Modificar rol">
                        <i class='bi bi-pencil-square'></i>
                    </button>
                    <button class='btn btn-danger btn-sm eliminar mx-1' 
                        data-id="${data}"
                        title="Eliminar rol">
                        <i class="bi bi-trash3"></i>
                    </button>
                </div>
                `;
            }
        },
    ],
});

// ============ GUARDAR ROL ============
const guardaRol = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    // Validar formulario (solo rol_nombre es requerido)
    if (!validarFormulario(FormRoles, ['id_rol'])) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Formulario incompleto",
            text: "Complete el campo nombre del rol",
            showConfirmButton: false,
            timer: 1500
        });
        BtnGuardar.disabled = false;
        return;
    }

    // Validar nombre del rol específicamente
    if (!validarRolNombre()) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Nombre inválido",
            text: "El nombre del rol debe tener al menos 3 caracteres",
            showConfirmButton: false,
            timer: 1500
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormRoles);
    const url = '/app03_dgcm/guarda_rol';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Éxito!",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 1000
            });

            limpiarFormulario();

            // Preguntar si quiere ver los roles
            setTimeout(async () => {
                const resultado = await Swal.fire({
                    title: '¿Desea ver los roles registrados?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, ver roles',
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
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 2000
            });
        }

    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor",
            showConfirmButton: false,
            timer: 1500
        });
    }
    BtnGuardar.disabled = false;
}

// ============ BUSCAR ROLES ============
const buscaRol = async () => {
    const url = '/app03_dgcm/busca_rol';
    const config = {
        method: 'GET'
    }

    try {
        const respuesta = await fetch(url, config);

        if (!respuesta.ok) {
            console.error('Error HTTP:', respuesta.status, respuesta.statusText);
            return;
        }

        const textoRespuesta = await respuesta.text();
        let datos;

        try {
            datos = JSON.parse(textoRespuesta);
        } catch (errorJSON) {
            console.error('Error parseando JSON:', errorJSON);
            return;
        }

        if (datos.codigo === 1) {
            datosDeTabla.clear().draw();
            if (datos.data && datos.data.length > 0) {
                datosDeTabla.rows.add(datos.data).draw();
            }
        } else {
            console.log('Error del servidor:', datos.mensaje);
        }

    } catch (error) {
        console.error('Error completo:', error);
    }
}

// ============ LLENAR FORMULARIO PARA EDICIÓN ============
const llenarFormulario = (e) => {
    const datos = e.currentTarget.dataset;

    document.getElementById('id_rol').value = datos.id;
    document.getElementById('rol_nombre').value = datos.rol_nombre;
    document.getElementById('descripcion').value = datos.descripcion;

    // Cambiar a modo edición
    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    mostrarFormulario('Modificar Rol');
}

// ============ LIMPIAR FORMULARIO ============
const limpiarFormulario = () => {
    FormRoles.reset();

    // Limpiar validaciones visuales
    const inputs = FormRoles.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });

    // Volver a modo creación
    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');

    // Cambiar título
    tituloFormulario.textContent = 'Registrar Rol';
}

// ============ MODIFICAR ROL ============
const modificaRol = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    // Validar formulario (id_rol y rol_nombre son requeridos en modificación)
    if (!validarFormulario(FormRoles, [])) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Formulario incompleto",
            text: "Complete el campo nombre del rol",
            showConfirmButton: false,
            timer: 1500
        });
        BtnModificar.disabled = false;
        return;
    }

    // Validar nombre del rol
    if (!validarRolNombre()) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Nombre inválido",
            text: "El nombre del rol debe tener al menos 3 caracteres",
            showConfirmButton: false,
            timer: 1500
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormRoles);
    const url = '/app03_dgcm/modifica_rol';
    const config = {
        method: 'POST',
        body
    }

    try {
        const respuesta = await fetch(url, config);
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Éxito!",
                text: datos.mensaje
            });

            limpiarFormulario();

            // Ir a la tabla automáticamente
            setTimeout(() => {
                mostrarTabla();
            }, 1000);

        } else {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 2000
            });
        }

    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor",
            showConfirmButton: false,
            timer: 1500
        });
    }
    BtnModificar.disabled = false;
}

// ============ ELIMINAR ROL ============
const eliminaRol = async (e) => {
    const idRol = e.currentTarget.dataset.id;

    const alertaConfirmaEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Estás seguro?",
        text: "El rol será eliminado del sistema",
        showConfirmButton: true,
        confirmButtonText: "Sí, eliminar",
        confirmButtonColor: "#dc3545",
        cancelButtonText: "Cancelar",
        showCancelButton: true
    });

    if (!alertaConfirmaEliminar.isConfirmed) return;

    const body = new FormData();
    body.append('id_rol', idRol);

    try {
        const respuesta = await fetch('/app03_dgcm/elimina_rol', {
            method: 'POST',
            body
        });

        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Eliminado!",
                text: datos.mensaje
            });
            buscaRol(); // Recargar tabla
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: datos.mensaje
            });
        }
    } catch (error) {
        console.error('Error:', error);
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo eliminar el rol",
            showConfirmButton: false,
            timer: 1500
        });
    }
}

// ============ EVENT LISTENERS ============
document.addEventListener('DOMContentLoaded', () => {
    // Inicializar en modo formulario
    mostrarFormulario('Registrar Rol');
});

// Validaciones en tiempo real
document.getElementById('rol_nombre').addEventListener('blur', validarRolNombre);

// Formulario
FormRoles.addEventListener('submit', guardaRol);

// Botones principales
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnModificar.addEventListener('click', modificaRol);

// Botones de navegación
BtnVerRoles.addEventListener('click', () => {
    mostrarTabla();
});

BtnCrearRol.addEventListener('click', () => {
    limpiarFormulario();
    mostrarFormulario('Registrar Rol');
});

BtnActualizarTabla.addEventListener('click', () => {
    buscaRol();
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Tabla actualizada",
        showConfirmButton: false,
        timer: 1000
    });
});

// Eventos de DataTable
datosDeTabla.on('click', '.modificar', llenarFormulario);
datosDeTabla.on('click', '.eliminar', eliminaRol);