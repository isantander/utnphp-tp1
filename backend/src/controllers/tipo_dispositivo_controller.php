<?php

require_once __DIR__ . '/../models/tipo_dispositivo_model.php';
require_once __DIR__ . '/../services/tipo_dispositivo_service.php';

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

/* function controller_listar_tipodispositivos() {

    $success = model_listar_tipo_dispositivos();

    if ($success) {
        json_response(['data' => $success],200);
    } else {
        json_response(null,404);
    }
} */

function controller_listar_tipodispositivo($data, $method) {


    $page = $data['page'] ?? 1;
    $limit = $data['limit'] ?? 10;

    $respuesta = service_listar_tipo_dispositivo($page, $limit);

    if ($respuesta === false) {
        json_response(null, 500);
    } else {
        json_response($respuesta, 200);
    }
}


function controller_obtener_tipodispositivo($data) {

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

function controller_eliminar_tipodispositivo($data, $method) {

    if ($method !== 'POST') {
        json_response(null,405);
        return;
    }

    $id = $data['id'] ?? null;

    if (!$id) {
        json_response(null,400);
        return;
    }

    try {

        $respuesta = service_eliminar_tipo_dispositivo($id);

        if ($respuesta === 0) {
            json_response(null,404);
            return;
        }elseif ($respuesta === true) {
            json_response(['mensaje' => 'Tipo Dispositivo borrado correctamente'],200);
        }else{
            json_response(null,500);
        }

    }
    catch(TipoDispositivoException $e) {
        json_response(['error' => $e->getMessage()], 409);
    }
    catch (Exception $e) {
        json_response(['error' => $e->getMessage()], 500);
    }
    
}

