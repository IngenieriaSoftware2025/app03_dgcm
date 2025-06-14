import { Dropdown } from "bootstrap";
import Swal from 'sweetalert2';
import { validarFormulario } from '../funciones';

const FormLogin = document.getElementById('FormLogin');
const BtnLogin = document.getElementById('BtnLogin');
const mostrarAyudaBtn = document.getElementById('mostrarAyuda');


const mostrarAyuda = () => {
    Swal.fire({
        title: '📞 Ayuda y Soporte',
        html: `
            <div style="text-align: left;">
                <p><strong>Para obtener acceso al sistema, contacte al administrador:</strong></p>
                <hr>
                <p><i class="bi bi-telephone-fill"></i> <strong>Teléfono:</strong> 2345-6789</p>
                <p><i class="bi bi-envelope-fill"></i> <strong>Email:</strong> admin@sistema.com</p>
                <p><i class="bi bi-clock-fill"></i> <strong>Horario:</strong> Lunes a Viernes 8:00 AM - 5:00 PM</p>
            </div>
        `,
        icon: 'info',
        confirmButtonText: 'Entendido',
        confirmButtonColor: '#007bff',
        background: '#f8f9fa',
        customClass: {
            title: 'custom-title-class',
            htmlContainer: 'custom-text-class'
        }
    });
};

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
        const url = '/API/login';

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
            location.href = '/';
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

if (mostrarAyudaBtn) {
    mostrarAyudaBtn.addEventListener('click', mostrarAyuda);
}