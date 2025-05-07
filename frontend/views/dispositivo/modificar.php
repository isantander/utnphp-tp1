<?php
function getApiData($endpoint) { 
    $json = @file_get_contents("http://localhost:8000/api/index.php?accion=listar&entidad=$endpoint");
    return $json ? json_decode($json, true) : [];
}

function getDispositivo($id) {
    $json = @file_get_contents("http://localhost:8000/api/index.php?accion=obtener&entidad=dispositivo&id=$id");
    return $json ? json_decode($json, true) : [];
}

function updateDispositivo($id, $data) {
    $url = "http://localhost:8000/api/index.php?accion=modificar&entidad=dispositivo";

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
        return ['success' => true, 'message' => 'Dispositivo actualizado correctamente.'];
    }

    return ['success' => false, 'message' => 'Error al actualizar el dispositivo. Código: ' . $httpCode];
}

$feedback = null;

if (!$id) die("Falta el parámetro ID.");

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payload = [
        'id' => $id,
        'nombre' => $_POST['nombre'] ?? '',
        'id_fabricante' => (int) ($_POST['id_fabricante'] ?? 0),
        'modelo' => $_POST['modelo'] ?? '',
        'nro_serie' => $_POST['nro_serie'] ?? '',
        'id_tipo_dispositivo' => (int) ($_POST['id_tipo_dispositivo'] ?? 0),
        'estado' => (int) ($_POST['estado'] ?? 0),
        'id_rack' => (int) ($_POST['id_rack'] ?? 0),
        'ubicacion_rack' => $_POST['ubicacion_rack'] ?? '',
        'observaciones' => $_POST['observaciones'] ?? '',
    ];

    $feedback = updateDispositivo($id, $payload);

    if ($feedback['success']) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
            const modal = new Modal(document.getElementById('successModal'));
            modal.show();
            setTimeout(() => window.location.href = '/dispositivo/listar', 2000);
            });
        </script>";
    }
}


$dispositivo = getDispositivo($id)['data'] ?? null;
print_r($dispositivo);

if (!$dispositivo) die("Dispositivo no encontrado.");

$fabricantes = getApiData('fabricante');
$racks = getApiData('rack');
$tipoDispositivos = getApiData('tipodispositivo');
?>


    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Editar Dispositivo</h2>
        <form method="POST" class="grid grid-cols-1 gap-6">

            <div>
                <label class="block mb-1 font-medium">Nombre</label>
                <input type="text" name="nombre" value="<?= htmlspecialchars($dispositivo['nombre']) ?>" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Fabricante</label>
                <select name="id_fabricante" class="w-full border rounded px-3 py-2" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($fabricantes['data'] as $f): ?>
                        <option value="<?= $f['id'] ?>" <?= $f['id'] == $dispositivo['id_fabricante'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($f['nombre']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Modelo</label>
                <input type="text" name="modelo" value="<?= htmlspecialchars($dispositivo['modelo']) ?>" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Número de serie</label>
                <input type="text" name="nro_serie" value="<?= htmlspecialchars($dispositivo['nro_serie']) ?>" class="w-full border rounded px-3 py-2" required>
            </div>

            <div>
                <label class="block mb-1 font-medium">Ubicación Rack</label>
                <input type="text" name="ubicacion_rack" value="<?= htmlspecialchars($dispositivo['ubicacion_rack']) ?>" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium">Observaciones</label>
                <input type="text" name="observaciones" value="<?= htmlspecialchars($dispositivo['observaciones']) ?>" class="w-full border rounded px-3 py-2">
            </div>

            <div>
                <label class="block mb-1 font-medium">Tipo de dispositivo</label>
                <select name="id_tipo_dispositivo" class="w-full border rounded px-3 py-2" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($tipoDispositivos['data'] as $td): ?>
                        <option value="<?= $td['id'] ?>" <?= $td['id'] == $dispositivo['id_tipo_dispositivo'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($td['descripcion']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Estado</label>
                <select name="estado" class="w-full border rounded px-3 py-2" required>
                    <option value="">Seleccione</option>
                    <option value="1" <?= $dispositivo['estado'] == 1 ? 'selected' : '' ?>>Activo</option>
                    <option value="0" <?= $dispositivo['estado'] == 0 ? 'selected' : '' ?>>Inactivo</option>
                </select>
            </div>

            <div>
                <label class="block mb-1 font-medium">Rack</label>
                <select name="id_rack" class="w-full border rounded px-3 py-2" required>
                    <option value="">Seleccione</option>
                    <?php foreach ($racks['data'] as $r): ?>
                        <option value="<?= $r['id'] ?>" <?= $r['id'] == $dispositivo['id_rack'] ? 'selected' : '' ?>>
                            <?= htmlspecialchars($r['descripcion']) ?>
                        </option>
                    <?php endforeach; ?>
                </select>
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
                    Dispositivo modificado correctamente
                </h3>
                <p class="text-sm text-gray-500">Redirigiendo...</p>
            </div>
        </div>
    </div>
</div>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>
</html>
