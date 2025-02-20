<main class="contenedor seccion">
        <h1>Administración de Bienes Raíces</h1>

        <?php 
            if ($resultado) {
                $mensaje = mostrarNotificacion(intval($resultado));
                if ($mensaje) { ?>
                    <p class="alerta exito"><?php echo s($mensaje) ?></p>
             <?php   }
            } 
        ?>

        <a href="/propiedades/crear" class="boton boton-verde">Nueva Propiedad</a>
        <a href="/vendedores/crear" class="boton boton-verde">Nuevo Vendedor(a)</a>
        <h2>Propiedades</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Precio</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!-- Mostrar los resultados -->
                <?php foreach($propiedades as $propiedad): ?>
                
                <tr>
                    <td><?php echo $propiedad->id; ?></td>
                    <td><?php echo $propiedad->titulo; ?></td>
                    <td><img src="/imagenes/<?php echo $propiedad->imagen; ?>" class="imagen-tabla"></td>
                    <td>$<?php echo number_format($propiedad->precio); ?></td>
                    <td>
                        <a href="admin/propiedades/actualizar.php?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        
                        <form method="POST" class="w-100 form-eliminacion" onsubmit="return abrirModal(event, <?php echo $propiedad->id; ?>, 'propiedad')">
                            <input type="hidden" name="id" value="<?php echo $propiedad->id ?>">
                            <input type="hidden" name="tipo" value="propiedad">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
</main>

    <!-- Modal de Confirmación -->
    <div id="modalConfirmacion" class="modal">
        <div class="modal-contenido">
            <h2>Confirmar Eliminación</h2>
            <p>¿Estás seguro de que deseas eliminar este elemento?</p>
            <form id="formEliminar" method="POST" class="w-100">
                <input type="hidden" name="id" id="idEliminar">
                <input type="hidden" name="tipo" id="tipoModal">
                <button type="submit" class="boton-rojo-block">Sí, eliminar</button>
                <button type="button" class="boton-amarillo-block" onclick="cerrarModal()">Cancelar</button>
            </form>
        </div>
    </div>