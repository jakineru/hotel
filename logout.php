<?php
require_once 'includes/init.php';
$_SESSION['estado'] = 'deslogeado';
$_SESSION['usuario_actual'] = null;
header("Location: index.php");
exit;
?>