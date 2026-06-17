<?php
require_once '../includes/init.php';

requerir_login();

require_once '../includes/header.php';

$ci = $_SESSION['usuario_actual']['ci'];
?>

<h2>mis reservas</h2>

<table border="1" cellpadding="8" style="border-collapse: collapse; text-align: center;">
    <tr>
        <th>habitación</th>
        <th>noches</th>
        <th>ingreso</th>
        <th>salida</th>
        <th>subtotal</th>
        <th>estado</th>
        <th>acción</th>
    </tr>
    
    <?php foreach ($_SESSION['reservas'] as $id => $res): ?>
        <?php if ($res['ci_usuario'] == $ci): ?>
            <?php 
            try {
                $num_hab = $res['numero_hab'];

                // buscar hab en sesión
                if (!isset($_SESSION['habitaciones'][$num_hab])) {
                    throw new Exception("Habitación no encontrada");
                }
                $precio_unidad = $_SESSION['habitaciones'][$num_hab]['precio'];

                $fecha1 = strtotime($res['fecha_in']);
                $fecha2 = strtotime($res['fecha_out']);
                $segundos_diferencia = $fecha2 - $fecha1;
                
                // calcular fecha por diferencia de segundos (con el timestamp de la fecha)
                $noches = $segundos_diferencia / 86400;

                // total
                $subtotal = $noches * $precio_unidad;

            } catch (Exception $e) {
                // si hay errores pongo valores por defecto 
                $precio_unidad = 0;
                $noches = 0;
                $subtotal = 0;
            }
            ?>
            <tr>
                <td><?php echo $num_hab; ?></td>
                <td><?php echo $noches; ?></td>
                <td><?php echo $res['fecha_in']; ?></td>
                <td><?php echo $res['fecha_out']; ?></td>
                <td style="font-weight: bold;">$<?php echo $subtotal; ?></td>
                <td><?php echo $res['estado_pago']; ?></td>
                <td>
                    <?php if ($res['estado_pago'] == 'pendiente'): ?>
                        <a href="pago.php?id=<?php echo $id; ?>&total=<?php echo $subtotal; ?>">pagar ahora</a>
                    <?php endif; ?>
                </td>
            </tr>
        <?php endif; ?>
    <?php endforeach; ?>
</table>

<?php require_once '../includes/footer.php'; ?>