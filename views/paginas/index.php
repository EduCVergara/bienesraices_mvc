    <main class="contenedor seccion">
        <h1>Sobre Nosotros</h1>

        <?php include 'iconos.php'; ?>

    </main>

    <!-- Sección de Anuncios -->
    <section class="seccion contenedor">
        <h2>Casas y Departamentos en Venta</h2>

        <!-- Aquí van los anuncios -->
         <?php 
            include 'listado.php';
         ?>
        
        <div class="alinear-derecha">
            <a href="anuncios" class="boton-verde">Ver Todas las Propiedades</a>
        </div>
    </section>
    <!-- Sección de Anuncios -->

    <section class="imagen-contacto">
        <h2>Encuentra la casa de tus sueños</h2>
        <p>Llena el formulario de contacto y nos pondremos en contacto contigo a la brevedad</p>
        <a href="contacto" class="boton-amarillo">Contáctanos</a>
    </section>

    <div class="contenedor seccion seccion-inferior">
        <section class="blog">
            <h3>Nuestro Blog</h3>
            
            <!-- Aquí van las entradas -->
            <?php 
                include 'listadoEntradas.php';
            ?>
            
        </section>

        <section class="testimoniales">
            <h3>Testimoniales</h3>

            <div class="testimonial">
                <blockquote>
                    La empresa se comportó de una excelente forma, muy buena atención y la casa que me ofrecieron cumplió con todas mis expectativas.
                </blockquote>
                <p>- Anónimo</p>
            </div>
        </section>
    </div>