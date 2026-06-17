<?php
function es_post() {
    return $_SERVER['REQUEST_METHOD'] === 'POST';
}

function requerir_login() {
    if (!isset($_SESSION['estado']) || $_SESSION['estado'] !== 'logeado') {
        header("Location: /hotel/login.php");
        exit;
    }
}

function validar_campos_vacios($campos) {
    foreach ($campos as $campo) {
        if (!isset($_POST[$campo]) || trim($_POST[$campo]) === '') {
            throw new Exception("El campo \"$campo\" es obligatorio.");
        }
    }
}

function validar_formato_email($email) {
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        throw new Exception("El formato del correo no es válido.");
    }
}

function validar_ci($ci) {
    if (!is_numeric($ci) || (int)$ci <= 0) {
        throw new Exception("La cédula tiene que ser un número válido.");
    }
}

function validar_tarjeta($tarjeta) {
    if (!is_numeric($tarjeta) || (int)$tarjeta <= 0) {
        throw new Exception("El número de tarjeta tiene que ser un número válido.");
    }
}