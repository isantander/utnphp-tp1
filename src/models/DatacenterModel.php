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

function listarDatacenter() {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Datacenter WHERE deleted IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener datacenter: " . $e->getMessage());
        return [];
    }
}

function obtenerDatacenter($id) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Datacenter WHERE id = :id AND deleted IS NULL");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener datacenter: " . $e->getMessage());
        return [];
    }
}

function eliminarDatacenter($id) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("UPDATE Datacenter SET deleted = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al eliminar datacenter: " . $e->getMessage());
        return false;
    }
}