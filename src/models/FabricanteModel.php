<?php

require_once __DIR__ . '/../db.php';

function crearFabricante($nombre) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO Fabricante (nombre)
            VALUES (:nombre)
        ");
        
        $stmt->bindParam(':nombre', $nombre);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al insertar fabricante: " . $e->getMessage());
        return false;
    }
}

function listarFabricantes() {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Fabricante WHERE deleted IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al listar fabricante: " . $e->getMessage());
        return false;
    }
}

function obtenerFabricante($id) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Fabricante WHERE id = :id AND deleted IS NULL");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener fabricante: " . $e->getMessage());
        return false;
    }
}

function eliminarFabricante($id) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("UPDATE Fabricante SET deleted = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al eliminar fabricante: " . $e->getMessage());
        return false;
    }
}