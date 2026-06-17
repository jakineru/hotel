<?php
require_once '../includes/init.php';

// si no es admin, lo mando al login
if ($_SESSION['estado'] != 'logeado' || $_SESSION['usuario_actual']['rol'] != 'admin') {
    header("Location: ../login.php?msg=acceso_denegado");
    exit;
}

// contar elementos
$cant_usuarios = count($_SESSION['usuarios']);
$cant_habitaciones = count($_SESSION['habitaciones']);
$cant_reservas = count($_SESSION['reservas']);

require_once '../includes/header.php';
?>

<h2>panel de administrador</h2>

<div class="habitaciones-list" style="margin-top: 20px;">

    <div class="card" style="text-align: center;">
        <h3 class="admin-titulo">Usuarios</h3>
        <p style="font-size: 2.5em; font-weight: bold; color: var(--color1); margin: 10px 0;">
            <?php echo $cant_usuarios; ?>
        </p>
        <p style="margin-bottom: 20px; color: #666;">clientes y administradores</p>
        <a href="usuarios.php" class="btn-admin">gestionar usuarios</a>
    </div>

    <div class="card" style="text-align: center;">
        <h3 class="admin-titulo">Habitaciones</h3>
        <p style="font-size: 2.5em; font-weight: bold; color: var(--color1); margin: 10px 0;">
            <?php echo $cant_habitaciones; ?>
        </p>
        <p style="margin-bottom: 20px; color: #666;">crear, editar y desactivar</p>
        <a href="habitaciones.php" class="btn-admin">gestionar habitaciones</a>
    </div>

    <div class="card" style="text-align: center;">
        <h3 class="admin-titulo">Reservas</h3>
        <p style="font-size: 2.5em; font-weight: bold; color: var(--color1); margin: 10px 0;">
            <?php echo $cant_reservas; ?>
        </p>
        <p style="margin-bottom: 20px; color: #666;">historial de reservas y estados de pago</p>
        <a href="reservas.php" class="btn-admin">ver reservas</a>
    </div>

</div>

<?php require_once '../includes/footer.php'; ?>