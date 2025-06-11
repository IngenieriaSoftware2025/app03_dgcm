import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

console.log('=== CARGANDO MÓDULO DE PERMISOS ===');

// CONSTANTES USUARIO_ROL
const FormPermisos = document.getElementById('FormPermisos');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');

// CAMPOS ESPECÍFICOS DE USUARIO_ROL
const selectUsuario = document.getElementById('id_usuario');
const selectRol = document.getElementById('id_rol');
const descripcionAsignacion = document.getElementById('descripcion');

// BOTONES DE ACCIÓN
const BtnVerPermisos = document.getElementById('BtnVerPermisos');
const BtnCrearPermiso = document.getElementById('BtnCrearPermiso');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');

// SECCIONES DEL FORMULARIO Y TABLA
const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');
const tituloFormulario = document.getElementById('tituloFormulario');

// FUNCIONES PARA CAMBIAR VISTAS
const mostrarFormulario = (titulo = 'Asignar Rol a Usuario') => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    tituloFormulario.textContent = titulo;

    seccionFormulario.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');

    buscaPermiso();

    seccionTabla.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// VALIDACIÓN DE DESCRIPCIÓN ADAPTADA
const validacionDescripcion = () => {
    const texto = descripcionAsignacion.value.trim();

    if (texto.length < 1) {
        descripcionAsignacion.classList.remove('is-valid', 'is-invalid');
        return;
    }

    if (texto.length < 5) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Descripción muy corta",
            text: "La descripción debe tener al menos 5 caracteres",
            showConfirmButton: false,
            timer: 1500
        });
        descripcionAsignacion.classList.remove('is-valid');
        descripcionAsignacion.classList.add('is-invalid');
    } else if (texto.length > 255) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Descripción muy larga",
            text: "La descripción no puede exceder 255 caracteres",
            showConfirmButton: false,
            timer: 1500
        });
        descripcionAsignacion.classList.remove('is-valid');
        descripcionAsignacion.classList.add('is-invalid');
    } else {
        descripcionAsignacion.classList.remove('is-invalid');
        descripcionAsignacion.classList.add('is-valid');
    }
}

// CARGAR USUARIOS EN EL SELECT
const cargarUsuarios = async () => {
    try {
        const respuesta = await fetch('/app03_dgcm/obtener_usuarios');
        const datos = await respuesta.json();

        if (datos.codigo === 1 && datos.data) {
            selectUsuario.innerHTML = '<option value="">-- Selecciona un usuario --</option>';

            datos.data.forEach(usuario => {
                const option = document.createElement('option');
                option.value = usuario.id_usuario;
                option.textContent = `${usuario.nombre_completo} (${usuario.correo})`;
                selectUsuario.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error cargando usuarios:', error);
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error",
            text: "No se pudieron cargar los usuarios",
            showConfirmButton: false,
            timer: 2000
        });
    }
}

// CARGAR ROLES EN EL SELECT
const cargarRoles = async () => {
    try {
        const respuesta = await fetch('/app03_dgcm/obtener_roles');
        const datos = await respuesta.json();

        if (datos.codigo === 1 && datos.data) {
            selectRol.innerHTML = '<option value="">-- Selecciona un rol --</option>';

            datos.data.forEach(rol => {
                const option = document.createElement('option');
                option.value = rol.id_rol;
                option.textContent = `${rol.rol_nombre} - ${rol.descripcion}`;
                selectRol.appendChild(option);
            });
        }
    } catch (error) {
        console.error('Error cargando roles:', error);
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error",
            text: "No se pudieron cargar los roles",
            showConfirmButton: false,
            timer: 2000
        });
    }
}

// DATATABLE ADAPTADO PARA USUARIO_ROL
const datosDeTabla = new DataTable('#TablePermisos', {
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
            data: 'id_usuario_rol',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        {
            title: 'Usuario',
            data: 'usuario_nombre',
            width: '25%',
            render: (data, type, row) => {
                return `<strong>${row.usuario_nombre || ''} ${row.usuario_apellido || ''}</strong><br>
                <small class="text-muted">${row.usuario_correo || ''}</small>`;
            }
        },
        {
            title: 'Rol Asignado',
            data: 'rol_nombre',
            width: '20%',
            render: (data, type, row) => {
                return `<span class="badge bg-primary fs-6">${row.rol_nombre || ''}</span><br>
                <small class="text-muted">${row.rol_descripcion || ''}</small>`;
            }
        },
        {
            title: 'Descripción',
            data: 'descripcion',
            width: '30%',
            render: (data, type, row) => {
                return data && data.length > 50 ? data.substring(0, 50) + '...' : (data || 'Sin descripción');
            }
        },
        {
            title: 'Fecha Asignación',
            data: 'fecha_creacion',
            width: '10%',
            render: (data, type, row) => {
                if (data) {
                    const fecha = new Date(data);
                    return fecha.toLocaleDateString('es-ES');
                }
                return '--';
            }
        },
        {
            title: 'Opciones',
            data: 'id_usuario_rol',
            searchable: false,
            orderable: false,
            width: '10%',
            render: (data, type, row, meta) => {
                return `
                <div class='d-flex justify-content-center'>
                    <button class='btn btn-warning btn-sm modificar mx-1' 
                        data-id="${data}" 
                        data-id_usuario="${row.id_usuario}"
                        data-id_rol="${row.id_rol}"  
                        data-descripcion="${row.descripcion || ''}"
                        title="Modificar asignación">
                        <i class='bi bi-pencil-square'></i>
                    </button>
                    <button class='btn btn-danger btn-sm eliminar mx-1' 
                        data-id="${data}"
                        data-usuario="${row.usuario_nombre} ${row.usuario_apellido}"
                        data-rol="${row.rol_nombre}"
                        title="Eliminar asignación">
                        <i class="bi bi-trash3"></i>
                    </button>
                </div>
                `;
            }
        },
    ],
});

// GUARDAR ASIGNACIÓN 
const guardaPermiso = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    // Validar formulario (excluyendo id_usuario_rol)
    if (!validarFormulario(FormPermisos, ['id_usuario_rol'])) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Formulario incompleto",
            text: "Complete todos los campos obligatorios",
            showConfirmButton: false,
            timer: 1500
        });
        BtnGuardar.disabled = false;
        return;
    }

    // Validación específica
    validacionDescripcion();

    // Verificar si hay errores de validación
    const errores = FormPermisos.querySelectorAll('.is-invalid');
    if (errores.length > 0) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Datos incorrectos",
            text: "Corrija los errores en el formulario",
            showConfirmButton: false,
            timer: 2000
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormPermisos);
    console.log('=== DATOS DE ASIGNACIÓN QUE SE ENVÍAN ===');
    for (let [key, value] of body.entries()) {
        console.log(`${key}: ${value}`);
    }

    const url = '/app03_dgcm/guarda_permiso';
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
                title: "¡Rol asignado correctamente!",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 1500
            });

            limpiarFormulario();

            setTimeout(async () => {
                const resultado = await Swal.fire({
                    title: '¿Desea ver las asignaciones registradas?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, ver asignaciones',
                    cancelButtonText: 'Seguir asignando'
                });

                if (resultado.isConfirmed) {
                    mostrarTabla();
                }
            }, 1500);

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
        console.log('=== ERROR COMPLETO ===');
        console.log(error);
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor",
            showConfirmButton: false,
            timer: 2000
        });
    }
    BtnGuardar.disabled = false;
}

// BUSCAR ASIGNACIONES 
const buscaPermiso = async () => {
    const url = '/app03_dgcm/busca_permiso';
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
        console.log('Respuesta cruda del servidor:', textoRespuesta);

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

// LLENAR FORMULARIO PARA MODIFICAR 
const llenarFormulario = async (e) => {
    const datos = e.currentTarget.dataset;

    // Cargar usuarios y roles primero
    await cargarUsuarios();
    await cargarRoles();

    document.getElementById('id_usuario_rol').value = datos.id;
    document.getElementById('id_usuario').value = datos.id_usuario;
    document.getElementById('id_rol').value = datos.id_rol;
    document.getElementById('descripcion').value = datos.descripcion;

    // Limpiar validaciones previas
    const inputs = FormPermisos.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    mostrarFormulario('Modificar Asignación');
}

// LIMPIAR FORMULARIO
const limpiarFormulario = () => {
    FormPermisos.reset();

    const inputs = FormPermisos.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });

    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');

    tituloFormulario.textContent = 'Asignar Rol a Usuario';
}

// MODIFICAR ASIGNACIÓN
const modificaPermiso = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormPermisos, [])) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Formulario incompleto",
            text: "Complete todos los campos obligatorios",
            showConfirmButton: false,
            timer: 1500
        });
        BtnModificar.disabled = false;
        return;
    }

    validacionDescripcion();

    const errores = FormPermisos.querySelectorAll('.is-invalid');
    if (errores.length > 0) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Datos incorrectos",
            text: "Corrija los errores en el formulario",
            showConfirmButton: false,
            timer: 2000
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormPermisos);
    const url = '/app03_dgcm/modifica_permiso';
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
                title: "¡Asignación actualizada!",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 1500
            });

            limpiarFormulario();
            setTimeout(() => {
                mostrarTabla();
            }, 1500);

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
        console.log(error);
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor",
            showConfirmButton: false,
            timer: 2000
        });
    }
    BtnModificar.disabled = false;
}

// ELIMINAR ASIGNACIÓN 
const eliminaPermiso = async (e) => {
    const idAsignacion = e.currentTarget.dataset.id;
    const usuario = e.currentTarget.dataset.usuario;
    const rol = e.currentTarget.dataset.rol;

    const alertaConfirmaEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Estás seguro?",
        html: `Se eliminará la asignación del rol:<br><strong>${rol}</strong><br>al usuario:<br><strong>${usuario}</strong>`,
        showConfirmButton: true,
        confirmButtonText: "Sí, eliminar",
        confirmButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true
    });

    if (!alertaConfirmaEliminar.isConfirmed) return;

    const body = new FormData();
    body.append('id_usuario_rol', idAsignacion);

    try {
        const respuesta = await fetch('/app03_dgcm/elimina_permiso', {
            method: 'POST',
            body
        });

        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            await Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Eliminado!",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 1500
            });
            buscaPermiso();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 2000
            });
        }
    } catch (error) {
        console.log(error);
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor",
            showConfirmButton: false,
            timer: 2000
        });
    }
};

// EVENTOS 
descripcionAsignacion.addEventListener('blur', validacionDescripcion);

// EVENTOS DEL FORMULARIO
FormPermisos.addEventListener('submit', guardaPermiso);

// EVENTOS DE BOTONES
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnModificar.addEventListener('click', modificaPermiso);

// EVENTOS DE NAVEGACIÓN
BtnVerPermisos.addEventListener('click', () => {
    mostrarTabla();
});

BtnCrearPermiso.addEventListener('click', async () => {
    await cargarUsuarios();
    await cargarRoles();
    limpiarFormulario();
    mostrarFormulario('Asignar Rol a Usuario');
});

BtnActualizarTabla.addEventListener('click', () => {
    buscaPermiso();
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Tabla actualizada",
        showConfirmButton: false,
        timer: 1000
    });
});

// EVENTOS DEL DATATABLE
datosDeTabla.on('click', '.modificar', llenarFormulario);
datosDeTabla.on('click', '.eliminar', eliminaPermiso);

// INICIALIZAR AL CARGAR LA PÁGINA 
document.addEventListener('DOMContentLoaded', async () => {
    await cargarUsuarios();
    await cargarRoles();
    mostrarFormulario('Asignar Rol a Usuario');
});