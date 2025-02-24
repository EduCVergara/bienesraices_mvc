document.addEventListener('DOMContentLoaded', function() { // 'DOMContentLoaded' Escucha que todo el documento esté cargado
    eventListeners();
    darkMode();

    // Formatear Precio Casa
    document.getElementById("precio").addEventListener("input", function () {
        let valor = this.value.replace(/\D/g, ""); // Solo números
        if (valor.length > 10) { 
            valor = valor.slice(0, 10); // Limita a 10 dígitos
        }

        if (valor === "") {
            this.value = "$ "; // Mantiene el símbolo $ aunque el usuario borre todo
            document.getElementById("valorLimpio").value = "";
            return;
        }

        let numero = parseInt(valor, 10);
        if (isNaN(numero)) { 
            this.value = "$ "; 
            document.getElementById("valorLimpio").value = ""; 
            return; 
        }

        let valorFormateado = numero.toLocaleString("es-CL"); // Formatea con puntos
        this.value = "$ " + valorFormateado;

        // Guarda el valor limpio sin "$" ni "."
        document.getElementById("valorLimpio").value = valor;
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
        }, 3000 + (index * 1000)); // Intervalo escalonado entre eliminaciones
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