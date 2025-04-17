<?php

require_once __DIR__ . '/../models/RackModel.php';

function crear_rack($data, $method) {
    
    if ($method !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Metodo no permitido']);
        return;
    }

    $id_datacenter = $data['id_datacenter'] ?? null;
    $numero = $data['numero'] ?? null;
    $descripcion = $data['descripcion'] ?? null;

    if (!$id_datacenter || !$numero || !$descripcion) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
        return;
    }

    $success = crearRack($id_datacenter, $numero, $descripcion);

    if ($success) {
        echo json_encode(['mensaje' => 'Rack creado correctamente'], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al insertar el rack']);
    }
}

function listar_racks() {

    $success = listarRacks();

    if ($success) {
        echo json_encode($success, JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener los racks']);
    }
}

function obtener_rack($data) {

    $id = $data['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
        return;
    }
    
    $success = obtenerRack($id);

    if ($success) {
        echo json_encode($success, JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener el rack']);
    }
}

function eliminar_rack($data, $method) {

    if ($method !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Metodo no permitido']);
        return;
    }

    $id = $data['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
        return;
    }

    $success = eliminarRack($id);

    if ($success) {
        echo json_encode(['mensaje' => 'Rack eliminado correctamente'], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al eliminar el rack']);
    }
}