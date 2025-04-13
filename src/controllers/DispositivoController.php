<?php

function listar_dispositivo($data) {
    // Data de ejemplo para simular la ddbb
    echo json_encode([
        ['id' => 1, 'nombre' => 'Router MikroTik'],
        ['id' => 2, 'nombre' => 'Switch HP'],
    ], JSON_PRETTY_PRINT);
}

function crear_dispositivo($data) {
    // response de ejemplo para crear un dispositivo
    echo json_encode(['mensaje' => 'Dispositivo creado correctamente'], JSON_PRETTY_PRINT);
}

