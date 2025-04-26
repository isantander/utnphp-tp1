<?php

require_once __DIR__ . '/../db.php';

function model_crear_rack($id_datacenter, $numero, $descripcion){

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO Rack (id_datacenter, numero, descripcion)
            VALUES (:id_datacenter, :numero, :descripcion)
        ");
        
        $stmt->bindParam(':id_datacenter', $id_datacenter);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':descripcion', $descripcion);
        
        if ($stmt->execute()) {
            return $pdo->lastInsertId();
        }
        
        return false;

    } catch (PDOException $e) {
        return false;
    }
    
}

function model_modificar_rack($id,$id_datacenter, $numero, $descripcion) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            UPDATE Rack SET 
                id_datacenter = :id_datacenter,
                numero = :numero,
                descripcion = :descripcion
            WHERE id = :id AND deleted IS NULL
        ");
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':id_datacenter', $id_datacenter);
        $stmt->bindParam(':numero', $numero);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();
        
        if ($stmt->rowCount() > 0) {
            return true;
        } else {
            return 0;
        }

    } catch (PDOException $e) {
        return false;
    }
}

function model_listar_racks() {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Rack WHERE deleted IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        return false;
    }
}

function model_obtener_rack($id) {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Rack WHERE id = :id AND deleted IS NULL");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        $rack = $stmt->fetch(PDO::FETCH_ASSOC);

        return $rack ?: null;

    } catch (PDOException $e) {
        return false;
    }
}

function model_eliminar_rack($id) {

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

function model_rack_en_datacenter_existe($id) {

    try {

        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT id FROM Rack WHERE id_datacenter = :id_datacenter");
        $stmt->bindParam(':id_datacenter', $id, PDO::PARAM_INT);
        $stmt->execute();
     
        return $stmt->rowCount() !== 0;

    } catch (PDOException $e) {
        error_log("Error en model_rack_en_datacenter_existe: " . $e->getMessage());
        return false;
    }

}