<?php

require_once __DIR__ . '/../models/FabricanteModel.php';

function crear_fabricante($data, $method) {
    if ($method !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Metodo no permitido']);
        return;
    }

    $descripcion = $data['descripcion'] ?? null;

    if (!$descripcion) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
        return;
    }

    $success = crearFabricante($descripcion);

    if ($success) {
        echo json_encode(['mensaje' => 'Fabricante creado correctamente'], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al insertar el fabricante']);
    }
}

function listar_fabricates() {

    $success = listarFabricantes();

    if ($success) {
        echo json_encode($success, JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener los fabricantes']);
    }
}

function obtener_fabricante($data) {

    $id = $data['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
        return;
    }
    
    $success = obtenerFabricante($id);

    if ($success) {
        echo json_encode($success, JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener el fabricante']);
    }
}


function eliminar_fabricante($data, $method) {

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

    $success = eliminarFabricante($id);

    if ($success) {
        echo json_encode(['mensaje' => 'Fabricante eliminado correctamente'], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al eliminar el fabricante']);
    }
}