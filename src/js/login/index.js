import { Dropdown } from "bootstrap";
import Swal from "sweetalert2";
import DataTable from "datatables.net-bs5";
import { validarFormulario } from "../funciones";
import { lenguaje } from "../lenguaje";

const formLogin = document.getElementById("FormLogin");
const btnLogin = document.getElementById("BtnLogin");
const togglePwd = document.getElementById("togglePassword");
const eyeIcon = document.getElementById("eyeIcon");
const alertas = document.getElementById("alertasLogin");

// Mostrar/ocultar contraseña
togglePwd.addEventListener("click", () => {
    const tipo = formLogin.usuario_clave.type === "password" ? "text" : "password";
    formLogin.usuario_clave.type = tipo;
    eyeIcon.classList.toggle("bi-eye");
    eyeIcon.classList.toggle("bi-eye-slash");
});

// ENVÍO DEL FORMULARIO
formLogin.addEventListener("submit", async e => {
    e.preventDefault();
    btnLogin.disabled = true;
    alertas.innerHTML = "";

    const data = new FormData(formLogin);

    try {
        const res = await fetch("/app03_dgcm/procesar_login", {
            method: "POST",
            body: data
        });
        const json = await res.json();

        if (json.codigo === 1) {
            // Éxito: redirigir a home/dashboard
            Swal.fire({
                icon: "success",
                title: "¡Bienvenido!",
                showConfirmButton: false,
                timer: 800
            }).then(() => {
                window.location.href = "/app03_dgcm/";
            });
        } else {
            // Credenciales inválidas: mostrar alerta
            alertas.innerHTML = `
        <div class="alert alert-danger" role="alert">
          ${json.mensaje}
        </div>
      `;
        }
    } catch (err) {
        alertas.innerHTML = `
      <div class="alert alert-warning" role="alert">
        Error de conexión. Intente de nuevo.
      </div>
    `;
    }

    btnLogin.disabled = false;
});