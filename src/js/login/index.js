import { Dropdown } from "bootstrap";
import Swal from 'sweetalert2';
import { validarFormulario } from '../funciones';

const FormLogin = document.getElementById('FormLogin');
const BtnLogin = document.getElementById('BtnLogin');

const login = async (e) => {
    e.preventDefault();

    BtnLogin.disabled = true;

    if (!validarFormulario(FormLogin, [''])) {
        Swal.fire({
            title: 'Campos vacíos',
            text: 'Debe llenar todos los campos',
            icon: 'info'
        });
        BtnLogin.disabled = false;
        return;
    }

    try {
        const body = new FormData(FormLogin);
        const url = '/app03_carbajal_clase/API/login';

        const config = {
            method: 'POST',
            body
        };

        const respuesta = await fetch(url, config);
        const data = await respuesta.json();
        const { codigo, mensaje } = data;

        if (codigo == 1) {
            await Swal.fire({
                title: 'Exito',
                text: mensaje,
                icon: 'success',
                showConfirmButton: true,
                timer: 1500,
                timerProgressBar: false,
                background: '#e0f7fa',
                customClass: {
                    title: 'custom-title-class',
                    text: 'custom-text-class'
                }

            });

            FormLogin.reset();
            location.href = '/app03_carbajal_clase/';
        } else {
            Swal.fire({
                title: '¡Error!',
                text: mensaje,
                icon: 'warning',
                showConfirmButton: true,
                timer: 1500,
                timerProgressBar: false,
                background: '#e0f7fa',
                customClass: {
                    title: 'custom-title-class',
                    text: 'custom-text-class'
                }

            });
        }

    } catch (error) {
        console.log(error);
    }

    BtnLogin.disabled = false;
};

FormLogin.addEventListener('submit', login);