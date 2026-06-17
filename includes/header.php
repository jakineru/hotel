<!DOCTYPE html>

<head>
    <meta charset="UTF-8">
    <title>hotel123</title>
    <link rel="stylesheet" href="/hotel/css/style.css">
</head>

<body>
    <nav>
        <h3>hotel123</h3>
        <a href="/hotel/index.php">INICIO</a>
        <a href="/hotel/reset.php">(BORRAR SESIÓN)</a>
        <!-- si NO está logeado -->
        <?php if ($_SESSION['estado'] == 'deslogeado'): ?> 
            <a href="/hotel/login.php">LOGIN</a>
            <a href="/hotel/registro.php">REGISTRARME</a>

        <?php else: ?> 
            <!-- en caso d q si esté logeado -->
            <?php if ($_SESSION['usuario_actual']['rol'] == 'admin'): ?>
                <a href="/hotel/admin/index.php">PANEL ADMIN</a>
            <?php else: ?>
                <a href="/hotel/cliente/mis_reservas.php">MIS RESERVAS</a>
            <?php endif; ?>

            <a href="/hotel/logout.php">salir (<?php echo $_SESSION['usuario_actual']['nombres'] . ' ' . $_SESSION['usuario_actual']['apellidos']; ?>)</a>
        <?php endif; ?>
    </nav>
    <hr>