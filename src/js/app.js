function formatearCampo(input, hiddenInput = null) {
    let cursorPos = input.selectionStart; // Guardamos la posición del cursor
    let valor = input.value.replace(/\D/g, ""); // Solo números

    if (valor.length > 10) valor = valor.slice(0, 10); // Máximo 10 dígitos

    if (valor === "") {
        input.value = "$ ";
        if (hiddenInput) hiddenInput.value = ""; // Limpia el campo oculto si es que existe
        return;
    }

    let nuevoValor = "$ " + parseInt(valor, 10).toLocaleString("es-CL"); // Formato con puntos
    let diferencia = nuevoValor.length - input.value.length; // Calculamos cambio en la longitud del string

    input.value = nuevoValor;
    if (hiddenInput) hiddenInput.value = valor; // Guarda sin puntos ni símbolos

    input.setSelectionRange(cursorPos + diferencia, cursorPos + diferencia); // Restauramos la posición del cursor
}

function aplicarFormatoPresupuesto() {
    const inputPresupuesto = document.getElementById("presupuesto");

    if (inputPresupuesto) {
        // Formato Inicial
        formatearCampo(inputPresupuesto);

        inputPresupuesto.addEventListener("input", function () {
            formatearCampo(inputPresupuesto);
        });
    }
}

document.addEventListener('DOMContentLoaded', function() { // 'DOMContentLoaded' Escucha que todo el documento esté cargado
    eventListeners();
    darkMode();
    aplicarFormatoPresupuesto();

    const inputPrecio = document.getElementById("prePrecio");
    const inputHidden = document.getElementById("precio");

    inputPrecio.addEventListener("input", function () {
        formatearCampo(inputPrecio, inputHidden);
    });

    // Aplica formato inicial al cargar la página
    formatearCampo(inputPrecio, inputHidden);

    const inputsNumericos = document.querySelectorAll("#habitaciones, #wc, #estacionamiento");

    inputsNumericos.forEach(input => {
        input.addEventListener("input", function () {
            let valor = this.value.trim(); // Eliminamos espacios en blanco

            // Si el campo está vacío, lo dejamos así
            if (valor === "") {
                this.value = "";
                return;
            }

            // Convertimos a número
            let numero = parseInt(valor, 10);

            // Si el valor es menor que 1 y no está vacío, lo cambia a 1
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

function darkMode() {

    const prefiereDarkMode = window.matchMedia('(prefers-color-scheme: dark)');

    // console.log(prefiereDarkMode.matches);

    if (prefiereDarkMode.matches) {
        document.body.classList.add('dark-mode');
    } else {
        document.body.classList.remove('dark-mode');
    }

    prefiereDarkMode.addEventListener('change', function() {
        document.body.classList.toggle('dark-mode');
    })

    const botonDarkMode = document.querySelector('.dark-mode-button');

    botonDarkMode.addEventListener('click', function() {
        document.body.classList.toggle('dark-mode');
    })
}

function eventListeners() {
    const mobileMenu = document.querySelector('.mobile-menu');

    mobileMenu.addEventListener('click', navegacionResponsive) //Escuchamos por un click

    // Muestra campos condicionales
    const metodoContacto = document.querySelectorAll('input[name="contacto[forma]"]');
    metodoContacto.forEach(input => input.addEventListener('click', mostrarMetodosContacto));
}

function navegacionResponsive() {
    const navegacion = document.querySelector('.navegacion');

    // if(navegacion.classList.contains('mostrar')) {
    //     navegacion.classList.remove('mostrar');
    // } else {
    //     navegacion.classList.add('mostrar');
    // } --- Este código indica que si la clase navegacion, dentro de su lista de clases contiene la clase 'mostrar', entonces la eliminará, y si no la tiene, la agregará. --
    // el código a continuación, hace exactamente lo mismo, Toggle = alternar

    navegacion.classList.toggle('mostrar');
}

// Eliminación de msje de confirmación

document.addEventListener('DOMContentLoaded', function() {
    eventListeners();
    if(window.innerWidth <= 768){
        temporaryClass(document.querySelector('.navegacion'), 'visibilidadTemporal', 500);
    }
 
    //Eliminar texto de confirmación de CRUD en admin/index.php
    borraMensaje();
});
 
function borraMensaje() {
    const mensajes = document.querySelectorAll('.alerta'); // Selecciona todos los mensajes

    mensajes.forEach((mensaje, index) => {
        setTimeout(() => {
            mensaje.classList.add('fade-out'); // Agrega la clase para el efecto
            setTimeout(() => {
                mensaje.remove(); // Elimina después del fade
            }, 500); // Debe coincidir con la duración del fade en CSS
        }, 4000 + (index * 2000)); // Intervalo escalonado entre eliminaciones
    });
}

// Modal confirmación de eliminación
function abrirModal(event, id, tipo) {
    event.preventDefault(); // Evita que el formulario se envíe

    if (!id || isNaN(id) || id <= 0) {
        alert("ID no válido. No se puede eliminar el elemento.");
        return false;
    }

    // Seleccionamos los elementos del modal
    const modal = document.getElementById("modalConfirmacion");
    const formEliminar = document.getElementById("formEliminar");
    const inputId = document.getElementById("idEliminar");
    const inputTipo = document.getElementById("tipoModal");

    // Definimos los nombres correctos de las rutas
    const rutas = {
        propiedad: "propiedades",
        vendedor: "vendedores",
        entrada: "entradas"
    };

    // Obtener el nombre correcto basado en el tipo
    const ruta = rutas[tipo] || tipo; // Si no está en el objeto, usa el mismo tipo

    // Asignamos los valores al modal
    inputTipo.value = tipo;
    inputId.value = id;

    // Modificamos dinámicamente el 'action' del formulario según el tipo
    formEliminar.action = `/${ruta}/eliminar`; // Ejemplo: "/propiedades/eliminar"

    // Mostramos el modal
    modal.style.display = "flex";
}

// Cerrar modal
function cerrarModal() {
    document.getElementById("modalConfirmacion").style.display = "none";
}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');
    
    if (e.target.value === 'telefono') {

        // Obtener la fecha actual en formato YYYY-MM-DD
        // const fechaFormato = new Date().toISOString().split('T')[0];

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
    aplicarFormatoPresupuesto(inputPresupuesto);
}

