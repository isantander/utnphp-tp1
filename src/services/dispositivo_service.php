<?php

require_once __DIR__ . '/../models/dispositivo_model.php';

class DispositivoNotFoundException extends Exception {}
class RackNotFoundException extends Exception {}
class FabricanteNotFoundException extends Exception {}

function service_crear_dispositivo($id_tipo_dispositivo, $id_rack, $id_fabricante,$ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones) {

    if(!model_obtener_tipo_dispositivo($id_tipo_dispositivo)) {
        throw new DispositivoNotFoundException();
    }
    
    if(!model_obtener_rack($id_rack)) {
        throw new RackNotFoundException();
    }
    
    if(!model_obtener_fabricante($id_fabricante)) {
        throw new FabricanteNotFoundException();
    }
    
    return model_crear_dispositivo($id_tipo_dispositivo, $id_rack, $id_fabricante, $ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones);

}

function service_modificar_dispositivo($id, $id_tipo_dispositivo, $id_rack, $id_fabricante,$ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones) {

    if(!model_obtener_tipo_dispositivo($id_tipo_dispositivo)) {
        throw new DispositivoNotFoundException();
    }
    
    if(!model_obtener_rack($id_rack)) {
        throw new RackNotFoundException();
    }
    
    if(!model_obtener_fabricante($id_fabricante)) {
        throw new FabricanteNotFoundException();
    }
    
    return model_modificar_dispositivo($id, $id_tipo_dispositivo, $id_rack, $id_fabricante, $ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones);

}

function service_listar_dispositivos($page, $limit) {

    $page = max(1, (int)$page);
    $limit = max(1, min(100, (int)$limit));
    $offset = ($page - 1) * $limit;

    $resultados = model_listar_dispositivos($limit, $offset);

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
