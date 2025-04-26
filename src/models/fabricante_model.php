<?php

require_once __DIR__ . '/../db.php';

function model_crear_fabricante($nombre) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO Fabricante (nombre)
            VALUES (:nombre)
        ");
        
        $stmt->bindParam(':nombre', $nombre);
        
        if ($stmt->execute()) {
            return $pdo->lastInsertId();
        }
        
        return false;

    } catch (PDOException $e) {
        return false;
    }
}

function model_modificar_fabricante($id,$nombre) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            UPDATE Fabricante SET 
                nombre = :nombre
            WHERE id = :id and deleted IS NULL
        ");
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);

        $stmt->execute();
        return $stmt->rowCount() > 0;

    } catch (PDOException $e) {
        return false;
    }
}

function model_listar_fabricantes() {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Fabricante WHERE deleted IS NULL");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function model_obtener_fabricante($id) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Fabricante WHERE id = :id AND deleted IS NULL");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function model_eliminar_fabricante($id) {

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