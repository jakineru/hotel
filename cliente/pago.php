<?php
require_once '../includes/init.php';
if ($_SESSION['estado'] != 'logeado') exit("acceso denegado");

$id_reserva = $_GET['id'] ?? null;
$total = 0;

$id_reserva = $_GET['id'] ?? null;
$total = 0;
$error_pago = ""; 

try {
    if (!$id_reserva || !isset($_SESSION['reservas'][$id_reserva])) {
        throw new Exception("Esta reserva no existe.");
    }

    $num_hab = $_SESSION['reservas'][$id_reserva]['numero_hab'];
    $precio_unidad = $_SESSION['habitaciones'][$num_hab]['precio'];
    
    // obtengo el total de las noches nuevamente
    $fecha1 = strtotime($_SESSION['reservas'][$id_reserva]['fecha_in']);
    $fecha2 = strtotime($_SESSION['reservas'][$id_reserva]['fecha_out']);
    $noches = ($fecha2 - $fecha1) / 86400;
    if ($noches <= 0) {
        $noches = 1;
    }

    // precio finak
    $total = $noches * $precio_unidad;

} catch (Exception $e) {
    // cazo errores con catch
    header("Location: mis_reservas.php?error=" . urlencode($e->getMessage()));
    exit;
}

if (es_post()) {
    try {
        validar_campos_vacios(['nro_tarjeta']);
        validar_tarjeta($_POST['nro_tarjeta']);

        $id = $_POST['id_reserva'];
        
        if (isset($_SESSION['reservas'][$id])) {
            $_SESSION['reservas'][$id]['estado_pago'] = 'pagado';
            echo "<script>alert('PAGO REGISTRADO EXITOSAMENTE'); window.location.href='mis_reservas.php';</script>";
            exit;
        }
    } catch (Exception $e) {
        $error_pago = $e->getMessage();
    }
}

require_once '../includes/header.php';
?>

<h2>pagar reserva</h2>

<?php if (!empty($error_pago)): ?>
    <div class="error">
        <?php echo $error_pago; ?>
    </div>
<?php endif; ?>

<form method="POST">
    <input type="hidden" name="id_reserva" value="<?php echo $id_reserva; ?>">
    <input type="number" name="nro_tarjeta" placeholder="N° TARJETA"><br>
    <p style="font-size: 1S0px; color: #555; margin: 0 0 20px;">
        Se debitarán <strong>$<?php echo $total; ?></strong> en tu tarjeta.
    </p>
    <button type="submit">simular pago</button>
</form>

<?php require_once '../includes/footer.php'; ?>