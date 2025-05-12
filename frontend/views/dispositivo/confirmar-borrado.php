<?php
require_once __DIR__ . '/../../resources/utils/helpers.php'; 

echo ">>>>" . $id;

if (!$id) {
    header("Location: " . BASE_URL . "/dispositivo/listar");
    exit;
}

// Tendría que modificar la función que llama a la API, por ahora la reutilizo
// queda horrible
$response = fetchApiData('dispositivo', 0, 0, 'obtener', $id);
print_r($response);

// En caso de error o dato vacío
if (!$response || !isset($response['data']) || !$response['data']) {
    echo "<p class='text-red-500 p-4'>Dispositivo no encontrado.</p>";
    exit;
}

$dispositivo = $response['data'];
//print_r($dispositivo);
?>

<div class="bg-white p-6 rounded shadow text-center max-w-lg mx-auto mt-20">
    <h2 class="text-lg font-bold mb-4 text-gray-800">¿Estás seguro de que deseas borrar el dispositivo <span class="text-red-600">"<?= htmlspecialchars($dispositivo['nombre']) ?>"</span>?</h2>

    <form method="post" action="<?= BASE_URL ?>/dispositivo/eliminar">
        <input type="hidden" name="id" value="<?= $dispositivo['id'] ?>">
        <div class="mt-6 flex justify-center space-x-4">
            <button type="submit" name="confirmar" class="px-4 py-2 bg-red-600 text-white rounded hover:bg-red-700">Sí, borrar</button>
            <a href="<?= BASE_URL ?>/dispositivo/listar" class="px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300">Cancelar</a>
        </div>
    </form>
</div>
 
