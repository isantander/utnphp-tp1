<?php

use function PHPUnit\Framework\throwException;

require_once   __DIR__ . '/../db.php';

function model_crear_dispositivo($id_tipo_dispositivo, $id_rack, $id_fabricante,$ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones) {
    
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("INSERT INTO Dispositivo (id_tipo_dispositivo, id_rack, id_fabricante, ubicacion_rack, modelo, nro_serie, nombre, estado, observaciones)
                                      VALUES (:id_tipo_dispositivo, :id_rack, :id_fabricante, :ubicacion_rack, :modelo, :nro_serie, :nombre, :estado, :observaciones)");

        $stmt->bindParam(':id_tipo_dispositivo', $id_tipo_dispositivo);
        $stmt->bindParam(':id_rack', $id_rack); 
        $stmt->bindParam(':id_fabricante', $id_fabricante);
        $stmt->bindParam(':ubicacion_rack', $ubicacion_rack);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':nro_serie', $nro_serie);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':observaciones', $observaciones);

        if ($stmt->execute()) {
            return $pdo->lastInsertId();
        }
        
        return false;

    } catch (PDOException $e) {
        return false;
    }

}

function model_modificar_dispositivo($id, $id_tipo_dispositivo, $id_rack, $id_fabricante,$ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones) {
    
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("UPDATE Dispositivo 
                                SET id_tipo_dispositivo = :id_tipo_dispositivo, id_rack = :id_rack, id_fabricante = :id_fabricante, ubicacion_rack = :ubicacion_rack, 
                                modelo = :modelo, nro_serie = :nro_serie, nombre = :nombre, estado = :estado, observaciones = :observaciones
                                WHERE id = :id and DELETED IS NULL");

        $stmt->bindParam(':id_tipo_dispositivo', $id_tipo_dispositivo);
        $stmt->bindParam(':id_rack', $id_rack); 
        $stmt->bindParam(':id_fabricante', $id_fabricante);
        $stmt->bindParam(':ubicacion_rack', $ubicacion_rack);
        $stmt->bindParam(':modelo', $modelo);
        $stmt->bindParam(':nro_serie', $nro_serie);
        $stmt->bindParam(':nombre', $nombre);
        $stmt->bindParam(':estado', $estado);
        $stmt->bindParam(':observaciones', $observaciones);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if ($stmt->rowCount() > 0) {
            return true;
        }

        return 0;

    } catch (PDOException $e) {
        return false;
    }

}


function model_eliminar_dispositivo($id) {
    
    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("UPDATE Dispositivo SET deleted = NOW() WHERE id = :id");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        if($stmt->rowCount() > 0) {
            return true;
        }

        throw new DispositivoNotFoundException();

    } catch (PDOException $e) {
         return false;
    }   

}