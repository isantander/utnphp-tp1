<?php

require_once __DIR__ . '/../db.php';

function model_crear_tipo_dispositivo($descripcion) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO TipoDispositivo (descripcion)
            VALUES (:descripcion)
        ");
        
        $stmt->bindParam(':descripcion', $descripcion);
        
        if ($stmt->execute()) {
            return $pdo->lastInsertId();
        }
        
        return false;

    } catch (PDOException $e) {
        error_log("Error al insertar tipo dispositivo: " . $e->getMessage());
        return false;
    }
}

function model_modificar_tipo_dispositivo($id,$descripcion) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            UPDATE TipoDispositivo SET 
                descripcion = :descripcion
            WHERE id = :id AND deleted IS NULL
        ");
        
        $stmt->bindParam(':id', $id);
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
function model_listar_tipo_dispositivos() {
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

function model_obtener_tipo_dispositivo($id) {
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

function model_eliminar_tipo_dispositivo($id) {
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
