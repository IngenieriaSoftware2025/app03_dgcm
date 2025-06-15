import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

const FormReparaciones = document.getElementById('FormReparaciones');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');

// Botones de acción
const BtnVerReparaciones = document.getElementById('BtnVerReparaciones');
const BtnCrearReparacion = document.getElementById('BtnCrearReparacion');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');

// Secciones del formulario y tabla
const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');
const tituloFormulario = document.getElementById('tituloFormulario');

// cambiar vistas
const mostrarFormulario = (titulo = 'Registrar Reparación') => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    tituloFormulario.textContent = titulo;

    // Scroll al formulario
    seccionFormulario.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// Evento para mostrar la tabla
const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');

    // Actualizar datos automáticamente
    buscaReparacion();

    // Scroll a la tabla
    seccionTabla.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}


// Inicializar DataTable
const datosDeTabla = new DataTable('#TableReparaciones', {
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
            data: 'id_reparacion',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        {
            title: 'Cliente',
            data: null,
            render: (data, type, row) => {
                return `${row.cliente_nombre} ${row.cliente_apellido || ''}`.trim();
            }
        },
        { title: 'Modelo', data: 'modelo_celular' },
        { title: 'IMEI', data: 'imei' },
        { title: 'Motivo', data: 'motivo' },
        { title: 'Estado', data: 'estado' },
        { title: 'Prioridad', data: 'prioridad' },
        {
            title: 'Costo Total',
            data: null,
            render: (data, type, row) => {
                const total = parseFloat(row.total_cobrado || 0);
                return `Q${total.toFixed(2)}`;
            }
        },
        {
            title: 'Opciones',
            data: 'id_reparacion',
            searchable: false,
            orderable: false,
            render: (data, type, row, meta) => {
                return `
                <div class='d-flex justify-content-center'>
                    <button class='btn btn-warning modificar mx-1' 
                        data-id="${data}" 
                        data-id_cliente="${row.id_cliente}"  
                        data-id_empleado_asignado="${row.id_empleado_asignado || ''}"
                        data-id_tipo_servicio="${row.id_tipo_servicio || ''}"
                        data-id_celular="${row.id_celular}"  
                        data-imei="${row.imei || ''}"   
                        data-motivo="${row.motivo}"
                        data-diagnostico="${row.diagnostico || ''}"
                        data-solucion="${row.solucion || ''}"
                        data-costo_servicio="${row.costo_servicio || ''}"
                        data-costo_repuestos="${row.costo_repuestos || ''}"
                        data-total_cobrado="${row.total_cobrado || ''}"
                        data-estado="${row.estado}"
                        data-prioridad="${row.prioridad}"
                        data-observaciones="${row.observaciones || ''}">
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


// Guardar reparación
const guardaReparacion = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormReparaciones, ['id_reparacion', 'id_empleado_asignado', 'id_tipo_servicio', 'diagnostico', 'solucion', 'fecha_asignacion', 'fecha_inicio_trabajo', 'fecha_terminado', 'fecha_entrega', 'costo_servicio', 'costo_repuestos', 'total_cobrado', 'observaciones'])) {
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

    const body = new FormData(FormReparaciones);

    const url = '/app03_carbajal_clase/guarda_reparacion';
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

            setTimeout(async () => {
                const resultado = await Swal.fire({
                    title: '¿Desea ver las reparaciones registradas?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, ver reparaciones',
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
        console.log(error);
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
}


// Buscar reparaciones
const buscaReparacion = async () => {
    const url = '/app03_carbajal_clase/busca_reparacion';
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

// Llenar formulario
const llenarFormulario = (e) => {
    const datos = e.currentTarget.dataset;

    document.getElementById('id_reparacion').value = datos.id;
    document.getElementById('id_cliente').value = datos.id_cliente;
    document.getElementById('id_empleado_asignado').value = datos.id_empleado_asignado;
    document.getElementById('id_tipo_servicio').value = datos.id_tipo_servicio;
    document.getElementById('id_celular').value = datos.id_celular;
    document.getElementById('imei').value = datos.imei;
    document.getElementById('motivo').value = datos.motivo;
    document.getElementById('diagnostico').value = datos.diagnostico;
    document.getElementById('solucion').value = datos.solucion;
    document.getElementById('costo_servicio').value = datos.costo_servicio;
    document.getElementById('costo_repuestos').value = datos.costo_repuestos;
    document.getElementById('total_cobrado').value = datos.total_cobrado;
    document.getElementById('estado').value = datos.estado;
    document.getElementById('prioridad').value = datos.prioridad;
    document.getElementById('observaciones').value = datos.observaciones;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    mostrarFormulario('Modificar Reparación');
}


// Limpiar formulario
const limpiarFormulario = () => {
    FormReparaciones.reset();

    // Limpiar validaciones
    const inputs = FormReparaciones.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });

    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');

    //CAMBIAR TÍTULO CUANDO SE LIMPIE
    tituloFormulario.textContent = 'Registrar Reparación';
}

// Modificar reparación
const modificaReparacion = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormReparaciones, ['id_empleado_asignado', 'id_tipo_servicio', 'diagnostico', 'solucion', 'fecha_asignacion', 'fecha_inicio_trabajo', 'fecha_terminado', 'fecha_entrega', 'costo_servicio', 'costo_repuestos', 'total_cobrado', 'observaciones'])) {
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

    const body = new FormData(FormReparaciones);
    const url = '/app03_carbajal_clase/modifica_reparacion';
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
        console.log(error);
    }
    BtnModificar.disabled = false;
}

// Eliminar reparación
const eliminaReparacion = async (e) => {
    const idReparacion = e.currentTarget.dataset.id;

    const alertaConfirmaEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Estás seguro?",
        text: "La reparación será eliminada del sistema",
        showConfirmButton: true,
        confirmButtonText: "Sí, eliminar",
        confirmButtonColor: "red",
        cancelButtonText: "Cancelar",
        showCancelButton: true
    });

    if (!alertaConfirmaEliminar.isConfirmed) return;

    const body = new FormData();
    body.append('id_reparacion', idReparacion);

    try {
        const respuesta = await fetch('/app03_carbajal_clase/elimina_reparacion', {
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
            buscaReparacion();
        } else {
            await Swal.fire({
                position: "center",
                icon: "error",
                title: "Error",
                text: datos.mensaje
            });
        }
    } catch (error) {
        console.log(error);
    }
};


const cargarClientes = async () => {
    try {
        const respuesta = await fetch('/app03_carbajal_clase/busca_cliente');
        const datos = await respuesta.json();

        const select = document.getElementById('id_cliente');
        select.innerHTML = '<option value="">Seleccione un cliente</option>';

        if (datos.codigo === 1 && datos.data) {
            datos.data.forEach(cliente => {
                select.innerHTML += `<option value="${cliente.id_cliente}">${cliente.nombres} ${cliente.apellidos}</option>`;
            });
        }
    } catch (error) {
        console.error('Error cargando clientes:', error);
    }
}

const cargarTiposServicios = async () => {
    try {
        const respuesta = await fetch('/app03_carbajal_clase/busca_tipo_servicio');
        const datos = await respuesta.json();

        const select = document.getElementById('id_tipo_servicio');
        select.innerHTML = '<option value="">Seleccione un tipo de servicio</option>';

        if (datos.codigo === 1 && datos.data) {
            datos.data.forEach(servicio => {
                select.innerHTML += `<option value="${servicio.id_tipo_servicio}">${servicio.descripcion}</option>`;
            });
        }
    } catch (error) {
        console.error('Error cargando tipos de servicios:', error);
    }
}

const cargarEmpleados = async () => {
    try {
        const respuesta = await fetch('/app03_carbajal_clase/busca_empleado');
        const datos = await respuesta.json();

        const select = document.getElementById('id_empleado_asignado');
        select.innerHTML = '<option value="">Seleccione un empleado</option>';

        if (datos.codigo === 1 && datos.data) {
            datos.data.forEach(empleado => {
                select.innerHTML += `<option value="${empleado.id_empleado}">${empleado.codigo_empleado} - ${empleado.usuario_nombre || 'Sin nombre'}</option>`;
            });
        }
    } catch (error) {
        console.error('Error cargando empleados:', error);
    }
}

const cargarCelulares = async () => {
    try {
        const respuesta = await fetch('/app03_carbajal_clase/busca_celular');
        const datos = await respuesta.json();

        const select = document.getElementById('id_celular');
        select.innerHTML = '<option value="">Seleccione un celular</option>';

        if (datos.codigo === 1 && datos.data) {
            datos.data.forEach(celular => {
                select.innerHTML += `<option value="${celular.id_celular}">${celular.modelo} - ${celular.marca_nombre || 'Sin marca'}</option>`;
            });
        }
    } catch (error) {
        console.error('Error cargando celulares:', error);
    }
}

// Cargar combos iniciales
const cargarCombos = async () => {
    await Promise.all([
        cargarClientes(),
        cargarCelulares(),
        cargarEmpleados(),
        cargarTiposServicios()
    ]);
}

// Eventos
FormReparaciones.addEventListener('submit', guardaReparacion);

// Botones
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnModificar.addEventListener('click', modificaReparacion);

// datosDeTabla
datosDeTabla.on('click', '.modificar', llenarFormulario);
datosDeTabla.on('click', '.eliminar', eliminaReparacion);

// Eventos de botones de acción
BtnVerReparaciones.addEventListener('click', () => {
    mostrarTabla();
});

BtnCrearReparacion.addEventListener('click', () => {
    limpiarFormulario();
    mostrarFormulario('Registrar Reparación');
});

BtnActualizarTabla.addEventListener('click', () => {
    buscaReparacion();
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Tabla actualizada",
        showConfirmButton: false,
        timer: 1000
    });
});

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', async () => {
    await cargarCombos();
    mostrarFormulario('Registrar Reparación');
});
