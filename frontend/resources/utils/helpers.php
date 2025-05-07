<?php

function fetchApiData($entidad, $page = 0, $limit = 5, $accion = "listar", $id = null) {

    $baseUrl = "http://127.0.0.1:8000/api/index.php";

    $ch = curl_init();

    // en la API listar es GET y obtener POST
    if ($accion === 'listar') {

        $url = "$baseUrl?accion=$accion&entidad=$entidad&limit=$limit&page=$page";
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_HTTPGET, true);

    } elseif ($accion === 'obtener' && $id !== null) {

        curl_setopt($ch, CURLOPT_URL, $baseUrl);
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query([
            'accion' => 'obtener',
            'entidad' => $entidad,
            'id' => $id
        ]));

    } else {
        return null;
    }

    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);

    return json_decode($response, true);
}


function buildTable($data, $columns) {
    $html = '<div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>';
    
    // encabezado
    foreach ($columns as $column) {
        $html .= '<th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">' . $column['title'] . '</th>';
    }
    $html .= '</tr></thead><tbody class="bg-white divide-y divide-gray-200">';
    
    // filas
    foreach ($data['data'] as $item) {
        $html .= '<tr class="hover:bg-gray-50">';
        foreach ($columns as $column) {
            $html .= '<td class="px-6 py-4 whitespace-nowrap text-sm ';
            $html .= ($column['type'] == 'text' ? 'text-gray-500' : 'font-medium text-gray-900') . '">';
            
            if ($column['type'] === 'actions') {
                // botones
                foreach ($column['actions'] as $action) {
                    $html .= '<a href="' . $action['url'] . $item['id'] . '" class="mr-2 text-' . $action['color'] . '-600 hover:text-' . $action['color'] . '-900">
                                <i class="fas fa-' . $action['icon'] . '"></i>
                              </a>';
                }
            } else {
                // datos
                $html .= $item[$column['field']] ?? '';
            }
            
            $html .= '</td>';
        }
        $html .= '</tr>';
    }
    
    $html .= '</tbody></table></div>';
    
    return $html;
}

function buildPagination($data, $entidad) {
    $html = '<div class="bg-white px-6 py-3 flex items-center justify-between border-t border-gray-200">
                <div class="flex-1 flex justify-between items-center">
                    <div>
                        <p class="text-sm text-gray-700">
                            Mostrando <span class="font-medium">' . (($data['page'] - 1) * $data['limit'] + 1) . '</span> a 
                            <span class="font-medium">' . min($data['page'] * $data['limit'], $data['total']) . '</span> de 
                            <span class="font-medium">' . $data['total'] . '</span> resultados
                        </p>
                    </div>
                    <div class="flex space-x-2">';
    
    if ($data['page'] > 1) {
        $html .= '<a href="' . BASE_URL . '/' . $entidad . '/listar/'  . ($data['page'] - 1) . '" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md bg-white text-gray-700 hover:bg-gray-50">
                    Anterior
                 </a>';
    }
    
    if ($data['page'] < $data['pages']) {
        $html .= '<a href="' . BASE_URL . '/' . $entidad .  '/listar/' . ($data['page'] + 1) . '" class="relative inline-flex items-center px-4 py-2 border border-gray-300 text-sm font-medium rounded-md bg-white text-gray-700 hover:bg-gray-50">
                    Siguiente
                 </a>';
    }
    
    $html .= '</div></div></div>';
    
    return $html;
}
