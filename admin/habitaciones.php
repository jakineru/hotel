<?php
require_once '../includes/init.php';

// SOLO ADMIN
if ($_SESSION['estado'] != 'logeado' || $_SESSION['usuario_actual']['rol'] != 'admin') {
    exit("acceso denegado");
}

// verificar si tocamos el botón de editar y si el número existe lo mando a editar
$hab_editar = null;
if (isset($_GET['editar']) && isset($_SESSION['habitaciones'][$_GET['editar']])) {
    $hab_editar = $_SESSION['habitaciones'][$_GET['editar']];
}

// procesar el formulario  con un post
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $numero = $_POST['numero'];
    
    $_SESSION['habitaciones'][$numero] = [
        'numero' => $numero,
        'tipo' => $_POST['tipo'],
        'precio' => $_POST['precio'],
        'capacidad' => $_POST['capacidad'],
        'descripcion' => $_POST['descripcion'],
        'estado' => $_POST['estado'],
        'imagen' => $_POST['imagen']
    ];
    
    // al guardar vuelvo a la página principal (como para crear)
    header("Location: habitaciones.php");
    exit;
}

require_once '../includes/header.php';
?>

<h2>gestión de habitaciones</h2>

<div class="card" style="width: 100%; max-width: 450px; margin-bottom: 30px;">
    <h3><?php echo $hab_editar ? "editar habitación " . $hab_editar['numero'] : "agregar nueva habitación"; ?></h3>
    
    <form method="POST">
        <label>número de habitación:</label>
        <input type="number" name="numero" 
               value="<?php echo $hab_editar ? $hab_editar['numero'] : ''; ?>" 
               placeholder="ej: 301" required 
               <?php echo $hab_editar ? 'readonly style="background:#eee; color:#666;"' : ''; ?>>
        
        <label>tipo de habitación:</label>
        <select name="tipo" required>
            <option value="simple" <?php echo ($hab_editar && $hab_editar['tipo'] == 'simple') ? 'selected' : ''; ?>>simple</option>
            <option value="doble" <?php echo ($hab_editar && $hab_editar['tipo'] == 'doble') ? 'selected' : ''; ?>>doble</option>
            <option value="suite" <?php echo ($hab_editar && $hab_editar['tipo'] == 'suite') ? 'selected' : ''; ?>>suite</option>
        </select>
        
        <label>precio por noche ($):</label>
        <input type="number" name="precio" 
               value="<?php echo $hab_editar ? $hab_editar['precio'] : ''; ?>" 
               placeholder="precio" required>
        
        <label>capacidad (personas):</label>
        <input type="number" name="capacidad" 
               value="<?php echo $hab_editar ? $hab_editar['capacidad'] : ''; ?>" 
               placeholder="personas" required>
        
        <label>descripción:</label>
        <input type="text" name="descripcion" 
               value="<?php echo $hab_editar ? $hab_editar['descripcion'] : ''; ?>" 
               placeholder="breve descripción" required>
        
        <label>dirección de la foto</label>
        <input type="text" name="imagen" 
               value="<?php echo $hab_editar ? $hab_editar['imagen'] : ''; ?>" 
               placeholder="https://... o /img/..." required>
        
        <label>estado actual:</label>
        <select name="estado" required>
            <option value="disponible" <?php echo ($hab_editar && $hab_editar['estado'] == 'disponible') ? 'selected' : ''; ?>>disponible</option>
            <option value="mantenimiento" <?php echo ($hab_editar && $hab_editar['estado'] == 'mantenimiento') ? 'selected' : ''; ?>>mantenimiento</option>
            <option value="inactiva" <?php echo ($hab_editar && $hab_editar['estado'] == 'inactiva') ? 'selected' : ''; ?>>baja / inactiva</option>
        </select>
        
        <div style="display: flex; gap: 10px; margin-top: 10px;">
            <button type="submit" style="flex: 1;">
                <?php echo $hab_editar ? "guardar cambios" : "crear habitación"; ?>
            </button>
            <?php if ($hab_editar): ?>
                <a href="habitaciones.php" style="padding: 10px; background: #666; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; text-align: center; flex: 1;">cancelar</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<h3>listado actual</h3>
<table border="1">
    <tr>
        <th>nro</th>
        <th>foto</th>
        <th>tipo</th>
        <th>precio</th>
        <th>capacidad</th>
        <th>estado</th>
        <th>acciones</th>
    </tr>
    <?php foreach ($_SESSION['habitaciones'] as $hab): ?>
    <tr>
        <td><?php echo $hab['numero']; ?></td>
        <td><img src="<?php echo $hab['imagen']; ?>" width="100" height="65" style="object-fit:cover; border-radius:4px;"></td>
        <td><?php echo $hab['tipo']; ?></td>
        <td>$<?php echo $hab['precio']; ?></td>
        <td><?php echo $hab['capacidad']; ?> pers.</td>
        <td>
            <span style="padding: 4px 8px; 
                        border-radius: 4px; 
                        font-size: 0.9em; 
                        font-weight: bold; 
                        background: <?php echo $hab['estado'] == 'disponible' ? '#e8f5e9; color:#2e7d32;' 
                        : ($hab['estado'] == 'mantenimiento' ? '#fff3e0; color:#ef6c00;' 
                        : '#ffebee; color:#c62828;'); ?>">
                <?php echo $hab['estado']; ?>
            </span>
        </td>
        <td>
            <a href="habitaciones.php?editar=<?php echo $hab['numero']; ?>" 
               style="color: var(--color1); font-weight: bold; text-decoration: none; border: 1px solid var(--color1); padding: 4px 8px; border-radius: 4px; font-size: 0.9em;">
               editar
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require_once '../includes/footer.php'; ?>