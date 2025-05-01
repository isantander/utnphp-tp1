<?php

require_once __DIR__ . '/../models/rack_model.php';
require_once __DIR__ . '/../models/datacenter_model.php';

class RackAsociadoException extends Exception {}

function service_eliminar_datacenter($id){

    if(model_rack_en_datacenter_existe($id)){
        throw new RackAsociadoException("El datacenter tiene uno o más racks asociados");
    }

    return model_eliminar_datacenter($id);
    
}

function service_listar_datacenter($page, $limit) {

    $page = max(1, (int)$page);
    $limit = max(1, min(100, (int)$limit));
    $offset = ($page - 1) * $limit;

    $resultados = model_listar_datacenter($limit, $offset);

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

