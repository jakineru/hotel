<?php
require_once '../includes/init.php';

// SOLO ADMIN
if ($_SESSION['estado'] != 'logeado' || $_SESSION['usuario_actual']['rol'] != 'admin') {
    exit("acceso denegado");
}

// verificar si estamos editando o creando uno
$usr_editar = null;
if (isset($_GET['editar']) && isset($_SESSION['usuarios'][$_GET['editar']])) {
    $usr_editar = $_SESSION['usuarios'][$_GET['editar']];
}

// procesar formulario
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ci = $_POST['ci'];
    
    $_SESSION['usuarios'][$ci] = [
        'ci' => $ci,
        'nombres' => $_POST['nombres'],
        'apellidos' => $_POST['apellidos'],
        'email' => $_POST['email'],
        'contra' => $_POST['contra'],
        'rol' => $_POST['rol'],
        'estado' => $_POST['estado']
    ];
    
    header("Location: usuarios.php");
    exit;
}

require_once '../includes/header.php';
?>

<!-- CREAR USUARIO NUEVO -->

<h2>gestión de usuarios</h2>

<div class="card" style="width: 100%; 
                        max-width: 450px; 
                        margin-bottom: 30px;">
    <h3><?php echo $usr_editar ? "editar usuario: " . $usr_editar['ci'] : "agregar NUEVO usuario:"; ?></h3>
    
    <form method="POST">
        <label>documento (ci):</label>
        <input type="number" name="ci" 
               value="<?php echo $usr_editar ? $usr_editar['ci'] : ''; ?>" 
               placeholder="ej: 12345678" required 
               <?php echo $usr_editar ? 'readonly style="background:#eee; color:#666;"' : ''; ?>>
        
        <label>nombres:</label>
        <input type="text" name="nombres" value="<?php echo $usr_editar ? $usr_editar['nombres'] : ''; ?>" required>
        
        <label>apellidos:</label>
        <input type="text" name="apellidos" value="<?php echo $usr_editar ? $usr_editar['apellidos'] : ''; ?>" required>
        
        <label>email:</label>
        <input type="email" name="email" value="<?php echo $usr_editar ? $usr_editar['email'] : ''; ?>" required>
        
        <label>contraseña:</label>
        <input type="password" name="contra" value="<?php echo $usr_editar ? $usr_editar['contra'] : ''; ?>" required>
        
        <label>rol en el sistema:</label>
        <select name="rol" required>
            <option value="cliente" <?php echo ($usr_editar && $usr_editar['rol'] == 'cliente') ? 'selected' : ''; ?>>cliente</option>
            <option value="admin" <?php echo ($usr_editar && $usr_editar['rol'] == 'admin') ? 'selected' : ''; ?>>administrador</option>
        </select>

        <label>estado:</label>
        <select name="estado" required>
            <option value="activo" <?php echo ($usr_editar && $usr_editar['estado'] == 'activo') ? 'selected' : ''; ?>>activo</option>
            <option value="inactivo" <?php echo ($usr_editar && $usr_editar['estado'] == 'inactivo') ? 'selected' : ''; ?>>inactivo (baja)</option>
        </select>
        
        <div style="display: flex; 
                    gap: 10px; 
                    margin-top: 10px;">
            <button type="submit" style="flex: 1;">
                <?php echo $usr_editar ? "guardar cambios" : "crear usuario"; ?>
            </button>
            <?php if ($usr_editar): ?>
                <a href="usuarios.php" style="padding: 10px; background: #666; color: white; text-decoration: none; border-radius: 6px; font-weight: bold; text-align: center; flex: 1;">cancelar</a>
            <?php endif; ?>
        </div>
    </form>
</div>

<!-- TABLA CON TODOS LOS USUARIOS -->

<h3>lista de usuarios registrados:</h3>
<table border="1">
    <tr>
        <th>cédula (ci)</th>
        <th>nombre del usuario</th>
        <th>email</th>
        <th>rol</th>
        <th>estado</th>
        <th>acciones</th>
    </tr>
    <?php foreach ($_SESSION['usuarios'] as $usr): ?>
    <tr>
        <td><?php echo $usr['ci']; ?></td>
        <td><?php echo $usr['nombres'] . ' ' . $usr['apellidos']; ?></td>
        <td><?php echo $usr['email']; ?></td>
        <td>
            <!-- ROL DENTRO DE LA PAGINA(?) -->
            <span style="padding: 4px 8px; 
                        border-radius: 4px; 
                        font-size: 0.8em; 
                        font-weight: bold; 
                        background: <?php echo $usr['rol'] == 'admin' ? '#e3f2fd; color:#1565c0;' 
                        : '#f5f5f5; color:#616161;'; ?>">
                <?php echo strtoupper($usr['rol']); ?>
            </span>
        </td>
        <td>
            <!-- ESTADO DEL USUARIO EN LA PSEUDOTABLA -->
            <span style="padding: 4px 8px; 
                        border-radius: 4px; 
                        font-size: 0.9em; 
                        font-weight: bold; 
                        background: <?php echo $usr['estado'] == 'activo' ? '#e8f5e9; color:#2e7d32;' 
                        : '#ffebee; color:#c62828;'; ?>">
                <?php echo $usr['estado']; ?>
            </span>
        </td>
        <td>
            <a href="usuarios.php?editar=<?php echo $usr['ci']; ?>" 
               style="color: var(--color1); 
                    font-weight: bold; 
                    text-decoration: none; 
                    border: 1px solid var(--color1); 
                    padding: 4px 8px; 
                    border-radius: 4px; 
                    font-size: 0.9em;">
               editar
            </a>
        </td>
    </tr>
    <?php endforeach; ?>
</table>

<?php require_once '../includes/footer.php'; ?>