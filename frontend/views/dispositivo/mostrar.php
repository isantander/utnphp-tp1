<?php

/// Esto debe estar afuera de la vista
function getApiData($endpoint) { 
    // tengo que crear un endpoint que liste todo, para cargar en las listas desplegables
    $json = @file_get_contents("http://localhost:8000/api/index.php?accion=listarTodo&entidad=$endpoint");
    return $json ? json_decode($json, true) : [];
}

function getDispositivo($id) {
    $json = @file_get_contents("http://localhost:8000/api/index.php?accion=obtener&entidad=dispositivo&id=$id");
    return $json ? json_decode($json, true) : [];
}



if (!$id) die("Falta el parámetro ID");


$dispositivo = getDispositivo($id)['data'] ?? null;

if (!$dispositivo) die("Dispositivo no encontrado");

//cargar entidades referenciadas
$fabricantes = getApiData('fabricante');
$racks = getApiData('rack');
$tipoDispositivos = getApiData('tipodispositivo');

?>


    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Editar Dispositivo</h2>
        

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

            <div class="flex justify-end mt-4">
                <a href='/datacenter/listar' class='px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300'>
                        Volver
                </a>
            </div>
        
    </div>
 
</html>
