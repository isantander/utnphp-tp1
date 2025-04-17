<?php

require_once __DIR__ . '/../models/TipoDispositivoModel.php';

function crear_tipodispositivo($data, $method) {

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

    $success = crearTipoDispositivo($descripcion);

    if ($success) {
        echo json_encode(['mensaje' => 'Tipo de dispositivo creado correctamente'], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al insertar el tipo de dispositivo']);
    }
}

function listar_tipodispositivos() {

    $success = listarTipoDispositivos();

    if ($success) {
        echo json_encode($success, JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener los tipos de dispositivos']);
    }
}

function obtener_tipodispositivo($data) {

    $id = $data['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
        return;
    }

    $success = obtenerTipoDispositivo($id);

    if ($success) {
        echo json_encode($success, JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener el tipo de dispositivo']);
    }
}

function eliminar_tipodispositivo($data, $method) {

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

    $success = eliminarTipoDispositivo($id);
    
    if ($success) {
        echo json_encode(['mensaje' => 'Tipo de dispositivo eliminado correctamente'], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al eliminar el tipo de dispositivo']);
    }
}

