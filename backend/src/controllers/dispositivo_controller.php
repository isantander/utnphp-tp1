<?php

require_once __DIR__ . '/../models/dispositivo_model.php';
require_once __DIR__ . '/../services/dispositivo_service.php';

function controller_crear_dispositivo($data, $method) {

    if ($method !== 'POST') {
        json_response(null,405);
        return;
    }

    $id_tipo_dispositivo = $data['id_tipo_dispositivo'] ?? null;
    $id_rack = $data['id_rack'] ?? null;
    $id_fabricante = $data['id_fabricante'] ?? null;
    $ubicacion_rack = $data['ubicacion_rack'] ?? null;
    $modelo = $data['modelo'] ?? null;
    $nro_serie = $data['nro_serie'] ?? null;
    $nombre = $data['nombre'] ?? null;
    $estado = $data['estado'] ?? null;
    $observaciones = $data['observaciones'] ?? null;

    if (!$id_tipo_dispositivo || !$id_rack || !$id_fabricante || !$ubicacion_rack || !$modelo || !$nro_serie || !$nombre || !$estado || !$observaciones) {
        json_response(null,400);
        return;
    }

    try {

        $id = service_crear_dispositivo($id_tipo_dispositivo, $id_rack, $id_fabricante, $ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones);

        if ($id) {
            json_response([
                'mensaje' => 'Dispositivo creado correctamente',
                'id' => $id
            ], 201);
        } else {
            json_response(null, 409);
        }

    }
    catch (DispositivoNotFoundException $e) {
        json_response(['error' => 'Tipo de dispositivo no encontrado'],404);
    }
    catch (RackNotFoundException $e) {
        json_response(['error' => 'Rack no encontrado'],404);
    }
    catch (FabricanteNotFoundException $e) {
        json_response(['error' => 'Fabricante no encontrado'],404);
    }
    catch(Exception $e){
        json_response(null,500);
    }
   

}

function controller_modificar_dispositivo($data, $method) {

    if ($method !== 'POST') {
        json_response(null,405);
        return;
    }

    $id = $data['id'] ?? null;
    $id_tipo_dispositivo = $data['id_tipo_dispositivo'] ?? null;
    $id_rack = $data['id_rack'] ?? null;
    $id_fabricante = $data['id_fabricante'] ?? null;
    $ubicacion_rack = $data['ubicacion_rack'] ?? null;
    $modelo = $data['modelo'] ?? null;
    $nro_serie = $data['nro_serie'] ?? null;
    $nombre = $data['nombre'] ?? null;
    $estado = $data['estado'] ?? null;
    $observaciones = $data['observaciones'] ?? null;

    if (!$id || !$id_tipo_dispositivo || !$id_rack || !$id_fabricante || !$ubicacion_rack || !$modelo || !$nro_serie || !$nombre || !$estado || !$observaciones) {
        json_response(null,400);
        return;
    }

    try {

        $resultado = service_modificar_dispositivo($id, $id_tipo_dispositivo, $id_rack, $id_fabricante, $ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones);

        if ($resultado === true) {
            json_response([
                'mensaje' => 'Dispositivo modificado correctamente'
            ], 200);
        } elseif ($resultado === false) {
            json_response(null, 500);
        } else {
            json_response(['error' => 'Dispositivo no encontrado o no se pudo modificar'],404);
        }

    }
    catch (DispositivoNotFoundException $e) {
        json_response(['error' => 'Tipo dispositivo no encontrado'],404);
    }
    catch (RackNotFoundException $e) {
        json_response(['error' => 'Rack no encontrado'],404);
    }
    catch (FabricanteNotFoundException $e) {
        json_response(['error' => 'Fabricante no encontrado'],404);
    }
    catch(Exception $e){
        json_response(null,500);
    }

}


function controller_eliminar_dispositivo($data, $method) {

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

        $resultado = model_eliminar_dispositivo($id);

        if ($resultado) {
            json_response([
                'mensaje' => 'Dispositivo borrado correctamente'
            ], 200);
        } else {
            json_response(null, 500);
        }

    }
    catch (DispositivoNotFoundException $e) {
        json_response(['error' => 'Dispositivo no encontrado'],404);
    }
    catch(Exception $e){
        json_response(null,500);
    }
}

function controller_listar_dispositivo($data, $method) {


    $page = $data['page'] ?? 1;
    $limit = $data['limit'] ?? 10;

    $respuesta = service_listar_dispositivos($page, $limit);

    if ($respuesta === false) {
        json_response(null, 500);
    } else {
        json_response($respuesta, 200);
    }

}
