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
/* function model_listar_tipo_dispositivo() {
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM TipoDispositivo WHERE deleted IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al listar tipo dispositivo: " . $e->getMessage());
        return false;
    }
} */

function model_listar_tipo_dispositivo($limit, $offset) {

    try {
        $pdo = getConnection();

        $stmtTotal = $pdo->query("SELECT COUNT(*) FROM TipoDispositivo WHERE deleted IS NULL");
        $total = (int)$stmtTotal->fetchColumn();

        $stmt = $pdo->prepare("SELECT * FROM TipoDispositivo WHERE deleted IS NULL LIMIT :limit OFFSET :offset");
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        $data = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return [
            'data' => $data,
            'total' => $total
        ];

    } catch (PDOException $e) {
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
        $stmt = $pdo->prepare("UPDATE TipoDispositivo SET deleted = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $id);
        return $stmt->execute();
    } catch (PDOException $e) {
        error_log("Error al eliminar tipo dispositivo: " . $e->getMessage());
        return false;
    }
}
