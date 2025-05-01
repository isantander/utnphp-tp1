<?php

require_once __DIR__ . '/../db.php';

function model_crear_datacenter($nombre, $ubicacion, $descripcion) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            INSERT INTO Datacenter (nombre, ubicacion, descripcion)
            VALUES (:nombre, :ubicacion, :descripcion)
        ");
        
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':descripcion', $descripcion);

        if ($stmt->execute()) {
            return $pdo->lastInsertId();
        }
        
        return false;

    } catch (PDOException $e) {
        error_log("Error al insertar datacenter: " . $e->getMessage());
        return false;
    }
}

function model_modificar_datacenter($id,$nombre, $ubicacion, $descripcion) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("
            UPDATE Datacenter SET 
                nombre = :nombre,
                ubicacion = :ubicacion,
                descripcion = :descripcion
            WHERE id = :id AND deleted IS NULL
        ");
        
        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':ubicacion', $ubicacion);
        $stmt->bindParam(':descripcion', $descripcion);
        $stmt->execute();

        if ($stmt->execute()) {
            return true;
        }
        
        return false;

    } catch (PDOException $e) {
         return false;
    }

}

/* function model_listar_datacenter() {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Datacenter WHERE deleted IS NULL");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    } catch (PDOException $e) {
        error_log("Error al obtener datacenter: " . $e->getMessage());
        return [];
    }

} */

function model_listar_datacenter($limit, $offset) {
    try {
        $pdo = getConnection();

        $stmtTotal = $pdo->query("SELECT COUNT(*) FROM Datacenter WHERE deleted IS NULL");
        $total = (int)$stmtTotal->fetchColumn();

        $stmt = $pdo->prepare("SELECT * FROM Datacenter WHERE deleted IS NULL LIMIT :limit OFFSET :offset");
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


function model_obtener_datacenter($id) {

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

function model_eliminar_datacenter($id) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("UPDATE Datacenter SET deleted = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount();

    } catch (PDOException $e) {
        error_log("Error al eliminar datacenter: " . $e->getMessage());
        return false;
    }

}

function model_datacenter_existe($id) {

    $pdo = getConnection();
    $stmt = $pdo->prepare("SELECT id FROM Datacenter WHERE id = ? and DELETED IS NULL");
    $stmt->execute([$id]);

    return $stmt->fetch() !== false;
}