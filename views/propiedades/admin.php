<main class="contenedor seccion">
        <h1>Administración de Bienes Raíces</h1>

        <?php 
            if ($resultado) {
                $mensaje = mostrarNotificacion(intval($resultado));
                if ($resultado <> 4) {
                    if ($mensaje) { ?>
                        <p class="alerta exito"><?php echo s($mensaje) ?></p>
                 <?php   }
                } else {
                    ?> <p class="alerta error"><?php echo s($mensaje) ?></p>
              <?php  }
            } 
        ?>

        <a href="/propiedades/crear" class="boton boton-verde">Nueva Propiedad</a>
        <a href="/vendedores/crear" class="boton boton-amarillo">Nuevo Vendedor(a)</a>
        <a href="/entradas/crear" class="boton boton-amarillo">Nueva Entrada de Blog</a>

            <!------------------- LISTADO DE PROPIEDADES ------------------->

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
                        <a href="/propiedades/actualizar?id=<?php echo $propiedad->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        
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

        <!------------------- LISTADO DE VENDEDORES ------------------->

        <h2>Vendedores</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Nombre</th>
                    <th>Teléfono</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!-- Mostrar los resultados -->
                <?php foreach($vendedores as $vendedor): ?>
                
                <tr>
                    <td><?php echo $vendedor->id; ?></td>
                    <td><?php echo $vendedor->nombre . ' ' . $vendedor->apellido; ?></td>
                    <td><?php echo $vendedor->telefono; ?></td>
                    <td>
                        <a href="/vendedores/actualizar?id=<?php echo $vendedor->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        
                        <form method="POST" class="w-100 form-eliminacion" onsubmit="return abrirModal(event, <?php echo $vendedor->id; ?>, 'vendedor')">
                            <input type="hidden" name="id" value="<?php echo $vendedor->id ?>">
                            <input type="hidden" name="tipo" value="vendedor">
                            <input type="submit" class="boton-rojo-block" value="Eliminar">
                        </form>
                    </td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>

                <!------------------- LISTADO DE ENTRADAS DE BLOG ------------------->

        <h2>Entradas</h2>

        <table class="propiedades">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Título</th>
                    <th>Imagen</th>
                    <th>Fecha</th>
                    <th>Contenido</th>
                    <th>Acciones</th>
                </tr>
            </thead>

            <tbody> <!-- Mostrar los resultados -->
                <?php foreach($entradas as $entrada): ?>
                
                <tr>
                    <td><?php echo $entrada->id; ?></td>
                    <td><?php echo $entrada->titulo; ?></td>
                    <td><img src="/imagenes/<?php echo $entrada->imagen; ?>" class="imagen-tabla"></td>
                    <td><?php echo $entrada->fecha; ?></td>
                    <td><?php echo $entrada->contenido; ?></td>
                    <td>
                        <a href="/entradas/actualizar?id=<?php echo $entrada->id; ?>" class="boton-amarillo-block">Actualizar</a>
                        
                        <form method="POST" class="w-100 form-eliminacion" onsubmit="return abrirModal(event, <?php echo $entrada->id; ?>, 'entrada')">
                            <input type="hidden" name="id" value="<?php echo $entrada->id ?>">
                            <input type="hidden" name="tipo" value="entrada">
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
            <form id="formEliminar" method="POST" class="w-100" action="/propiedades/eliminar">
                <input type="hidden" name="id" id="idEliminar">
                <input type="hidden" name="tipo" id="tipoModal">
                <button type="submit" class="boton-rojo-block">Sí, eliminar</button>
                <button type="button" class="boton-amarillo-block" onclick="cerrarModal()">Cancelar</button>
            </form>
        </div>
    </div>