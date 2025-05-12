<?php

require_once __DIR__ . '/../services/datacenter_service.php';

function controller_crear_datacenter($data, $method) {

    if ($method !== 'POST') {
        json_response(null, 405);
        return;
    }

    $nombre = $data['nombre'] ?? null;
    $ubicacion = $data['ubicacion'] ?? null;
    $descripcion = $data['descripcion'] ?? null;

    if (!$nombre || !$ubicacion || !$descripcion) {
        json_response(null,400);
        return;
    }
   

    $id = model_crear_datacenter($nombre, $ubicacion, $descripcion);

    if ($id) {
        json_response([
            'mensaje' => 'Datacenter creado correctamente',
            'id' => $id
        ], 201);
    } else {
        json_response(['error' => 'Error al insertar el datacenter'],500);
    }

}

function controller_modificar_datacenter($data, $method) {

    if ($method !== 'POST') {
        json_response(null,405);
        return;
    }

    $id = $data['id'] ?? null;
    $nombre = $data['nombre'] ?? null;
    $ubicacion = $data['ubicacion'] ?? null;
    $descripcion = $data['descripcion'] ?? null;

    if (!$id || !$nombre || !$ubicacion || !$descripcion) {
        json_response(null,400);
        return;
    }
   
    $resultado = model_modificar_datacenter($id,$nombre, $ubicacion, $descripcion);

    if ($resultado === true) {
        json_response(['mensaje' => 'Datacenter modificado correctamente']);
    } elseif ($resultado === false) {
        json_response(null,500);
    } else {
        json_response(['error' => 'Datacenter no encontrado o no se pudo modificar'],404);
    }

}

function controller_listar_datacenter($data, $method) {

    $page = $data['page'] ?? 1;
    $limit = $data['limit'] ?? 10;

    $respuesta = service_listar_datacenter($page, $limit);

    if ($respuesta === false) {
        json_response(null, 500);
    } else {
        json_response($respuesta, 200);
    }
}

function controller_listarTodo_datacenter($data, $method) {

    $respuesta = model_listarTodo_datacenter();

    if ($respuesta === false) {
        json_response(null, 500);
    } else {
        json_response($respuesta, 200);
    }
}

function controller_obtener_datacenter($data, $method) {

    $id = $data['id'] ?? null;

    if (!$id) {
        json_response(null,400);
        return;
    }

    $success = model_obtener_datacenter($id);

    if ($success) {
        json_response(['data' => $success],200);
    } else {
        json_response(null,404);
    }
}


function controller_eliminar_datacenter($data, $method) {

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

        $success = service_eliminar_datacenter($id) ;

        if ($success) {
            json_response(null, 200);
        } elseif($success === 0 ){ 
            json_response(null,404);
        }else{
            json_response(null,500);
        }

    }
    catch (RackAsociadoException $e) {
        json_response(null,409);
    }
    catch (Exception $e) {
        json_response(null,500);
    }

}

