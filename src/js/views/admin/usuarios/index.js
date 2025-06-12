import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../../../funciones";
import { lenguaje } from "../../../lenguaje";

// Elementos del formulario
const FormUsuarios = document.getElementById('FormUsuarios');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');

// Validaciones específicas
const validarTelefono = document.getElementById('telefono');
const validarDPI = document.getElementById('dpi');
const contraseniaBtn = document.getElementById('contraseniaBtn');
const iconOjo = document.getElementById('iconOjo');
const usuarioClave = document.getElementById('usuario_clave');
const confirmarClave = document.getElementById('confirmar_clave');

// Botones de acción
const BtnVerUsuarios = document.getElementById('BtnVerUsuarios');
const BtnCrearUsuario = document.getElementById('BtnCrearUsuario');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');
const BtnFiltroActivos = document.getElementById('BtnFiltroActivos');
const BtnFiltroInactivos = document.getElementById('BtnFiltroInactivos');

// Filtros avanzados
const filtroRol = document.getElementById('filtroRol');
const fechaDesde = document.getElementById('fechaDesde');
const fechaHasta = document.getElementById('fechaHasta');
const buscarUsuario = document.getElementById('buscarUsuario');

// Secciones del formulario y tabla
const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');
const tituloFormulario = document.getElementById('tituloFormulario');

// Elementos de estadísticas
const totalUsuarios = document.getElementById('totalUsuarios');
const totalAdmins = document.getElementById('totalAdmins');
const totalEmpleados = document.getElementById('totalEmpleados');
const totalClientes = document.getElementById('totalClientes');
const usuariosActivos = document.getElementById('usuariosActivos');
const usuariosInactivos = document.getElementById('usuariosInactivos');

// Función para mostrar el formulario
const mostrarFormulario = (titulo = 'Gestión de Usuarios') => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    tituloFormulario.textContent = titulo;

    // Scroll al formulario
    seccionFormulario.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// Función para mostrar la tabla
const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');

    // Actualizar datos automáticamente
    buscaUsuarios();
    cargarEstadisticas();

    // Scroll a la tabla
    seccionTabla.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// Validación de teléfono (8 dígitos)
const validacionTelefono = () => {
    const cantidadDigitos = validarTelefono.value;

    if (cantidadDigitos.length < 1) {
        validarTelefono.classList.remove('is-valid', 'is-invalid');
    } else {
        if (cantidadDigitos.length != 8) {
            Swal.fire({
                position: "center",
                icon: "warning",
                title: "Teléfono incorrecto",
                text: "Ingresa exactamente 8 dígitos",
                showConfirmButton: false,
                timer: 1500
            });
            validarTelefono.classList.remove('is-valid');
            validarTelefono.classList.add('is-invalid');
        } else {
            validarTelefono.classList.remove('is-invalid');
            validarTelefono.classList.add('is-valid');
        }
    }
}

// Validación de DPI (13 dígitos)
const validacionDPI = () => {
    const dpi = validarDPI.value;

    if (dpi.length > 0) {
        if (dpi.length != 13) {
            Swal.fire({
                position: "center",
                icon: "warning",
                title: "DPI incorrecto",
                text: "El DPI debe tener exactamente 13 dígitos",
                showConfirmButton: false,
                timer: 1500
            });
            validarDPI.classList.remove('is-valid');
            validarDPI.classList.add('is-invalid');
        } else {
            validarDPI.classList.remove('is-invalid');
            validarDPI.classList.add('is-valid');
        }
    } else {
        validarDPI.classList.remove('is-valid', 'is-invalid');
    }
}

// Validación de contraseña segura
const validarContrasenaSegura = () => {
    const password = usuarioClave.value;
    let errores = [];

    if (password.length < 10) {
        errores.push("Mínimo 10 caracteres");
    }

    if (!/[A-Z]/.test(password)) {
        errores.push("Al menos una mayúscula");
    }

    if (!/[a-z]/.test(password)) {
        errores.push("Al menos una minúscula");
    }

    if (!/[0-9]/.test(password)) {
        errores.push("Al menos un número");
    }

    if (!/[!@#$%^&*()_+\-=\[\]{};':"\\|,.<>\/?]/.test(password)) {
        errores.push("Al menos un carácter especial");
    }

    if (errores.length > 0) {
        usuarioClave.classList.remove('is-valid');
        usuarioClave.classList.add('is-invalid');
        usuarioClave.title = "Falta: " + errores.join(", ");
        return false;
    } else {
        usuarioClave.classList.remove('is-invalid');
        usuarioClave.classList.add('is-valid');
        usuarioClave.title = "Contraseña segura ✓";
        return true;
    }
}

// Validar que las contraseñas coincidan
const validarCoincidenciaPassword = () => {
    if (confirmarClave.value && usuarioClave.value) {
        if (usuarioClave.value === confirmarClave.value) {
            confirmarClave.classList.remove('is-invalid');
            confirmarClave.classList.add('is-valid');
            return true;
        } else {
            confirmarClave.classList.remove('is-valid');
            confirmarClave.classList.add('is-invalid');
            return false;
        }
    }
    return true;
}

// Toggle para mostrar/ocultar contraseña
const mostrarContrasenia = () => {
    if (usuarioClave.type === 'password') {
        usuarioClave.type = 'text';
        iconOjo.classList.remove('bi-eye');
        iconOjo.classList.add('bi-eye-slash');
    } else {
        usuarioClave.type = 'password';
        iconOjo.classList.remove('bi-eye-slash');
        iconOjo.classList.add('bi-eye');
    }
}

// Configuración del DataTable
const datosDeTabla = new DataTable('#TableUsuarios', {
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
            data: 'id_usuario',
            width: '3%',
            render: (data, type, row, meta) => meta.row + 1
        },
        {
            title: 'Foto',
            data: 'fotografia',
            width: '5%',
            searchable: false,
            orderable: false,
            render: (data, type, row) => {
                if (data) {
                    return `<img src="${data}" alt="Foto" class="rounded-circle" 
                            style="width: 40px; height: 40px; object-fit: cover;">`;
                } else {
                    return `<div class="rounded-circle bg-secondary d-flex align-items-center justify-content-center" 
                            style="width: 40px; height: 40px; color: white;">
                            <i class="bi bi-person"></i></div>`;
                }
            }
        },
        {
            title: 'Nombres',
            data: null,
            render: (data, type, row) => {
                return `${row.nombre1} ${row.nombre2 || ''}`.trim();
            }
        },
        {
            title: 'Apellidos',
            data: null,
            render: (data, type, row) => {
                return `${row.apellido1} ${row.apellido2 || ''}`.trim();
            }
        },
        {
            title: 'Teléfono',
            data: 'telefono'
        },
        {
            title: 'Correo',
            data: 'correo'
        },
        {
            title: 'Rol',
            data: 'rol',
            width: '8%',
            render: (data, type, row) => {
                const badges = {
                    'administrador': '<span class="badge bg-danger">Administrador</span>',
                    'empleado': '<span class="badge bg-warning">Empleado</span>',
                    'cliente': '<span class="badge bg-info">Cliente</span>'
                };
                return badges[data] || '<span class="badge bg-secondary">Sin rol</span>';
            }
        },
        {
            title: 'Estado',
            data: 'situacion',
            width: '8%',
            render: (data, type, row) => {
                if (data == 1) {
                    return '<span class="badge bg-success">Activo</span>';
                } else {
                    return '<span class="badge bg-secondary">Inactivo</span>';
                }
            }
        },
        {
            title: 'Fecha Registro',
            data: 'fecha_creacion',
            width: '10%',
            render: (data, type, row) => {
                if (data) {
                    const fecha = new Date(data);
                    return fecha.toLocaleDateString('es-GT');
                }
                return 'N/A';
            }
        },
        {
            title: 'Opciones',
            data: 'id_usuario',
            searchable: false,
            orderable: false,
            width: '15%',
            render: (data, type, row, meta) => {
                const estadoBtn = row.situacion == 1
                    ? `<button class='btn btn-sm btn-outline-warning cambiar-estado mx-1' 
                        data-id="${data}" data-estado="0" title="Desactivar">
                        <i class='bi bi-toggle-on'></i></button>`
                    : `<button class='btn btn-sm btn-outline-success cambiar-estado mx-1' 
                        data-id="${data}" data-estado="1" title="Activar">
                        <i class='bi bi-toggle-off'></i></button>`;

                return `
                <div class='d-flex justify-content-center flex-wrap'>
                    <button class='btn btn-sm btn-warning modificar mx-1 mb-1' 
                        data-id="${data}" 
                        data-nombre1="${row.nombre1}"  
                        data-nombre2="${row.nombre2 || ''}"
                        data-apellido1="${row.apellido1}"
                        data-apellido2="${row.apellido2 || ''}"  
                        data-telefono="${row.telefono || ''}"   
                        data-dpi="${row.dpi || ''}"
                        data-correo="${row.correo}"
                        data-rol="${row.rol}"
                        data-situacion="${row.situacion}"
                        title="Modificar usuario">
                        <i class='bi bi-pencil-square'></i>
                    </button>
                    ${estadoBtn}
                    <button class='btn btn-sm btn-danger eliminar mx-1 mb-1' 
                        data-id="${data}"
                        data-nombre="${row.nombre1} ${row.apellido1}"
                        title="Eliminar usuario">
                        <i class="bi bi-trash3"></i>
                    </button>
                </div>
                `;
            }
        },
    ],
});

// Función para guardar usuario
const guardaUsuario = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormUsuarios, ['id_usuario', 'nombre2', 'apellido2', 'dpi', 'fotografia'])) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Formulario incompleto",
            text: "Complete los campos obligatorios",
            showConfirmButton: false,
            timer: 1500
        });
        BtnGuardar.disabled = false;
        return;
    }

    // Validar contraseña
    if (!validarContrasenaSegura()) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Contraseña insegura",
            text: "La contraseña no cumple con los requisitos de seguridad",
            showConfirmButton: false,
            timer: 2000
        });
        BtnGuardar.disabled = false;
        return;
    }

    // Validar coincidencia de contraseñas
    if (!validarCoincidenciaPassword()) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error",
            text: "Las contraseñas no coinciden",
            showConfirmButton: false,
            timer: 1500
        });
        BtnGuardar.disabled = false;
        return;
    }

    const body = new FormData(FormUsuarios);
    const url = '/app03_dgcm/guarda_usuario';
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
                timer: 1500
            });

            limpiarFormulario();

            setTimeout(async () => {
                const resultado = await Swal.fire({
                    title: '¿Desea ver los usuarios registrados?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, ver usuarios',
                    cancelButtonText: 'Seguir registrando'
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
        console.error('Error al guardar usuario:', error);
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

// Función para buscar usuarios
const buscaUsuarios = async () => {
    const url = '/app03_dgcm/busca_usuario';
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
            console.error('Respuesta del servidor:', textoRespuesta);
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

// Función para cargar estadísticas
const cargarEstadisticas = async () => {
    try {
        const respuesta = await fetch('/app03_dgcm/estadisticas_usuarios');
        const datos = await respuesta.json();

        if (datos.codigo === 1 && datos.data) {
            const stats = datos.data;
            totalUsuarios.textContent = stats.total || 0;
            totalAdmins.textContent = stats.admins || 0;
            totalEmpleados.textContent = stats.empleados || 0;
            totalClientes.textContent = stats.clientes || 0;
            usuariosActivos.textContent = stats.activos || 0;
            usuariosInactivos.textContent = stats.inactivos || 0;
        }
    } catch (error) {
        console.error('Error al cargar estadísticas:', error);
    }
}

// Función para buscar con filtros
const buscarConFiltros = async () => {
    const params = new URLSearchParams();

    if (filtroRol.value) params.append('rol', filtroRol.value);
    if (fechaDesde.value) params.append('fecha_desde', fechaDesde.value);
    if (fechaHasta.value) params.append('fecha_hasta', fechaHasta.value);
    if (buscarUsuario.value) params.append('buscar', buscarUsuario.value);

    try {
        const respuesta = await fetch(`/app03_dgcm/buscar_usuarios_filtros?${params}`);
        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            datosDeTabla.clear().draw();
            if (datos.data && datos.data.length > 0) {
                datosDeTabla.rows.add(datos.data).draw();
            }
        }
    } catch (error) {
        console.error('Error al filtrar:', error);
    }
}

// Función para llenar el formulario al modificar
const llenarFormulario = (e) => {
    const datos = e.currentTarget.dataset;

    document.getElementById('id_usuario').value = datos.id;
    document.getElementById('nombre1').value = datos.nombre1;
    document.getElementById('nombre2').value = datos.nombre2;
    document.getElementById('apellido1').value = datos.apellido1;
    document.getElementById('apellido2').value = datos.apellido2;
    document.getElementById('telefono').value = datos.telefono;
    document.getElementById('dpi').value = datos.dpi;
    document.getElementById('correo').value = datos.correo;
    document.getElementById('rol').value = datos.rol;
    document.getElementById('situacion').value = datos.situacion;

    // Limpiar contraseñas en modo edición
    document.getElementById('usuario_clave').value = '';
    document.getElementById('confirmar_clave').value = '';

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    mostrarFormulario('Modificar Usuario');
}

// Función para limpiar formulario
const limpiarFormulario = () => {
    FormUsuarios.reset();

    // Limpiar validaciones
    const inputs = FormUsuarios.querySelectorAll('.form-control, .form-select');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });

    // Limpiar vista previa de imagen
    const contenedor = document.getElementById('contenedorVistaPrevia');
    const imagen = document.getElementById('vistaPrevia');
    if (contenedor) {
        contenedor.classList.add('d-none');
        imagen.src = '';
    }

    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');

    tituloFormulario.textContent = 'Gestión de Usuarios';
}

// Función para modificar usuario
const modificaUsuario = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormUsuarios, ['nombre2', 'apellido2', 'dpi', 'usuario_clave', 'confirmar_clave', 'fotografia'])) {
        Swal.fire({
            position: "center",
            icon: "warning",
            title: "Formulario incompleto",
            text: "Complete los campos obligatorios",
            showConfirmButton: false,
            timer: 1500
        });
        BtnModificar.disabled = false;
        return;
    }

    // Si hay nueva contraseña, validarla
    if (usuarioClave.value && !validarContrasenaSegura()) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Contraseña insegura",
            text: "La nueva contraseña no cumple con los requisitos",
            showConfirmButton: false,
            timer: 2000
        });
        BtnModificar.disabled = false;
        return;
    }

    if (usuarioClave.value && !validarCoincidenciaPassword()) {
        Swal.fire({
            position: "center",
            icon: "error",
            title: "Error",
            text: "Las contraseñas no coinciden",
            showConfirmButton: false,
            timer: 1500
        });
        BtnModificar.disabled = false;
        return;
    }

    const body = new FormData(FormUsuarios);
    const url = '/app03_dgcm/modifica_usuario';
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
        console.error('Error al modificar usuario:', error);
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

// Función para eliminar usuario
const eliminaUsuario = async (e) => {
    const idUsuario = e.currentTarget.dataset.id;
    const nombreUsuario = e.currentTarget.dataset.nombre;

    const alertaConfirmaEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Estás seguro?",
        text: `El usuario "${nombreUsuario}" será eliminado del sistema`,
        showConfirmButton: true,
        confirmButtonText: "Sí, eliminar",
        confirmButtonColor: "#d33",
        cancelButtonText: "Cancelar",
        showCancelButton: true
    });

    if (!alertaConfirmaEliminar.isConfirmed) return;

    const body = new FormData();
    body.append('id_usuario', idUsuario);

    try {
        const respuesta = await fetch('/app03_dgcm/elimina_usuario', {
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
            buscaUsuarios();
            cargarEstadisticas();
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
        console.error('Error al eliminar usuario:', error);
        await Swal.fire({
            position: "center",
            icon: "error",
            title: "Error de conexión",
            text: "No se pudo conectar con el servidor",
            showConfirmButton: false,
            timer: 1500
        });
    }
};

// Función para cambiar estado del usuario
const cambiarEstadoUsuario = async (e) => {
    const idUsuario = e.currentTarget.dataset.id;
    const nuevoEstado = e.currentTarget.dataset.estado;
    const accion = nuevoEstado == 1 ? 'activar' : 'desactivar';

    const confirmacion = await Swal.fire({
        title: `¿${accion.charAt(0).toUpperCase() + accion.slice(1)} usuario?`,
        text: `Se va a ${accion} este usuario`,
        icon: 'question',
        showCancelButton: true,
        confirmButtonText: `Sí, ${accion}`,
        cancelButtonText: 'Cancelar'
    });

    if (!confirmacion.isConfirmed) return;

    const body = new FormData();
    body.append('id_usuario', idUsuario);
    body.append('nuevo_estado', nuevoEstado);

    try {
        const respuesta = await fetch('/app03_dgcm/cambiar_estado_usuario', {
            method: 'POST',
            body
        });

        const datos = await respuesta.json();

        if (datos.codigo === 1) {
            Swal.fire({
                position: "center",
                icon: "success",
                title: "¡Éxito!",
                text: datos.mensaje,
                showConfirmButton: false,
                timer: 1500
            });
            buscaUsuarios();
            cargarEstadisticas();
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
        console.error('Error al cambiar estado:', error);
    }
}

// Función para filtrar por estado
const filtrarPorEstado = (estado) => {
    const params = new URLSearchParams();
    params.append('situacion', estado);

    fetch(`/app03_dgcm/buscar_usuarios_filtros?${params}`)
        .then(response => response.json())
        .then(datos => {
            if (datos.codigo === 1) {
                datosDeTabla.clear().draw();
                if (datos.data && datos.data.length > 0) {
                    datosDeTabla.rows.add(datos.data).draw();
                }
            }
        })
        .catch(error => console.error('Error al filtrar por estado:', error));
}

// Función para mostrar vista previa de imagen
const mostrarVistaPrevia = (input) => {
    const archivo = input.files[0];
    const contenedor = document.getElementById('contenedorVistaPrevia');
    const imagen = document.getElementById('vistaPrevia');
    const infoArchivo = document.getElementById('infoArchivo');

    if (archivo) {
        // Validar tamaño (5MB máximo)
        const tamañoMB = archivo.size / (1024 * 1024);
        if (tamañoMB > 5) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Archivo muy grande",
                text: "La imagen no puede exceder 5MB",
                showConfirmButton: false,
                timer: 2000
            });
            input.value = '';
            return;
        }

        // Validar tipo de archivo
        const tiposPermitidos = ['image/jpeg', 'image/jpg', 'image/png', 'image/gif'];
        if (!tiposPermitidos.includes(archivo.type)) {
            Swal.fire({
                position: "center",
                icon: "error",
                title: "Formato no válido",
                text: "Solo se permiten imágenes JPG, PNG o GIF",
                showConfirmButton: false,
                timer: 2000
            });
            input.value = '';
            return;
        }

        // Crear vista previa
        const reader = new FileReader();
        reader.onload = function (e) {
            imagen.src = e.target.result;
            if (infoArchivo) {
                infoArchivo.textContent = `${archivo.name} (${tamañoMB.toFixed(2)} MB)`;
            }
            contenedor.classList.remove('d-none');

            // Animación suave
            contenedor.style.opacity = '0';
            setTimeout(() => {
                contenedor.style.transition = 'opacity 0.3s';
                contenedor.style.opacity = '1';
            }, 10);
        };
        reader.readAsDataURL(archivo);

    } else {
        contenedor.classList.add('d-none');
    }
}

// Función para eliminar vista previa
const eliminarVistaPrevia = () => {
    const input = document.getElementById('fotografia');
    const contenedor = document.getElementById('contenedorVistaPrevia');
    const imagen = document.getElementById('vistaPrevia');

    input.value = '';
    imagen.src = '';
    contenedor.classList.add('d-none');

    Swal.fire({
        position: "center",
        icon: "info",
        title: "Imagen eliminada",
        showConfirmButton: false,
        timer: 1000
    });
}

// Event Listeners

// Validaciones en tiempo real
validarTelefono.addEventListener('blur', validacionTelefono);
validarDPI.addEventListener('blur', validacionDPI);
contraseniaBtn.addEventListener('click', mostrarContrasenia);
usuarioClave.addEventListener('input', validarContrasenaSegura);
confirmarClave.addEventListener('blur', validarCoincidenciaPassword);

// Formulario
FormUsuarios.addEventListener('submit', guardaUsuario);

// Botones del formulario
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnModificar.addEventListener('click', modificaUsuario);

// Botones de acción
BtnVerUsuarios.addEventListener('click', () => {
    mostrarTabla();
});

BtnCrearUsuario.addEventListener('click', () => {
    limpiarFormulario();
    mostrarFormulario('Crear Nuevo Usuario');
});

BtnActualizarTabla.addEventListener('click', () => {
    buscaUsuarios();
    cargarEstadisticas();
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Tabla actualizada",
        showConfirmButton: false,
        timer: 1000
    });
});

// Filtros por estado
BtnFiltroActivos.addEventListener('click', () => {
    filtrarPorEstado(1);
    BtnFiltroActivos.classList.add('active');
    BtnFiltroInactivos.classList.remove('active');
});

BtnFiltroInactivos.addEventListener('click', () => {
    filtrarPorEstado(0);
    BtnFiltroInactivos.classList.add('active');
    BtnFiltroActivos.classList.remove('active');
});

// Filtros avanzados
filtroRol.addEventListener('change', buscarConFiltros);
fechaDesde.addEventListener('change', buscarConFiltros);
fechaHasta.addEventListener('change', buscarConFiltros);

// Búsqueda con delay
let timeoutBusqueda;
buscarUsuario.addEventListener('input', () => {
    clearTimeout(timeoutBusqueda);
    timeoutBusqueda = setTimeout(() => {
        buscarConFiltros();
    }, 500);
});

// Eventos del DataTable
datosDeTabla.on('click', '.modificar', llenarFormulario);
datosDeTabla.on('click', '.eliminar', eliminaUsuario);
datosDeTabla.on('click', '.cambiar-estado', cambiarEstadoUsuario);

// Eventos de fotografía
document.addEventListener('DOMContentLoaded', () => {
    // Inicializar formulario
    mostrarFormulario('Gestión de Usuarios');

    // Configurar eventos de imagen
    const inputFotografia = document.getElementById('fotografia');
    const btnEliminarImagen = document.getElementById('btnEliminarImagen');

    if (inputFotografia) {
        inputFotografia.addEventListener('change', (e) => {
            mostrarVistaPrevia(e.target);
        });
    }

    if (btnEliminarImagen) {
        btnEliminarImagen.addEventListener('click', eliminarVistaPrevia);
    }
});