<?php

require_once __DIR__ . '/../services/rack_service.php';

function controller_crear_rack($data, $method) {
    
    if ($method !== 'POST') {
        json_response(null, 405);
        return;
    }

    $id_datacenter = $data['id_datacenter'] ?? null;
    $numero = $data['numero'] ?? null;
    $descripcion = $data['descripcion'] ?? null;
    
    
    if (!$id_datacenter || !$numero || !$descripcion) {
        json_response(null, 400);
        return;
    }

    try{
        $id = service_crear_rack($id_datacenter, $numero, $descripcion);
        
        if ($id) {
            json_response([
                'mensaje' => 'Rack creado correctamente',
                'id' => $id
            ], 201);
        } else {
            json_response(null, 409);
        }

    }
    catch (DataCenterNotFoundException $e) {
       json_response(['error' => 'Datacenter no encontrado'], 404); 
    }
    catch (Exception $e) {
        json_response(null, 500);
    }

}

function controller_modificar_rack($data, $method) {

    if ($method !== 'POST') {
        json_response(null, 405);
        return;
    }

    $id = $data['id'] ?? null;
    $id_datacenter = $data['id_datacenter'] ?? null;
    $numero = $data['numero'] ?? null;
    $descripcion = $data['descripcion'] ?? null;

    if (!$id || !$id_datacenter || !$numero || !$descripcion) {
        json_response(null, 400);
        return;
    }

    try{
        
        $resultado = service_modificar_rack($id,$id_datacenter, $numero, $descripcion);
        
        if ($resultado === true) {
            json_response(['mensaje' => 'Rack modificado correctamente']);
        } elseif ($resultado === false) {
            json_response(null, 500);
        } else {
            json_response(['error' => 'Rack no encontrado o no se pudo modificar'],404);
        }

    }
    catch (DataCenterNotFoundException $e) {
       json_response(['error' => 'Datacenter no encontrado'], 404);
    }
}

/* function controller_listar_rack() {

    $success = model_listar_racks();

    if ($success) {
        json_response(['data' => $success],200);
    } else {
        json_response(null,404);
    }
} */


function controller_listar_rack($data, $method) {

    $page = $data['page'] ?? 1;
    $limit = $data['limit'] ?? 10;

    $respuesta = service_listar_rack($page, $limit);

    if ($respuesta === false) {
        json_response(null, 500);
    } else {
        json_response($respuesta, 200);
    }
    
}

function controller_listarTodo_rack($data, $method) {

    $respuesta = model_listarTodo_rack();

    if ($respuesta === false) {
        json_response(null, 500);
    } else {
        json_response($respuesta, 200);
    }
    
}

function controller_obtener_rack($data, $method) {

    if ($method !== 'POST') {
        json_response(null, 405);
        return;
    }

    $id = $data['id'] ?? null;

    if (!$id) {
        json_response(null,400);
        return;
    }
    
    $success = model_obtener_rack($id);

    if ($success === false) {
        json_response(null, 500);
        return;
    }

    if ($success === null) {
        json_response(null,404);
        return;
    }

    json_response(['data' => $success],200);
}


function controller_eliminar_rack($data, $method) {

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

        $respuesta = service_eliminar_rack($id);

        if ($respuesta === 0) {
            json_response(null,404);
            return;
        }elseif ($respuesta === true) {
            json_response(['mensaje' => 'Rack borrado correctamente'],200);
        }else{
            json_response(null,500);
        }

    }
    catch (RackAsociadoException $e) {
        json_response(['error' => $e->getMessage()], 409);
    }
    catch (Exception $e) {
        json_response(null,500);
    }
}