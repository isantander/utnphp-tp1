<?php


require_once __DIR__ . '/../db.php';

function crearDatacenter($nombre, $ubicacion, $descripcion) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO Datacenter (nombre, ubicacion, descripcion)
            VALUES (:nombre, :ubicacion, :descripcion)
        ");
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al insertar datacenter: " . $e->getMessage());
        return false;
    }
}

