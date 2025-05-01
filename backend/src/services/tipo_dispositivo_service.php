<?php

require_once __DIR__ . '/../models/dispositivo_model.php';

class TipoDispositivoException extends Exception {}

function service_eliminar_tipo_dispositivo($id) {

    if(model_dispositivo_existe_en_tipo_dispositivo($id)) {
        throw new TipoDispositivoException("El tipo de dispositivo tiene uno o más dispositivos asociados");
    }

    return model_eliminar_tipo_dispositivo($id);
    
}

function service_listar_tipo_dispositivo($page, $limit) {

    $page = max(1, (int)$page);
    $limit = max(1, min(100, (int)$limit));
    $offset = ($page - 1) * $limit;

    $resultados = model_listar_tipo_dispositivo($limit, $offset);

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
