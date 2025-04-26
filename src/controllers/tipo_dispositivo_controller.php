<?php

require_once __DIR__ . '/../models/tipo_dispositivo_model.php';

function controller_crear_tipodispositivo($data, $method) {

    if ($method !== 'POST') {
        json_response(null,405);
        return;
    }

    $descripcion = $data['descripcion'] ?? null;

    if (!$descripcion) {
        json_response(null,400);    
        return;
    }

    $id = model_crear_tipo_dispositivo($descripcion);

    if ($id) {
        json_response([
            'mensaje' => 'Tipo Dispositivo creado correctamente',
            'id' => $id
        ], 201);
    } else {
        json_response(null,500);
    }
}

function controller_modificar_tipodispositivo($data, $method) {

    if ($method !== 'POST') {
        json_response(null,405);
        return;
    }

    $id = $data['id'] ?? null;
    $descripcion = $data['descripcion'] ?? null;

    if (!$id || !$descripcion) {
        json_response(null,400);
        return;
    }

    $resultado = model_modificar_tipo_dispositivo($id,$descripcion);

    if ($resultado === true) {
        json_response(['mensaje' => 'Tipo Dispositivo modificado correctamente']);

    } elseif ($resultado === false) {
        json_response(null,500);

    } else {
        json_response(['error' => 'Tipo Dispositivo no encontrado o no se pudo modificar'],404);
    }

}

function model_listar_tipodispositivos() {

    $success = model_listar_tipo_dispositivos();

    if ($success) {
        json_response(['data' => $success],200);
    } else {
        json_response(null,404);
    }
}

function model_obtener_tipodispositivo($data) {

    $id = $data['id'] ?? null;

    if (!$id) {
        json_response(null,400);
        return;
    }

    $success = model_obtener_tipo_dispositivo($id);

    if ($success) {
        json_response(['data' => $success],200);
    } else {
        json_response(null,404);
    }
}


// Todos los deletes quedan para el final
/* function model_eliminar_tipodispositivo($data, $method) {

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

    $success = model_eliminar_tipo_dispositivo($id);
    
    if ($success) {
        echo json_encode(['mensaje' => 'Tipo de dispositivo eliminado correctamente'], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al eliminar el tipo de dispositivo']);
    }
} */

