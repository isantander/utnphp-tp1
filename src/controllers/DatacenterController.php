<?php
require_once __DIR__ . '/../models/DatacenterModel.php';


function listar_datacenter() {

    $success = listarDatacenter();
 
    if ($success) {
        echo json_encode($success, JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener los datacenter']);
    }

}
                              
function obtener_datacenter($data) {

    $id = $data['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
        return;
    }   

    $success = obtenerDatacenter($id);   

    if ($success) {
        echo json_encode($success, JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al obtener el datacenter']);
    }
}

function crear_datacenter($data, $method) {

    if ($method !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Metodo no permitido']);
        return;
    }

    $nombre = $data['nombre'] ?? null;
    $ubicacion = $data['ubicacion'] ?? null;
    $descripcion = $data['descripcion'] ?? null;

    if (!$nombre || !$ubicacion || !$descripcion) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
        return;
    }
   
    $success = crearDatacenter($nombre, $ubicacion, $descripcion);

    if ($success) {
        echo json_encode(['mensaje' => 'Datacenter creado correctamente'], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al insertar el datacenter']);
    }

}

function eliminar_datacenter($data, $method) {

    if ($method !== 'POST') {
        http_response_code(405);
        echo json_encode(['error' => 'Metodo no permitido']);
        return;
    }

    $id = $data['id'] ?? null;

    if (!$id) {
        http_response_code(400);
        echo json_encode(['error' => 'Faltan parámetros requeridos']);
        return;
    }

    $success = eliminarDatacenter($id);

    if ($success) {
        echo json_encode(['mensaje' => 'Datacenter eliminado correctamente'], JSON_PRETTY_PRINT);
    } else {
        http_response_code(500);
        echo json_encode(['error' => 'Error al eliminar el datacenter']);
    }
}

