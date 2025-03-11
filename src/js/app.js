// Funciones de formato y validación
function formatearCampo(input, hiddenInput = null) {
    let cursorPos = input.selectionStart;
    let valor = input.value.replace(/\D/g, "");

    if (valor.length > 10) valor = valor.slice(0, 10);

    if (valor === "") {
        input.value = "$ ";
        if (hiddenInput) hiddenInput.value = "";
        return;
    }

    let nuevoValor = "$ " + parseInt(valor, 10).toLocaleString("es-CL");
    let diferencia = nuevoValor.length - input.value.length;

    input.value = nuevoValor;
    if (hiddenInput) hiddenInput.value = valor;

    input.setSelectionRange(cursorPos + diferencia, cursorPos + diferencia);
}

function aplicarFormatoPresupuesto() {
    const inputPresupuesto = document.getElementById("presupuesto");

    if (inputPresupuesto) {
        formatearCampo(inputPresupuesto);
        inputPresupuesto.addEventListener("input", () => formatearCampo(inputPresupuesto));
    }
}

// Dark Mode
function darkMode() {
    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');
    const botonDarkMode = document.querySelector('.dark-mode-button');

    if (prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', () => {
        document.body.classList.toggle('dark-mode');
    });

    botonDarkMode.addEventListener('click', () => {
        document.body.classList.toggle('dark-mode');
    });
}

// Event Listeners
function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');
    mobileMenu.addEventListener('click', navegacionResponsive);

    const metodoContacto = document.querySelectorAll('input[name="contacto[forma]"]');
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');
    navegacion.classList.toggle('mostrar');
}

// Eliminación de mensajes de confirmación
function borraMensaje() {
    const mensajes = document.querySelectorAll('.alerta');

    mensajes.forEach((mensaje, index) => {
        setTimeout(() => {
            mensaje.classList.add('fade-out');
            setTimeout(() => {
                mensaje.remove();
            }, 500);
        }, 4000 + (index * 2000));
    });
}

// Modal de confirmación de eliminación
function abrirModal(event, id, tipo) {
    event.preventDefault();

    if (!id || isNaN(id) || id <= 0) {
        alert("ID no válido. No se puede eliminar el elemento.");
        return false;
    }

    const modal = document.getElementById("modalConfirmacion");
    const formEliminar = document.getElementById("formEliminar");
    const inputId = document.getElementById("idEliminar");
    const inputTipo = document.getElementById("tipoModal");

    const rutas = {
        propiedad: "propiedades",
        vendedor: "vendedores",
        entrada: "entradas"
    };

    const ruta = rutas[tipo] || tipo;
    inputTipo.value = tipo;
    inputId.value = id;
    formEliminar.action = `/${ruta}/eliminar`;
    modal.style.display = "flex";
}

function cerrarModal() {
    document.getElementById("modalConfirmacion").style.display = "none";
}

// Mostrar métodos de contacto
function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');

    if (e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
            <input type="tel" placeholder="Tu Teléfono" id="telefono" maxlength="9" pattern="[0-9]{8,9}" name="contacto[telefono]">
            <p>Elija la fecha y la hora para ser contactado: </p>
            <label for="fecha">Fecha:</label>
            <input type="date" id="fecha" name="contacto[fecha]">
            <label for="hora">Hora:</label>
            <input type="time" id="hora" min="09:00" max="18:00" name="contacto[hora]">
        `;
    } else {
        contactoDiv.innerHTML = `
            <input type="email" placeholder="Tu E-Mail" id="email" name="contacto[email]" required>
        `;
    }
}

// Validación de tamaño de archivo
function validarPesoArchivo() {
    const inputArchivo = document.getElementById('imagen');

    if (inputArchivo) {
        inputArchivo.addEventListener('change', function (event) {
            const archivo = event.target.files[0];

            if (archivo) {
                const tamanoMaximo = 8 * 1024 * 1024; // 8MB en bytes

                if (archivo.size > tamanoMaximo) {
                    Swal.fire({
                        title: 'Archivo demasiado grande',
                        html: `El archivo seleccionado (${(archivo.size / 1024 / 1024).toFixed(2)} MB) supera el límite de 8MB.`,
                        icon: 'error',
                        confirmButtonText: 'Aceptar',
                        didOpen: () => {
                            // Aplica el modo oscuro si el body tiene la clase 'dark-mode'
                            if (document.body.classList.contains('dark-mode')) {
                                Swal.getPopup().classList.add('swal2-dark');
                            }
                        }
                    });

                    event.target.value = '';
                } else {
                    Swal.fire({
                        icon: 'success',
                        title: 'Archivo válido',
                        text: 'El archivo cumple con el tamaño requerido (8MB).',
                        confirmButtonText: 'Aceptar',
                        didOpen: () => {
                            // Aplica el modo oscuro si el body tiene la clase 'dark-mode'
                            if (document.body.classList.contains('dark-mode')) {
                                Swal.getPopup().classList.add('swal2-dark');
                            }
                        }
                    });
                }
            }
        });
    }
}

// Inicialización
document.addEventListener('DOMContentLoaded', function () {
    eventListeners();
    darkMode();
    aplicarFormatoPresupuesto();
    validarPesoArchivo();
    borraMensaje();

    const inputPrecio = document.getElementById("prePrecio");
    const inputHidden = document.getElementById("precio");

    if (inputPrecio && inputHidden) {
        inputPrecio.addEventListener("input", () => formatearCampo(inputPrecio, inputHidden));
        formatearCampo(inputPrecio, inputHidden);
    }

    const inputsNumericos = document.querySelectorAll("#habitaciones, #wc, #estacionamiento");
    inputsNumericos.forEach(input => {
        input.addEventListener("input", function () {
            let valor = this.value.trim();
            if (valor === "") {
                this.value = "";
                return;
            }

            let numero = parseInt(valor, 10);
            if (!isNaN(numero)) {
                if (numero < 1) {
                    this.value = 1;
                } else if (numero > 9) {
                    this.value = 9;
                }
            }
        });
    });
});