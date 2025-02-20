<fieldset>
    <legend>Información General</legend>

    <label for="titulo">Título:</label>
    <input type="text" id="titulo" name="propiedad[titulo]" placeholder="Título de la propiedad" value="<?php echo s($propiedad->titulo);?>">

    <label for="precio">Precio:</label>
    <input type="number" id="precio" name="propiedad[precio]" placeholder="Precio de la propiedad" value="<?php echo s($propiedad->precio);?>">

    <label for="imagen">Imagen:</label>
    <input type="file" id="imagen" accept="image/jpeg, image/png" name="propiedad[imagen]">

    <?php if($propiedad->imagen): ?>
        <img src="/imagenes/<?php echo $propiedad->imagen ?>" class="imagen-small">
    <?php endif; ?>

    <label for="descripcion">Descripción</label>
    <textarea id="descripcion" placeholder="Ejemplo: Casa roja con puertas y ventanas" name="propiedad[descripcion]"><?php echo s($propiedad->descripcion);?></textarea>
    </fieldset>

    <fieldset>
    <legend>Información de la Propiedad</legend>

    <label for="habitaciones">Habitaciones:</label>
    <input type="number" id="habitaciones" placeholder="Ejemplo: 2" min="1" max="9" name="propiedad[habitaciones]" value="<?php echo s($propiedad->habitaciones);?>">

    <label for="wc">Baños:</label>
    <input type="number" id="wc" placeholder="Ejemplo: 1" min="1" max="9" name="propiedad[wc]" value="<?php echo s($propiedad->wc);?>">

    <label for="estacionamiento">Estacionamientos:</label>
    <input type="text" id="estacionamiento" placeholder="Ejemplo: 2" min="1" max="9" name="propiedad[estacionamiento]" value="<?php echo s($propiedad->estacionamiento);?>">
</fieldset>

<fieldset>
    <legend>Vendedor</legend>
    <label for="vendedor">Vendedor</label>
    <select name="propiedad[vendedores_id]" id="vendedor">
        <option selected disabled value="">-- Seleccione --</option>
        <?php foreach ($vendedores as $vendedor) {?>
            <option <?php echo $propiedad->vendedores_id === $vendedor->id ? 'selected' : ''; ?> value="<?php echo s($vendedor->id) ?>"><?php echo s($vendedor->nombre . ' ' . $vendedor->apellido) ?></option>
        <?php } ?>
    </select>
</fieldset>