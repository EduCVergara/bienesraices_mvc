<fieldset>
    <legend>Información General</legend>

    <label for="nombre">Nombre:</label>
    <input type="text" id="nombre" name="vendedor[nombre]" placeholder="Nombre Vendedor(a)" value="<?php echo s($vendedor->nombre);?>">

    <label for="apellido">Apellido:</label>
    <input type="text" id="apellido" name="vendedor[apellido]" placeholder="Apellido Vendedor(a)" value="<?php echo s($vendedor->apellido);?>">

</fieldset>

<fieldset>
    <legend>Información Extra</legend>

    <label for="telefono">Teléfono:</label>
    <input type="text" id="telefono" maxlength="9" pattern="[0-9]{8,9}" name="vendedor[telefono]" placeholder="Teléfono Vendedor(a) (Máximo 9 dígitos)" value="<?php echo s($vendedor->telefono);?>">
</fieldset>