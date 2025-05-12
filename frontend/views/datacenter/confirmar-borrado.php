<?php
require_once __DIR__ . '/../../resources/utils/helpers.php'; 


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    $request = deleteDatacenter(intval($_POST['id']));

    
    if(intval($request)  == 409){
        echo "<p class='text-red-500 p-4'>El Datacenter tiene uno o más racks asociados.</p>";
        echo "<a href='/datacenter/listar'" . 
                "class='px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300'>
                Volver
              </a>";
        exit;
    }else{
       header("Location: " . BASE_URL . "/datacenter/listar");
    }
    
}

if(!$id) {
    header("Location: " . BASE_URL . "/datacenter/listar");
    exit;
}


// Tendría que modificar la función que llama a la API, por ahora la reutilizo
// queda horrible
$response = fetchApiData('datacenter', 0, 0, 'obtener', $id);
//print_r($response);

// En caso de error o dato vacío
if (!$response || !isset($response['data']) || !$response['data']) {
    echo "<p class='text-red-500 p-4'>Datacenter no encontrado.</p>";
    exit;
}

$datacenter = $response['data'];


?>

<div class="bg-white p-6 rounded shadow text-center max-w-lg mx-auto mt-20">
    <h2 class="text-lg font-bold mb-4 text-gray-800">¿Estás seguro de que deseas borrar el datacenter <span class="text-red-600">"<?= htmlspecialchars($datacenter['nombre']) ?>"</span>?</h2>

    <form method="post" action="<?= BASE_URL ?>/datacenter/confirmar-borrado">
        <input type="hidden" name="id" value="<?= $datacenter['id'] ?>">
        <div class="mt-6 flex justify-center space-x-4">
            <button type="submit" name="confirmar" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Sí, borrar</button>
            <a href="<?= BASE_URL ?>/datacenter/listar" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancelar</a>
        </div>
    </form>
</div>
 
