<?php
require_once 'includes/init.php';

$error = "";
$exito = "";

if (es_post()) {
    try {
        // campos vacíos
        validar_campos_vacios(['ci', 'nombres', 'apellidos', 'email', 'contra']);
        
        $ci = trim($_POST['ci']);
        $nombres = trim($_POST['nombres']);
        $apellidos = trim($_POST['apellidos']);
        $email = trim($_POST['email']);
        $contra = $_POST['contra'];

        validar_ci($ci);
        validar_formato_email($email);

        if (isset($_SESSION['usuarios'][$ci])) {
            throw new Exception("Ya hay un usuario registrado con esa CI.");
        }

        // se guarda la pesudotable si todo bien
        $_SESSION['usuarios'][$ci] = [
            'ci' => $ci,
            'nombres' => $nombres,
            'apellidos' => $apellidos,
            'email' => $email,
            'contra' => $contra,
            'rol' => 'cliente',
            'estado' => 'activo'
        ];

        // Redirección limpia
        header("Location: login.php");
        exit;

    } catch (Exception $e) {
        // catch de errores 
        $error = $e->getMessage();
    }
}

require_once 'includes/header.php';
?>

<h2>registro de usuario</h2>

<?php if (!empty($error)): ?>
    <p class="error"><?php echo $error; ?></p>
<?php endif; ?>

<form method="POST">
    <input type="number" name="ci" placeholder="CI" value="<?php echo isset($_POST['ci']) ? htmlspecialchars($_POST['ci']) : ''; ?>"><br><br>
    <input type="text" name="nombres" placeholder="Nombre" value="<?php echo isset($_POST['nombres']) ? htmlspecialchars($_POST['nombres']) : ''; ?>"><br><br>
    <input type="text" name="apellidos" placeholder="Apellidos" value="<?php echo isset($_POST['apellidos']) ? htmlspecialchars($_POST['apellidos']) : ''; ?>"><br><br>
    <input type="email" name="email" placeholder="Email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>"><br><br>
    <input type="password" name="contra" placeholder="Contraseña"><br><br>
    <button type="submit">Registrarme</button>
</form>

<?php require_once 'includes/footer.php'; ?>