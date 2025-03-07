<main class="contenedor seccion">

        <?php 
        
            if ($mensajeExito) {
                echo '<p class="alerta exito">' . $mensajeExito . '</p>';
            } elseif($mensajeError) {
                echo '<p class="alerta error">' . $mensajeError . '</p>';
            }

        ?>

        <h1>Contacto</h1>

        <picture>
            <source srcset="build/img/destacada3.webp" type="image/webp">
            <source srcset="build/img/destacada3.jpg" type="image/jpeg">
            <img loading="lazy" src="build/img/destacada3.jpg" alt="Imagen contacto">
        </picture>

        <h2>Llene el formulario de contacto</h2>

        <form class="formulario" action="contacto" method="POST">
            <fieldset>
                <legend>Información Personal</legend>

                <label for="nombre">Nombre</label>
                <input type="text" placeholder="Tu Nombre" id="nombre" name="contacto[nombre]" required>

                <!-- EMail en JavaScript -->

                <!-- Telefono En JavaScript -->

                <label for="mensaje">Mensaje</label>
                <textarea id="mensaje" name="contacto[mensaje]" required></textarea>
            </fieldset>

            <fieldset>
                <legend>Información sobre la propiedad</legend>

                <label for="opciones">Compra o arrienda:</label>
                <select id="opciones" name="contacto[tipo]" required>
                    <option value="" disabled selected>-- Seleccione --</option>
                    <option value="Comprar">Compra</option>
                    <option value="Arrendar">Arrienda</option>
                </select>

                <label for="presupuesto">Presupuesto</label>
                <input type="text" id="presupuesto" placeholder="Tu presupuesto" name="contacto[presupuesto]" required>
            </fieldset>

            <fieldset>
                <legend>Contacto</legend>

                <h4>Seleccione su preferencia:</h4>

                <div class="forma-contacto">
                    <label for="contactar-telefono">Teléfono</label>
                    <input type="radio" value="telefono" id="contactar-telefono" maxlength="9" pattern="[0-9]{8,9}" name="contacto[forma]" required>

                    <label for="contactar-email">E-mail</label>
                    <input type="radio" value="email" id="contactar-email" name="contacto[forma]" required>
                </div>

                <div id="contacto"></div>

            </fieldset>

            <input type="submit" value="Enviar" class="boton-verde">

        </form>
    </main>