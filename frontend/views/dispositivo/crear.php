<?php
function getApiData($endpoint) {
    $json = @file_get_contents("http://localhost:8000/api/index.php?accion=listar&entidad=$endpoint");
    return $json ? json_decode($json, true) : [];
}

function postApiData($endpoint, $data) {
    $url = "http://localhost:8000/api/index.php?accion=crear&entidad=$endpoint";
    $opciones = [
        'http' => [
            'header'  => "Content-type: application/json\r\n",
            'method'  => 'POST',
            'content' => json_encode($data),
        ]
    ];
    $contexto  = stream_context_create($opciones);
    $resultado = @file_get_contents($url, false, $contexto);
    $httpCode = explode(' ', $http_response_header[0] ?? '')[1] ?? 0;

    if ($resultado && ($httpCode == 201 || $httpCode == 200)) {
        echo "<script>
            document.addEventListener('DOMContentLoaded', function() {
                const modal = new Modal(document.getElementById('successModal'));
                modal.show();
                setTimeout(() => window.location.href = '/dispositivo/listar', 2000);
            });
        </script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $payload = [
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

    postApiData('dispositivo', $payload);
}

$fabricantes = getApiData('fabricante');
$racks = getApiData('rack');
$tipoDispositivos = getApiData('tipodispositivo');
?>


<div class="bg-white shadow-md rounded-lg p-8 max-w-2xl w-full">
    <h2 class="text-2xl font-bold mb-6 text-center">Crear Nuevo Dispositivo</h2>
    <form method="POST" class="space-y-5">

        <div>
            <label class="block text-sm font-medium text-gray-700">Nombre</label>
            <input type="text" name="nombre" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:ring-blue-500 focus:border-blue-500" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Fabricante</label>
            <select name="id_fabricante" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Seleccione un fabricante</option>
                <?php foreach ($fabricantes['data'] as $f): ?>
                    <option value="<?= $f['id'] ?>"><?= htmlspecialchars($f['nombre']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Modelo</label>
            <input type="text" name="modelo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Número de Serie</label>
            <input type="text" name="nro_serie" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Ubicación en el Rack</label>
            <input type="text" name="ubicacion_rack" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Observaciones</label>
            <input type="text" name="observaciones" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" />
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Tipo de Dispositivo</label>
            <select name="id_tipo_dispositivo" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Seleccione un tipo</option>
                <?php foreach ($tipoDispositivos['data'] as $d): ?>
                    <option value="<?= $d['id'] ?>"><?= htmlspecialchars($d['descripcion']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Estado</label>
            <select name="estado" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Seleccione estado</option>
                <option value="1">Activo</option>
                <option value="0">Inactivo</option>
            </select>
        </div>

        <div>
            <label class="block text-sm font-medium text-gray-700">Rack</label>
            <select name="id_rack" required class="mt-1 block w-full rounded-md border-gray-300 shadow-sm">
                <option value="">Seleccione un rack</option>
                <?php foreach ($racks['data'] as $r): ?>
                    <option value="<?= $r['id'] ?>"><?= htmlspecialchars($r['descripcion']) ?></option>
                <?php endforeach; ?>
            </select>
        </div>

        <div class="text-center">
            <button type="submit" class="px-6 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition">
                Guardar
            </button>
        </div>
    </form>
</div>

<!-- Modal exito -->
<div id="successModal" tabindex="-1" class="hidden fixed top-0 left-0 right-0 z-50 flex items-center justify-center w-full p-4 overflow-x-hidden overflow-y-auto h-modal h-full">
    <div class="relative w-full max-w-md h-full">
        <div class="relative bg-white rounded-lg shadow dark:bg-gray-700">
            <div class="p-6 text-center">
                <svg class="mx-auto mb-4 text-green-500 w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                </svg>
                <h3 class="mb-5 text-lg font-normal text-gray-700 dark:text-gray-400">
                    Dispositivo creado correctamente
                </h3>
                <p class="text-sm text-gray-500">Redirigiendo...</p>
            </div>
        </div>
    </div>
</div>
