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

document.addEventListener('DOMContentLoaded', function (){
    cargarRoles();

    FormRoles.addEventListener('submit', guardaRol);
    BtnModificar.addEventListener('click', modificarRol);
    BtnLimpiar.addEventListener('click', limpiarFormulario);
});

//  Cargar todos los roles
const cargarRoles = async () => {
    try {
        const url = '/app03_dgcm/roles';
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
