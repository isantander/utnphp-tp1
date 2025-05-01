<?php
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST']);

$request = $_SERVER['REQUEST_URI'];
$baseURL = array_filter(explode('/', $request));

$entidad = $baseURL[1] ?? 'menu';
$accion = $baseURL[2] ?? 'home';
$id = $baseURL[3] ?? null;

$acciones_permitidas = ['home','listar', 'obtener', 'crear', 'modificar', 'eliminar'];
$entidades_permitidas = ['menu','datacenter', 'dispositivo', 'rack', 'fabricante', 'tipodispositivo'];

if (!in_array($accion, $acciones_permitidas) || !in_array($entidad, $entidades_permitidas)) {
    echo '<div class="text-center py-10">
            <h2 class="text-2xl font-semibold text-gray-700">Error: 404</h2>
          </div>';
    return;
}

$vista = "views/$entidad/$accion.php";

//header
require_once 'views/layouts/header.php';
// barra navegación
require_once 'views/layouts/nav-buttons.php';

// vista en caso de existir
if (file_exists($vista)) {
    $page = $id;
    require_once $vista;
} else {
    echo '<div class="text-center py-10">
            <h2 class="text-2xl font-semibold text-gray-700">Página no encontrada</h2>
            <p class="mt-2 text-gray-500">La página solicitada no existe</p>
          </div>';
}


// footer
require_once 'views/layouts/footer.php';

