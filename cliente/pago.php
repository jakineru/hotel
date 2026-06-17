<?php
require_once '../includes/init.php';
if ($_SESSION['estado'] != 'logeado') exit("acceso denegado");

$id_reserva = $_GET['id'] ?? null;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = $_POST['id_reserva'];
    // cambio el estado
    $_SESSION['reservas'][$id]['estado_pago'] = 'pagado';
    // notificación simulando notificación "por mail"
    echo "<script>alert('PAGO REGISTRADO'); window.location.href='mis_reservas.php';</script>";
    exit;
}
require_once '../includes/header.php';
?>

<h2>pagar reserva</h2>

<form method="POST">
    <input type="hidden" name="id_reserva" value="<?php echo $id_reserva; ?>">
    <input type="text" placeholder="N° TARJETA" required><br>
    <button type="submit" onclick="return confirm('¿confirmar pago?');">simular pago</button>
</form>

<?php require_once '../includes/footer.php'; ?>