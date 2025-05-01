<?php

function handleRequest($data, $queryParams, $method) {

    $accion = $data['accion'] ?? $queryParams['accion'] ;
    $entidad = $data['entidad'] ?? $queryParams['entidad'] ;

    if (!$accion || !$entidad) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos: accion o entidad']);
        return;
    }

    // evitar ataques de ejecucion arbitraria o funciones no deseadas
    $acciones_permitidas = ['crear', 'listar', 'modificar', 'eliminar', 'obtener'];
    $entidades_permitidas = ['datacenter', 'dispositivo', 'rack', 'fabricante', 'tipodispositivo'];

    if (!in_array($accion, $acciones_permitidas) || !in_array($entidad, $entidades_permitidas)) {
        http_response_code(400);
        echo json_encode(['error' => 'Acción o entidad no permitida']);
        return;
    }

    // Determinar el nombre del handler para simular un controlador
    $handler = "controller_{$accion}_{$entidad}";

    // Verificar si existe la funcion y llamarla
    if (function_exists($handler)) {
        call_user_func($handler, $data, $method);
    } else {
        http_response_code(404);
        echo json_encode(['error' => "No se encuentra el handler '$handler'"]);
    }

}