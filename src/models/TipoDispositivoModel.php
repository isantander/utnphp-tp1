<?php

require_once __DIR__ . '/../db.php';


function crearTipoDispositivo($descripcion) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO TipoDispositivo (descripcion)
            VALUES (:descripcion)
        ");
        
        $stmt->bindParam(':descripcion', $descripcion);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al insertar tipo dispositivo: " . $e->getMessage());
        return false;
    }
}

function listarTipoDispositivo() {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM TipoDispositivo WHERE deleted IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al listar tipo dispositivo: " . $e->getMessage());
        return false;
    }
}

function obtenerTipoDispositivo($id) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM TipoDispositivo WHERE id = :id AND deleted IS NULL");
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener tipo dispositivo: " . $e->getMessage());
        return false;
    }
}

function eliminarTipoDispositivo($id) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("DELETE FROM TipoDispositivo WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al eliminar tipo dispositivo: " . $e->getMessage());
        return false;
    }
}
