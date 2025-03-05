<?php

    if (!isset($_SESSION)) {
        session_start();
    }
    
    $auth = $_SESSION['login'] ?? false;
    if (!isset($inicio)) {
        $inicio = false;
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bienes Raices</title>
    <link rel="stylesheet" href="../build/css/app.css">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,100..900;1,100..900&family=Roboto+Flex:opsz,wght@8..144,100..1000&display=swap" rel="stylesheet">
</head>
<body>
    <header class="header <?php echo $inicio ? 'inicio' : ''; ?>">
        <div class="contenedor contenido-header">
            <div class="barra">
                <a href="/">
                    <img src="/build/img/logo.svg" alt="Logo de Bienes Raices">
                </a>

                <div class="mobile-menu">
                    <img src="/build/img/barras.svg" alt="icono menu responsive">
                </div>

                <div class="derecha">
                    <nav class="navegacion">
                        <a href="nosotros">Nosotros</a>
                        <a href="anuncios">Anuncios</a>
                        <a href="blog">Blog</a>
                        <a href="contacto">Contacto</a>
                        <?php if ($auth): ?>
                        <a href="/admin" class="admin">Administrar</a>
                        <?php endif; ?>
                        <?php if ($auth): ?>
                        <a href="logout" class="cerrar-sesion">Cerrar Sesión</a>
                        <?php endif; ?>
                        <img class="dark-mode-button" src="/build/img/dark-mode.svg" alt="modo-oscuro">
                    </nav>
                </div>
                
            </div> <!--Cierre barra-->
            <?php echo $inicio ? '<h1>Venta de Casas y Departamentos Exclusivos de Lujo</h1>' : ''; ?>
        </div>
    </header>


    <?php echo $contenido; ?>


    <footer class="footer seccion">
        <div class="contenedor">
            <nav class="navegacion">
                <a href="nosotros">Nosotros</a>
                <a href="anuncios">Anuncios</a>
                <a href="blog">Blog</a>
                <a href="contacto">Contacto</a>
            </nav>
        </div>

        <p class="copyright">Todos los Derechos Reservados <?php echo date('Y');?> &copy;</p>
    </footer>

    <script src="../build/js/bundle.min.js"></script>
</body>
</html>