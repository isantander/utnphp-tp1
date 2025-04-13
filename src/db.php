<?php

// Cargar dependencias de Composer
require '../vendor/autoload.php';

try {
    $dotenv = Dotenv\Dotenv::createImmutable("../");
    $dotenv->load();
} catch (Dotenv\Exception\InvalidPathException $e) {
    header('Content-Type: application/json');
    http_response_code(500); // Internal Server Error
    echo json_encode(['status' => 'error', 'message' => 'Error interno del servidor: configuración no encontrada.']);
    exit;
} catch (Exception $e) {
    header('Content-Type: application/json');
    http_response_code(500);
    echo json_encode(['status' => 'error', 'message' => 'Error interno del servidor: ' . $e->getMessage()]);
    exit;
}
function getConnection() {

    // Obtener las credenciales de la base de datos desde el archivo .env
    $host = $_ENV['DB_HOST'] ?? '127.0.0.1';
    $dbname = $_ENV['DB_DATABASE'] ?? null;
    $user = $_ENV['DB_USERNAME'] ?? null;
    $pass = $_ENV['DB_PASSWORD'] ?? null;
    $charset = 'utf8mb4';

    // Verificar credenciales esenciales
    if (!$dbname || !$user || !$pass) {
        header('Content-Type: application/json');
        http_response_code(500);
        echo json_encode(['status' => 'error', 'message' => 'Error de configuración: DB_DATABASE, DB_USERNAME y DB_PASSWORD  son requeridos.']);
        exit;
    }

    static $pdo = null;

    if ($pdo === null) {

        $dsn = "mysql:host=$host;dbname=$dbname;charset=$charset";
        $options = [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        ];

        $pdo = new PDO($dsn, $user, $pass, $options);
    }

    return $pdo;
}
