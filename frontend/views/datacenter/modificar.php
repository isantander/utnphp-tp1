<?php

function getDatacenter($id) {
    $json = @file_get_contents("http://localhost:8000/api/index.php?accion=obtener&entidad=datacenter&id=$id");
    return $json ? json_decode($json, true) : [];
}

function updateDatacenter($id, $data) {
    $url = "http://localhost:8000/api/index.php?accion=modificar&entidad=datacenter";

    $opciones = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ]
    ];

    $contexto = stream_context_create($opciones);
    $resultado = @file_get_contents($url, false, $contexto);
    print_r($resultado);

    if ($resultado === FALSE) {
        return ['success' => false, 'message' => 'Error al conectar con la API.'];
    }

    $httpCode = explode(' ', $http_response_header[0])[1] ?? 0;
    if ($httpCode == 200) {
        return ['success' => true, 'message' => 'Datacenter actualizado correctamente.'];
    }

    return ['success' => false, 'message' => 'Error al actualizar el Datacenter. Código: ' . $httpCode];
}

$feedback = null;

if (!$id) die("Falta el parámetro ID.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payload = [
        'id' => $id,
        'nombre' => $_POST['nombre'] ?? '',
        'ubicacion' => $_POST['ubicacion'] ?? 0,
        'descripcion' => $_POST['descripcion'] ?? '',
    ];

    $feedback = updateDatacenter($id, $payload);

    if ($feedback['success']) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
            const modal = new Modal(document.getElementById('successModal'));
            modal.show();
            setTimeout(() => window.location.href = '/datacenter/listar', 2000);
            });
        </script>";
    }
}


$datacenter = getDatacenter($id)['data'] ?? null;

if (!$datacenter) die("Datacenter no encontrado.");

?>


<div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
    <h2 class="text-2xl font-bold mb-6">Editar Datacenter</h2>
    <form method="POST" class="grid grid-cols-1 gap-6">

        <div>
            <label class="block mb-1 font-medium">Nombre</label>
            <input type="text" name="nombre" value="<?= htmlspecialchars($datacenter['nombre']) ?>" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Modelo</label>
            <input type="text" name="ubicacion" value="<?= htmlspecialchars($datacenter['ubicacion']) ?>" class="w-full border rounded px-3 py-2" required>
        </div>

        <div>
            <label class="block mb-1 font-medium">Número de serie</label>
            <input type="text" name="descripcion" value="<?= htmlspecialchars($datacenter['descripcion']) ?>" class="w-full border rounded px-3 py-2" required>
        </div>

        <div class="flex justify-end">
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-semibold px-6 py-2 rounded">
                Guardar Cambios
            </button>
        </div>
    </form>
</div>

<!-- modal flowbyte  -->
<div id="successModal" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto h-modal h-full">
<div class="relative w-full max-w-md h-full">
    <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
        <div class="p-6 text-center">
            <svg class="mx-auto mb-4 text-green-500 w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
            </svg>
            <h3 class="mb-5 text-lg font-normal text-gray-700 dark:text-gray-400">
                Datacenter modificado correctamente
            </h3>
            <p class="text-sm text-gray-500">Redirigiendo...</p>
        </div>
    </div>
</div>



</body>
</html>
