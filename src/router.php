<?php

function handleRequest($data, $queryParams, $method) {

    $accion = $data['accion'] ?? $queryParams['accion'] ;
    $entidad = $data['entidad'] ?? $queryParams['entidad'] ;

    if (!$accion || !$entidad) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos: accion o entidad']);
        return;
    }

    // Determinar el nombre del handler para simular un controlador
    $handler = "{$accion}_{$entidad}";

    // Verificar si existe la funcion y llamarla
    if (function_exists($handler)) {
        call_user_func($handler, $data);
    } else {
        http_response_code(404);
        echo json_encode(['error' => "No se encuentra el handler '$handler'"]);
    }
}