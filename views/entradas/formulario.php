<fieldset>
    <legend>Información de la Entrada</legend>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="entrada[titulo]" placeholder="Título de la Entrada" value="<?php echo s($entrada->titulo);?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="entrada[imagen]">

    <?php if($entrada->imagen): ?>
        <img src="/imagenes/<?php echo $entrada->imagen ?>" class="imagen-small">
    <?php endif; ?>

    <label for="fecha">Fecha:</label>
    <input type="date" id="fecha" name="entrada[fecha]" placeholder="Título de la Entrada" value="<?php echo s($entrada->fecha);?>">

    <label for="contenido">Contenido:</label>
    <textarea id="contenido" placeholder="Ejemplo: Tips de cómo decorar tu hogar" name="entrada[contenido]"><?php echo s($entrada->contenido);?></textarea>
</fieldset>