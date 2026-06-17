<?php
require_once '../includes/init.php';
if ($_SESSION['estado'] != 'logeado' || $_SESSION['usuario_actual']['rol'] != 'cliente') exit("acceso denegado");
require_once '../includes/header.php';

$ci = $_SESSION['usuario_actual']['ci'];
?>
<h2>mis reservas</h2>
<table border="1">
    <tr><th>habitación</th><th>ingreso</th><th>salida</th><th>estado</th><th>acción</th></tr>
    <?php foreach ($_SESSION['reservas'] as $id => $res): ?>
        <?php if ($res['ci_usuario'] == $ci): ?>
        <tr>
            <td><?php echo $res['numero_hab']; ?></td>
            <td><?php echo $res['fecha_in']; ?></td>
            <td><?php echo $res['fecha_out']; ?></td>
            <td><?php echo $res['estado_pago']; ?></td>
            <td>
                <?php if ($res['estado_pago'] == 'pendiente'): ?>
                    <a href="pago.php?id=<?php echo $id; ?>">pagar ahora</a>
                <?php endif; ?>
            </td>
        </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>
<?php require_once '../includes/footer.php'; ?>