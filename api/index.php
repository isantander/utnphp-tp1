<?php

require_once '../src/router.php';
require_once '../src/controllers/DataCenterController.php';
require_once '../src/controllers/TipoDispositivo.php';



$input = [];
$queryParams = [];

switch ($_SERVER['REQUEST_METHOD']) {
    case 'GET':
        $input = $_GET;
        break;
    case 'POST':
        $queryParams = $_GET;
        if (strpos($_SERVER['CONTENT_TYPE'] ?? '', 'application/json') !== false) {
            $input = json_decode(file_get_contents('php://input'), true) ?? [];
        } else {
            $input = $_POST;
        }
        break;
    default:
        http_response_code(405);
        echo json_encode(['error' => 'Método no permitido']);
        exit;
}

handleRequest($input, $queryParams, $_SERVER['REQUEST_METHOD']);

