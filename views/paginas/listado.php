<div class="contenedor-anuncios">
    <!-- Iterar -->
    <?php foreach ($propiedades as $propiedad) { ?>
    <div class="anuncio"> <!-- Inicio Anuncio -->

        <img loading="lazy" src="/imagenes/<?php echo $propiedad->imagen; ?>" alt="anuncio">

        <div class="contenido-anuncio">
            <h3><strong><?php echo $propiedad->titulo; ?></strong></h3>
            <p><?php echo $propiedad->descripcion; ?></p>
            <p class="precio">$<?php echo number_format($propiedad->precio); ?></p>

            <ul class="iconos-caracteristicas">
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_wc.svg" alt="wc">
                    <p><?php echo $propiedad->wc; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_estacionamiento.svg" alt="estacionamiento">
                    <p><?php echo $propiedad->estacionamiento; ?></p>
                </li>
                <li>
                    <img class="icono" loading="lazy" src="build/img/icono_dormitorio.svg" alt="habitaciones">
                    <p><?php echo $propiedad->habitaciones; ?></p>
                </li>
            </ul>
            <a href="propiedad?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">
                Ver Propiedad
            </a>
        </div><!-- Contenido Anuncio -->
    </div><!-- Anuncio -->
    <?php }?>
</div><!-- Contenedor Anuncios -->