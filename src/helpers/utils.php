<?php
function json_response($data = null, int $status = 200) {

    $mensajes = [
        200 => ['mensaje' => 'Operación realizada correctamente'],
        201 => ['mensaje' => 'Recurso creado correctamente'],
        204 => [''], // Prueba porque 204 no tiene que tener body
        400 => ['error' => 'Faltan parámetros requeridos'],
        401 => ['error' => 'No autorizado'],
        403 => ['error' => 'Prohibido'],
        404 => ['error' => 'Recurso no encontrado'],
        405 => ['error' => 'Método no permitido'],
        500 => ['error' => 'Error interno del servidor'],
    ];

    if ($data === null && isset($mensajes[$status])) {
        $data = $mensajes[$status];
    }

    http_response_code($status);
    header('Content-Type: application/json');

    // Evitar cuerpo en 204
    if ($status === 204) {
        return;
    }

    echo json_encode($data, JSON_PRETTY_PRINT);
}

