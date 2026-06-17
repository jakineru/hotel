<?php
require_once '../includes/init.php';

// SOLO ADMIN
if ($_SESSION['estado'] != 'logeado' || $_SESSION['usuario_actual']['rol'] != 'admin') {
    exit("acceso denegado");
}

// verifico el estao de edición
$res_editar = null;
if (isset($_GET['editar']) && isset($_SESSION['reservas'][$_GET['editar']])) {
    $res_editar = $_SESSION['reservas'][$_GET['editar']];
}

// procesar form
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_reserva = $_POST['id_reserva'];
    
    // si es una reserva nueva, creo un id visual
    if (empty($id_reserva)) {
        $id_reserva = uniqid();
    }
    
    $_SESSION['reservas'][$id_reserva] = [
        'id' => $id_reserva,
        'ci_usuario' => $_POST['ci_usuario'],
        'numero_hab' => $_POST['numero_hab'],
        'fecha_in' => $_POST['fecha_in'],
        'fecha_out' => $_POST['fecha_out'],
        'estado_pago' => $_POST['estado_pago']
    ];
    
    header("Location: reservas.php");
    exit;
}

require_once '../includes/header.php';
?>

<h2>gestión de reservas</h2>

<div class="card" style="width: 100%; max-width: 450px; margin-bottom: 30px;">
    <h3><?php echo $res_editar ? "editar reserva: " . substr($res_editar['id'], 0, 8) : "registrar reserva manual"; ?></h3>
    
    <form method="POST">
        <input type="hidden" name="id_reserva" value="<?php echo $res_editar ? $res_editar['id'] : ''; ?>">
        
        <label>documento del cliente (ci):</label>
        <input type="text" name="ci_usuario" value="<?php echo $res_editar ? $res_editar['ci_usuario'] : ''; ?>" required>
        
        <label>nro de habitación:</label>
        <input type="number" name="numero_hab" value="<?php echo $res_editar ? $res_editar['numero_hab'] : ''; ?>" required>
        
        <label>fecha ingreso:</label>
        <input type="date" name="fecha_in" value="<?php echo $res_editar ? $res_editar['fecha_in'] : ''; ?>" required>
        
        <label>fecha salida:</label>
        <input type="date" name="fecha_out" value="<?php echo $res_editar ? $res_editar['fecha_out'] : ''; ?>" required>
        
        <label>estado del pago:</label>
        <select name="estado_pago" required>
            <option value="pendiente" <?php echo ($res_editar && $res_editar['estado_pago'] == 'pendiente') ? 'selected' : ''; ?>>pendiente</option>
            <option value="pagado" <?php echo ($res_editar && $res_editar['estado_pago'] == 'pagado') ? 'selected' : ''; ?>>pagado</option>
        </select>
        
        <div style="display: flex; gap: 10px; margin-top: 10px;">
            <button type="submit" style="flex: 1;">
                <?php echo $res_editar ? "guardar cambios" : "crear reserva"; ?>
            </button>
            <?php if ($res_editar): ?>
                <a href="reservas.php" style="padding: 10px; background: #666; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; text-align: center; flex: 1;">cancelar</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<h3>todas las reservas</h3>
<table border="1">
    <tr>
        <th>id resv.</th>
        <th>cliente</th>
        <th>ci (cliente)</th>
        <th>habitación</th>
        <th>ingreso</th>
        <th>salida</th>
        <th>pago</th>
        <th>acciones</th>
    </tr>
    <?php 
    // si no hay pongo un mensaje bonito en la tabla
    if (empty($_SESSION['reservas'])): ?>
        <tr><td colspan="8" style="text-align: center; color: #666;">no hay reservas.</td></tr>
    <?php else: ?>
        <?php foreach ($_SESSION['reservas'] as $res): 
            // busco  los datos del cliente 
            $ci_cliente = $res['ci_usuario'];
            $nombre_cliente = "???";
            if (isset($_SESSION['usuarios'][$ci_cliente])) { // cruzar datos en la sesión de usuarios 
                $nombre_cliente = $_SESSION['usuarios'][$ci_cliente]['nombres'] . ' ' . $_SESSION['usuarios'][$ci_cliente]['apellidos'];
            }
        ?>
        <tr>
            <!-- pongo los 8 primeros caracters de una pseudo-id -->
            <td style="color: #888; font-family: monospace;"><?php echo substr($res['id'], 0, 8); ?></td>
            <td><?php echo $nombre_cliente; ?></td>
            <td><?php echo $res['ci_usuario']; ?></td>
            <td><strong>#<?php echo $res['numero_hab']; ?></strong></td>
            <td><?php echo $res['fecha_in']; ?></td>
            <td><?php echo $res['fecha_out']; ?></td>
            <td>
                <!-- estado del pago (si figura como pagado o no) -->
                <span style="padding: 4px 8px; 
                            border-radius: 4px; 
                            font-size: 0.9em; 
                            font-weight: bold; 
                            background: <?php echo $res['estado_pago'] == 'pagado' ? '#e8f5e9; color:#2e7d32;' 
                            : '#fff3e0; color:#ef6c00;'; ?>">
                    <?php echo $res['estado_pago']; ?>
                </span>
            </td>
            <td>
                <a href="reservas.php?editar=<?php echo $res['id']; ?>" 
                   style="color: var(--color1); font-weight: bold; text-decoration: none; border: 1px solid var(--color1); padding: 4px 8px; border-radius: 4px; font-size: 0.9em;">
                   editar
                </a>
            </td>
        </tr>
        <?php endforeach; ?>
    <?php endif; ?>
</table>

<?php require_once '../includes/footer.php'; ?>