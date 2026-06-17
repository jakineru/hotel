<?php
require_once 'includes/init.php';

requerir_login();

$error = "";

if (es_post()) {
    try {
        // validar campos vacíos
        validar_campos_vacios(['numero_hab', 'fecha_in', 'fecha_out']);

        $numero_hab = $_POST['numero_hab'];
        $fecha_in = $_POST['fecha_in'];
        $fecha_out = $_POST['fecha_out'];

        // validar que las fechas sean válidas

        if (strtotime($fecha_in) <= strtotime('today')) {
            throw new Exception("La fecha de ingreso debe ser a partir de mañana.");
        }
        
        if (strtotime($fecha_in) > strtotime($fecha_out)) {
            throw new Exception("La fecha de ingreso no puede ser posterior a la fecha de salida.");
        }

        // crear reserva
        $reserva_id = uniqid(); 
        $_SESSION['reservas'][$reserva_id] = [
            'id' => $reserva_id,
            'ci_usuario' => $_SESSION['usuario_actual']['ci'], 
            'numero_hab' => $numero_hab,
            'fecha_in' => $fecha_in,
            'fecha_out' => $fecha_out,
            'estado_pago' => 'pendiente' 
        ];

        header("Location: cliente/mis_reservas.php");
        exit;

    } catch (Exception $e) {
        $error = $e->getMessage();
        header("Location: index.php?error=" . urlencode($error));
        exit;
    }
}