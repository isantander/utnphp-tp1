<?php

require_once __DIR__ . '/../models/fabricante_model.php';

function controller_crear_fabricante($data, $method) {
    if ($method !== 'POST') {
        json_response(null, 405);
        return;
    }

    $nombre = $data['nombre'] ?? null;

    if (!$nombre) {
        json_response(null,400);
        return;
    }


    $id = model_crear_fabricante($nombre);

    if ($id) {
        json_response(
            [
                'mensaje' => 'Fabricante creado correctamente',
                'id' => $id
            ],201);
    } else {
        json_response(null,500);
    }

}

function controller_modificar_fabricante($data, $method) {
    if ($method !== 'POST') {
        json_response(null, 405);
        return;
    }

    $id = $data['id'] ?? null;
    $nombre = $data['nombre'] ?? null;

    if (!$id || !$nombre) {
        json_response(null,400);
        return;
    }

    $resultado = model_modificar_fabricante($id,$nombre);

    if ($resultado === true) {
        json_response(['mensaje' => 'Fabricante modificado correctamente']);

    } elseif ($resultado === false) {
        json_response(null,500);

    } else {
        json_response(['error' => 'Fabricante no encontrado o no se pudo modificar'],404);
    }


}

function controller_listar_fabricante() {

    $success = model_listar_fabricantes();

    if ($success) {
        json_response(['data' => $success],200);
    } else {
        json_response(null,404);
    }
}

function controller_obtener_fabricante($data) {

    $id = $data['id'] ?? null;

    if (!$id) {
        json_response(null,400);
        return;
    }
    
    $success = model_obtener_fabricante($id);

    if ($success) {
        json_response(['data' => $success],200);
    } else {
        json_response(null,404);
    }
}


// 
/* function controller_eliminar_fabricante($data, $method) {

    if ($method !== 'POST') {
        json_response(null,405);
        return;
    }

    $id = $data['id'] ?? null;

    if (!$id) {
        json_response(null,400);
        return;
    }

    $success = model_eliminar_fabricante($id);

    if ($success) {
        echo json_encode(['mensaje' => 'Fabricante eliminado correctamente'], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al eliminar el fabricante']);
    }
} */