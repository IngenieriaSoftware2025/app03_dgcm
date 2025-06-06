import { Dropdown } from "bootstrap";
import { Toast, Modal } from "bootstrap";
import Swal from "sweetalert2";

const FormRoles = document.getElementById('FormRoles');
const TableRoles = document.getElementById('TableRoles');
const BtnLimpiar = document.getElementById('BtnLimpiar');
const BtnGuardar = document.getElementById('BtnGuardar');
const BtnModificar = document.getElementById('BtnModificar');


// Controlar el estado del formulario
let accion = 'insertar';

// evento al cargar la página

document.addEventListener('DOMContentLoaded', function () {
    cargarRoles();

    FormRoles.addEventListener('submit', guardaRol);
    BtnModificar.addEventListener('click', modificarRol);
    BtnLimpiar.addEventListener('click', limpiarFormulario);
});

//  Cargar todos los roles
const cargarRoles = async () => {
    try {
        const url = '/app03_dgcm/roles_activos';
        const respuesta = await fetch(url);

        if (!respuesta.ok) {
            throw new Error('Error al cargar los roles');
        }
        const roles = await respuesta.json();
        mostrarRoles(roles);
    } catch (error) {
        console.error('Error al cargar los roles:', error);
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: 'No se pudieron cargar los roles'
        });
    }
};

// Mostrar los roles en la tabla
const mostrarRoles = (roles) => {
    let tabla = `
        <thead class="table-dark">
            <tr>
                <th class="text-center">No.</th>
                <th class="text-center">Nombre del Rol</th>
                <th class="text-center">Modificar</th>
                <th class="text-center">Eliminar</th>
            </tr>
        </thead>
        <tbody>
    `;

    if (roles && roles.length > 0) {
        // Ya no necesitas filtrar aquí porque vienen solo los activos
        roles.forEach(rol => {
            tabla += `
                <tr>
                    <td class="text-center">${rol.id_rol}</td>
                    <td>${rol.rol_nombre}</td>
                    <td class="text-center">
                        <button type="button" class="btn btn-warning btn-sm" onclick="buscarRol(${rol.id_rol})">
                            <i class="bi bi-pencil-square"></i>
                        </button>
                    </td>
                    <td class="text-center">
                        <button type="button" class="btn btn-danger btn-sm" onclick="eliminarRol(${rol.id_rol})">
                            <i class="bi bi-trash"></i>
                        </button>
                    </td>
                </tr>
            `;
        });
    } else {
        tabla += `
            <tr>
                <td colspan="4" class="text-center">No hay roles registrados</td>
            </tr>
        `;
    }

    tabla += '</tbody>';
    TableRoles.innerHTML = tabla;
};