<?php
session_start();
session_destroy(); // borrar
header("Location: index.php", true, 301 );
?>