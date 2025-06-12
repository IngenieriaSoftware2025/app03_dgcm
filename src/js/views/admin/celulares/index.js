import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario, Toast } from "../../../funciones";
import { lenguaje } from "../../../lenguaje";

const FormCelulares = document.getElementById('FormCelulares');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');
const BtnLimpiar = document.getElementById('BtnLimpiar');

// Botones de acción
const BtnVerInventario = document.getElementById('BtnVerInventario');
const BtnCrearCelular = document.getElementById('BtnCrearCelular');
const BtnActualizarTabla = document.getElementById('BtnActualizarTabla');

// Secciones del formulario y tabla
const seccionFormulario = document.getElementById('seccionFormulario');
const seccionTabla = document.getElementById('seccionTabla');
const tituloFormulario = document.getElementById('tituloFormulario');

// Cambiar vistas
const mostrarFormulario = (titulo = 'Registrar Celular') => {
    seccionFormulario.classList.remove('d-none');
    seccionTabla.classList.add('d-none');
    tituloFormulario.textContent = titulo;

    // Scroll al formulario
    seccionFormulario.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

const mostrarTabla = () => {
    seccionFormulario.classList.add('d-none');
    seccionTabla.classList.remove('d-none');

    // Actualizar datos automáticamente
    buscaCelular();

    // Scroll a la tabla
    seccionTabla.scrollIntoView({
        behavior: 'smooth',
        block: 'start'
    });
}

// DataTable
const datosDeTabla = new DataTable('#TableCelulares', {
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
            data: 'id_celular',
            width: '5%',
            render: (data, type, row, meta) => meta.row + 1
        },
        {
            title: 'Marca',
            data: 'marca_nombre',
            width: '15%'
        },
        {
            title: 'Modelo',
            data: 'modelo',
            width: '20%'
        },
        {
            title: 'Precio Compra',
            data: 'precio_compra',
            width: '12%',
            render: (data) => `Q.${parseFloat(data || 0).toLocaleString('es-GT', { minimumFractionDigits: 2 })}`
        },
        {
            title: 'Precio Venta',
            data: 'precio_venta',
            width: '12%',
            render: (data) => `Q.${parseFloat(data).toLocaleString('es-GT', { minimumFractionDigits: 2 })}`
        },
        {
            title: 'Stock',
            data: 'cantidad',
            width: '8%',
            render: (data) => {
                if (data == 0) {
                    return `<span class="badge bg-danger">${data}</span>`;
                } else if (data <= 5) {
                    return `<span class="badge bg-warning">${data}</span>`;
                } else {
                    return `<span class="badge bg-success">${data}</span>`;
                }
            }
        },
        {
            title: 'Estado',
            data: 'situacion',
            width: '8%',
            render: (data) => {
                return data == 1 ?
                    '<span class="badge bg-success">Activo</span>' :
                    '<span class="badge bg-secondary">Inactivo</span>';
            }
        },
        {
            title: 'Opciones',
            data: 'id_celular',
            searchable: false,
            orderable: false,
            width: '20%',
            render: (data, type, row) => {
                return `
                <div class='d-flex justify-content-center gap-1'>
                    <button class='btn btn-warning btn-sm modificar' 
                        data-id="${data}" 
                        data-id_marca="${row.id_marca}"
                        data-modelo="${row.modelo}"
                        data-descripcion="${row.descripcion || ''}"
                        data-precio_compra="${row.precio_compra || 0}"
                        data-precio_venta="${row.precio_venta}"
                        data-cantidad="${row.cantidad}"
                        data-situacion="${row.situacion}">
                        <i class='bi bi-pencil-square me-1'></i> Modificar
                    </button>
                    <button class='btn btn-danger btn-sm eliminar' 
                        data-id="${data}"
                        data-modelo="${row.modelo}">
                        <i class="bi bi-trash3 me-1"></i>Eliminar
                    </button>
                </div>
                `;
            }
        },
    ],
});

// Cargar marcas en el select
const cargarMarcas = async () => {
    try {
        const response = await fetch('/app03_dgcm/api/marcas/activas');
        const data = await response.json();

        if (data.codigo === 1) {
            const selectMarca = document.getElementById('id_marca');
            selectMarca.innerHTML = '<option value="">-- Selecciona una marca --</option>';

            data.data.forEach(marca => {
                selectMarca.innerHTML += `<option value="${marca.id_marca}">${marca.marca_nombre}</option>`;
            });
        }
    } catch (error) {
        console.error('Error cargando marcas:', error);
    }
}

// Guardar celular
const guardaCelular = async (e) => {
    e.preventDefault();
    BtnGuardar.disabled = true;

    if (!validarFormulario(FormCelulares, ['id_celular', 'descripcion'])) {
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

    const body = new FormData(FormCelulares);
    const url = '/app03_dgcm/api/celulares/guardar';
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
                    title: '¿Desea ver el inventario actualizado?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonText: 'Sí, ver inventario',
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
            timer: 1000
        });
    }
    BtnGuardar.disabled = false;
}

// Buscar celulares
const buscaCelular = async () => {
    const url = '/app03_dgcm/api/celulares/buscar';
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

// Llenar formulario para modificar
const llenarFormulario = (e) => {
    const datos = e.currentTarget.dataset;

    document.getElementById('id_celular').value = datos.id;
    document.getElementById('id_marca').value = datos.id_marca;
    document.getElementById('modelo').value = datos.modelo;
    document.getElementById('descripcion').value = datos.descripcion;
    document.getElementById('precio_compra').value = datos.precio_compra;
    document.getElementById('precio_venta').value = datos.precio_venta;
    document.getElementById('cantidad').value = datos.cantidad;
    document.getElementById('situacion').value = datos.situacion;

    BtnGuardar.classList.add('d-none');
    BtnModificar.classList.remove('d-none');

    mostrarFormulario('Modificar Celular');
}

// Limpiar formulario
const limpiarFormulario = () => {
    FormCelulares.reset();

    // Limpiar validaciones
    const inputs = FormCelulares.querySelectorAll('.form-control');
    inputs.forEach(input => {
        input.classList.remove('is-valid', 'is-invalid');
    });

    BtnGuardar.classList.remove('d-none');
    BtnModificar.classList.add('d-none');

    // Cambiar título cuando se limpie
    tituloFormulario.textContent = 'Gestión de Inventario';
}

// Modificar celular
const modificaCelular = async (e) => {
    e.preventDefault();
    BtnModificar.disabled = true;

    if (!validarFormulario(FormCelulares, ['descripcion'])) {
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

    const body = new FormData(FormCelulares);
    const url = '/app03_dgcm/api/celulares/modificar';
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
        console.error('Error:', error);
    }
    BtnModificar.disabled = false;
}

// Eliminar celular
const eliminaCelular = async (e) => {
    const idCelular = e.currentTarget.dataset.id;
    const modelo = e.currentTarget.dataset.modelo;

    const alertaConfirmaEliminar = await Swal.fire({
        position: "center",
        icon: "question",
        title: "¿Estás seguro?",
        text: `El celular "${modelo}" será eliminado del inventario`,
        showConfirmButton: true,
        confirmButtonText: "Sí, eliminar",
        confirmButtonColor: "red",
        cancelButtonText: "Cancelar",
        showCancelButton: true
    });

    if (!alertaConfirmaEliminar.isConfirmed) return;

    const body = new FormData();
    body.append('id_celular', idCelular);

    try {
        const respuesta = await fetch('/app03_dgcm/api/celulares/eliminar', {
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
            buscaCelular();
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
    }
};

// Eventos
FormCelulares.addEventListener('submit', guardaCelular);

// Botones
BtnLimpiar.addEventListener('click', limpiarFormulario);
BtnModificar.addEventListener('click', modificaCelular);

// DataTable eventos
datosDeTabla.on('click', '.modificar', llenarFormulario);
datosDeTabla.on('click', '.eliminar', eliminaCelular);

// Eventos de botones de acción
BtnVerInventario.addEventListener('click', () => {
    mostrarTabla();
});

BtnCrearCelular.addEventListener('click', () => {
    limpiarFormulario();
    mostrarFormulario('Registrar Celular');
});

BtnActualizarTabla.addEventListener('click', () => {
    buscaCelular();
    Swal.fire({
        position: "center",
        icon: "success",
        title: "Inventario actualizado",
        showConfirmButton: false,
        timer: 1000
    });
});

// Inicializar al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    mostrarFormulario('Gestión de Inventario');
    cargarMarcas();
});