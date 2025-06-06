<?php
define('BASE_URL', 'http://' . $_SERVER['HTTP_HOST']);

$request = $_SERVER['REQUEST_URI'];
$baseURL = array_filter(explode('/', $request));

$entidad = $baseURL[1] ?? 'menu';
$accion = $baseURL[2] ?? 'home';
$id = $baseURL[3] ?? null;

$acciones_permitidas = ['home','listar', 'mostrar', 'crear', 'modificar', 'eliminar','confirmar-borrado'];
$entidades_permitidas = ['menu','datacenter', 'dispositivo', 'rack', 'fabricante', 'tipodispositivo'];

if ( !in_array($accion, $acciones_permitidas) || 
     !in_array($entidad, $entidades_permitidas)) {
    
        echo '<div class="text-center py-10">
            <h2 class="text-2xl font-semibold text-gray-700">Error: 404</h2>
          </div>';
    return;

}

//armo la ruta a la vista
$vista = "views/$entidad/$accion.php";
echo $vista;


//header
require_once 'views/layouts/header.php';

// barra navegación
require_once 'views/layouts/nav-buttons.php';

// si existe carga la url solicitada, sino muestra mensaje de pagina inexistente 
if (file_exists($vista)) {
    $page = $id;
    require_once $vista;
} else {
    echo '<div class="text-center py-10">
            <h2 class="text-2xl font-semibold text-gray-700">Página no encontrada</h2>
            <p class="mt-2 text-gray-500">La página solicitada no existe</p>
          </div>';
}


// footer - no tiene nada por ahora
require_once 'views/layouts/footer.php';

