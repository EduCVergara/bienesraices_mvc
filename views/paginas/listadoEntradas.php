<!-- Iterar -->
<?php foreach ($entradas as $entrada) { ?>
<article class="entrada-blog">
    <div class="imagen">
        <img loading="lazy" src="imagenes/<?php echo $entrada->imagen; ?>" alt="Imagen de la entrada">
    </div>

    <div class="texto-entrada">
        <a href="entrada?id=<?php echo $entrada->id; ?>">
            <h4><?php echo $entrada->titulo; ?></h4>
            <p class="informacion-meta">Escrito el: <span><?php echo $entrada->fecha; ?></span> por: <span>Admin</span></p>

            <p><?php echo $entrada->contenido; ?></p>
        </a>
    </div>
</article> <!-- Termino de Artículo -->
<?php }?>