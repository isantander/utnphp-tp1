<?php

function listar_datacenter($data) {
    // Data de ejemplo para simular la ddbb
    echo json_encode([
        ['id' => 1, 'nombre' => 'Datacenter 1'],
        ['id' => 2, 'nombre' => 'Datacenter 2'],
    ], JSON_PRETTY_PRINT);
}

function crear_datacenter($data) {

    $nombre = $data['nombre'] ?? null;
    $ubicacion = $data['ubicacion'] ?? null;
    $descripcion = $data['descripcion'] ?? null;

    if (!$nombre || !$ubicacion || !$descripcion) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
        return;
    }

    
    echo json_encode(['mensaje' => 'Datacenter creado correctamente'], JSON_PRETTY_PRINT);
}



