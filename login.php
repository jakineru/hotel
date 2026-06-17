<?php
require_once 'includes/init.php';

$error = "";

if (es_post()) {
    try {
        validar_campos_vacios(['ci', 'contra']);

        $ci = trim($_POST['ci']);
        $pass = $_POST['contra'];

        // validar usuario:contraseña
        if (!isset($_SESSION['usuarios'][$ci]) || $_SESSION['usuarios'][$ci]['contra'] !== $pass) {
            throw new Exception("Los datos ingresados son incorrectos.");
        }

        if ($_SESSION['usuarios'][$ci]['estado'] !== 'activo') {
            throw new Exception("Usuario inactivo.");
        }

        // ponemos el estado como logeado y guardamos el usuario actual en la sesión
        $_SESSION['estado'] = 'logeado';
        $_SESSION['usuario_actual'] = $_SESSION['usuarios'][$ci];
        
        header("Location: index.php");
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
    }
}

require_once 'includes/header.php';
?>

<h2>ingreso de usuarios</h2>

<?php if (!empty($error)): ?>
    <div class="error">
        <?php echo $error; ?>
    </div>
<?php endif; ?>

<form method="POST">
    <input type="text" name="ci" placeholder="usuario (ci o admin)" value="<?php echo isset($_POST['ci']) ? htmlspecialchars($_POST['ci']) : ''; ?>"><br><br>
    <input type="password" name="contra" placeholder="contraseña"><br><br>
    <button type="submit">ingresar</button>
</form>

<?php require_once 'includes/footer.php'; ?>