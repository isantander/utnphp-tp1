<?php

function getDatacenter($id) {
    $json = @file_get_contents("http://localhost:8000/api/index.php?accion=obtener&entidad=datacenter&id=$id");
    return $json ? json_decode($json, true) : [];
}



if (!$id) die("Falta el parámetro ID");


$datancenter = getDatacenter($id)['data'] ?? null;

if (!$datancenter) die("Dispositivo no encontrado");

?>


    <div class="max-w-3xl mx-auto bg-white p-6 rounded-lg shadow-md">
        <h2 class="text-2xl font-bold mb-6">Visualizar Datacenter</h2>
        

            <div>
                <label class="block mb-1 font-medium">Nombre</label>
                
                <input type="text" name="nombre" value="<?= htmlspecialchars($datancenter['nombre']) ?>" class="w-full border rounded px-3 py-2" readonly>
            </div>

            <div>
                <label class="block mb-1 font-medium">Modelo</label>
                <input type="text" name="modelo" value="<?= htmlspecialchars($datancenter['ubicacion']) ?>" class="w-full border rounded px-3 py-2" readonly>
            </div>

            <div>
                <label class="block mb-1 font-medium">Número de serie</label>
                <input type="text" name="nro_serie" value="<?= htmlspecialchars($datancenter['descripcion']) ?>" class="w-full border rounded px-3 py-2" readonly>
            </div>

            <div class="flex justify-end mt-4">

                <a href='/datacenter/listar' class='px-4 py-2 bg-gray-200 text-gray-800 rounded hover:bg-gray-300'>
                        Volver
                </a>
            </div>
    </div>
 
</html>
