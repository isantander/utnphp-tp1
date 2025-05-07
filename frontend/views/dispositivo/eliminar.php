<?php

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['id'])) {

    $id = intval($_POST['id']);

    $payload = json_encode([
        "id" => $id,
        "apykey" => "kjasiuaSHDIUASHDIAUSDASDASD23123123"  // Esto es poco serio !! pero bueno, por ahora zafa
    ]);

    $ch = curl_init("http://127.0.0.1:8000/api/index.php?accion=eliminar&entidad=dispositivo");
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
    curl_setopt($ch, CURLOPT_POSTFIELDS, $payload);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, ['Content-Type: application/json']);
    $result = curl_exec($ch);
    curl_close($ch);
}

header("Location: " . BASE_URL . "/dispositivo/listar");

exit;
