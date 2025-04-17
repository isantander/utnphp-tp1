<?php

require_once __DIR__ . '/../db.php';

function crearRack($id_datacenter, $numero, $descripcion){

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO Rack (id_datacenter, numero, descripcion)
            VALUES (:id_datacenter, :numero, :descripcion)
        ");
        
        $stmt->bindParam(':id_datacenter', $id_datacenter);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al insertar rack: " . $e->getMessage());
        return false;
    }
}

function listarRacks() {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Rack WHERE deleted IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al listar rack: " . $e->getMessage());
        return false;
    }
}

function obtenerRack($id) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Rack WHERE id = :id AND deleted IS NULL");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener rack: " . $e->getMessage());
        return false;
    }
}

function eliminarRack($id) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("UPDATE Rack SET deleted = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al eliminar rack: " . $e->getMessage());
        return false;
    }
}
