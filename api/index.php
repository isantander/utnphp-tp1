<?php

require_once '../src/router.php';
require_once '../src/controllers/datacenter_controller.php';
require_once '../src/controllers/tipo_dispositivo_controller.php';
require_once '../src/controllers/fabricante_controller.php';
require_once '../src/controllers/rack_controller.php';
require_once '../src/controllers/dispositivo_controller.php';
require_once '../src/helpers/utils.php';


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
        json_response(['error' => 'Método no permitido'], 405);
        exit;
}

handleRequest($input, $queryParams, $_SERVER['REQUEST_METHOD']);

