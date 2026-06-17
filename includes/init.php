<?php
session_start();
require_once __DIR__ . '/funciones.php';


// si el sistema no está iniciado, lo inicia y carga el estado inicial y deja el usuario como NULL (ninguno)

if (!isset($_SESSION['sistema_iniciado'])) {
    $_SESSION['sistema_iniciado'] = true;
    $_SESSION['estado'] = 'deslogeado';
    $_SESSION['usuario_actual'] = null;
    
    // definir el usuario de administrador y uno de demo

    $_SESSION['usuarios'] = [
        'admin' => [
            'ci' => 'admin', 
            'nombres' => 'admin', 
            'apellidos' => 'admin',
            'email' => 'admin@hotelrepiola.com.uy', 
            'contra' => 'admin',
            'rol' => 'admin', 
            'estado' => 'activo'
        ],
        'demo' => [
            'ci' => 'demo', 
            'nombres' => 'Juan', 
            'apellidos' => 'Pérez',
            'email' => 'demo@hotelrepiola.com.uy', 
            'contra' => 'demo',
            'rol' => 'cliente', 
            'estado' => 'activo'
        ]
    ];

    // pseudotabla de habitaciones con "key" siendo número

    $_SESSION['habitaciones'] = [
        101 => ['numero' => 101, 
                'tipo' => 'simple', 
                'precio' => 1350, 
                'capacidad' => 1, 
                'descripcion' => 'Habitación básica para una persona.', 
                'estado' => 'disponible', 
                'imagen' => '/hotel/img/simple.jpg'
                ],
        102 => ['numero' => 102, 
                'tipo' => 'doble', 
                'precio' => 2140, 
                'capacidad' => 2, 
                'descripcion' => 'Opción para parejas.', 
                'estado' => 'disponible', 
                'imagen' => '/hotel/img/doble.webp'
                ],
        201 => ['numero' => 201, 
                'tipo' => 'suite', 
                'precio' => 5600, 
                'capacidad' => 4, 
                'descripcion' => 'Suite premium con vista al mar.', 
                'estado' => 'disponible', 
                'imagen' => '/hotel/img/suite.jpg'
                ],
        202 => ['numero' => 202, 
                'tipo' => 'doble', 
                'precio' => 2100, 
                'capacidad' => 2, 
                'descripcion' => 'Habitación en mantenimiento.', 
                'estado' => 'mantenimiento', 
                'imagen' => '/hotel/img/mantenimiento.webp'
                ]
    ];

    // definir la pseudotabla de reservas, inicialmente vacía
    $_SESSION['reservas'] = [];
}

$base_url = '/hotel/'; 
?>

<link rel="icon" href="img/icono.webp" type="image/webp">