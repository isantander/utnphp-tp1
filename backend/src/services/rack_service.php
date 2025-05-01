<?php

require_once __DIR__ . '/../models/rack_model.php';
require_once __DIR__ . '/../models/datacenter_model.php';
require_once __DIR__ . '/../models/dispositivo_model.php';


class DataCenterNotFoundException extends Exception {};

function service_crear_rack($id_datacenter, $numero, $descripcion){

    if(!model_obtener_datacenter($id_datacenter)){
        throw new DataCenterNotFoundException("El datacenter no existe");
    }

    return model_crear_rack($id_datacenter, $numero, $descripcion);
    
}

function service_modificar_rack($id,$id_datacenter, $numero, $descripcion) {

    if(!model_obtener_datacenter($id_datacenter)){
        throw new DataCenterNotFoundException("El datacenter no existe");
    }

    return model_modificar_rack($id,$id_datacenter, $numero, $descripcion);
}

function service_eliminar_rack($id) {

    if (model_dispositivo_existe_en_rack($id)) {
        throw new RackAsociadoException("El rack tiene uno o más dispositivos asociados");
    }

    return model_eliminar_rack($id);

}

function service_listar_rack($page, $limit) {
    
    $page = max(1, (int)$page);
    $limit = max(1, min(100, (int)$limit));
    $offset = ($page - 1) * $limit;

    $resultados = model_listar_rack($limit, $offset);

    if ($resultados === false) {
        return false;
    }

    $totalPages = (int)ceil($resultados['total'] / $limit);

    return [
        'data' => $resultados['data'],
        'total' => $resultados['total'],
        'page' => $page,
        'limit' => $limit,
        'pages' => $totalPages
    ];
}
