document.addEventListener('DOMContentLoaded', function() { // 'DOMContentLoaded' Escucha que todo el documento esté cargado
    eventListeners();
    darkMode();

    const inputPrecio = document.getElementById("prePrecio");
    const inputHidden = document.getElementById("precio");

    function formatearPrecio() {
        let valor = inputPrecio.value.replace(/\D/g, ""); // Quita caracteres no numéricos
        if (valor) {
            inputPrecio.value = "$ " + parseInt(valor, 10).toLocaleString("es-CL");
            inputHidden.value = parseInt(valor, 10); // Solo números sin puntos ni comas
        }
    }

    inputPrecio.addEventListener("input", function () {
        let valor = this.value.replace(/\D/g, ""); // Solo números
        if (valor.length > 10) valor = valor.slice(0, 10); // Máximo 10 dígitos

        if (valor === "") {
            this.value = "$ ";
            inputHidden.value = "";
            return;
        }

        this.value = "$ " + parseInt(valor, 10).toLocaleString("es-CL"); // Formato con puntos
        inputHidden.value = valor; // Guarda sin puntos ni símbolos
    });

    // Aplica formato al cargar la página
    formatearPrecio();

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

    // Guardamos el tipo en el input del modal
    document.getElementById("tipoModal").value = tipo;
    // Guardamos el ID en el input del modal
    document.getElementById("idEliminar").value = id;
    // Mostramos el modal
    document.getElementById("modalConfirmacion").style.display = "flex";
}

function cerrarModal() {
    document.getElementById("modalConfirmacion").style.display = "none";
}

function mostrarMetodosContacto(e) {
    const contactoDiv = document.querySelector('#contacto');
    
    if (e.target.value === 'telefono') {
        contactoDiv.innerHTML = `
            <input type="tel" placeholder="Tu Teléfono" id="telefono" name="contacto[telefono]">

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