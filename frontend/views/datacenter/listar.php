<?php

require_once __DIR__ . '/../../resources/utils/helpers.php'; 

$limit = 5;

// Obtener datos de la API
$data = fetchApiData('datacenter', $page, $limit);

if (!$data || isset($data['error'])) {
    echo '<div class="bg-red-50 border-l-4 border-red-500 p-4">
            <div class="flex">
                <div class="flex-shrink-0">
                    <svg class="h-5 w-5 text-red-500" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z" clip-rule="evenodd" />
                    </svg>
                </div>
                <div class="ml-3">
                    <p class="text-sm text-red-700">Error al cargar los datos: ' . ($data['error'] ?? 'Error desconocido') . '</p>
                </div>
            </div>
          </div>';
    return;
}

// Configurar columnas
$columns = [
    ['title' => 'ID', 'field' => 'id', 'type' => 'number'],
    ['title' => 'Nombre', 'field' => 'nombre', 'type' => 'text'],
    ['title' => 'Ubicación', 'field' => 'ubicacion', 'type' => 'text'],
    ['title' => 'Descripción', 'field' => 'descripcion', 'type' => 'text'],
    ['title' => 'Acciones', 'type' => 'actions', 'actions' => [
        ['icon' => 'eye', 'color' => 'blue', 'url' => BASE_URL . '/datacenter/mostrar/'],
        ['icon' => 'edit', 'color' => 'yellow', 'url' => BASE_URL . '/datacenter/modificar/'],
        ['icon' => 'trash', 'color' => 'red', 'url' => BASE_URL . '/datacenter/confirmar-borrado/']
    ]]
];

// contenido
echo '<div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200 flex justify-between items-center">
            <div>
                <h2 class="text-xl font-semibold text-gray-800">Datacenters</h2>
                <p class="text-sm text-gray-500 mt-1">Total: ' . $data['total'] . ' datacenters</p>
            </div>
            <a href="' . BASE_URL . '/datacenter/crear" class="px-4 py-2 bg-blue-600 text-white rounded-md hover:bg-blue-700 transition-colors">
                <i class="fas fa-plus mr-2"></i>Nuevo Datacenter
            </a>
        </div>';

echo buildTable($data, $columns);
echo buildPagination($data, 'datacenter');

echo '</div>';
