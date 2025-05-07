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

function model_dispositivo_existe_en_rack($id_rack){

    try {
        
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Dispositivo WHERE id_rack = :id_rack and deleted IS NULL");
        $stmt->bindParam(':id_rack', $id_rack);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();

    } catch (PDOException $e) {
        return false;
    }

}

function model_dispositivo_existe_en_tipo_dispositivo($id_tipo_dispositivo){

    try {
        
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Dispositivo WHERE id_tipo_dispositivo = :id_tipo_dispositivo and deleted IS NULL");
        $stmt->bindParam(':id_tipo_dispositivo', $id_tipo_dispositivo);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();

    } catch (PDOException $e) {
        return false;
    }

}

function model_dispositivo_existe_en_fabricante($id_fabricante){

    try {
        
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT * FROM Dispositivo WHERE id_fabricante = :id_fabricante and deleted IS NULL");
        $stmt->bindParam(':id_fabricante', $id_fabricante);
        $stmt->execute();

        return (bool) $stmt->fetchColumn();

    } catch (PDOException $e) {
        return false;
    }

}

function model_listar_dispositivos($limit, $offset) {
    try {
        $pdo = getConnection();

        $stmtTotal = $pdo->query("SELECT COUNT(*) FROM Dispositivo WHERE deleted IS NULL");
        $total = (int)$stmtTotal->fetchColumn();

        $stmt = $pdo->prepare("SELECT D.id as id, DC.nombre as datacenter, TD.descripcion as descripcion_td, R.descripcion as descripcion_rack, 
                                             F.nombre as nombre_fabricante, D.Ubicacion_rack, D.modelo, D.nro_serie, D.nombre, D.estado, D.observaciones
                                        FROM Dispositivo as D
                                        INNER JOIN Fabricante as F ON D.id_fabricante = F.id
                                        INNER JOIN TipoDispositivo as TD ON D.id_tipo_dispositivo = TD.id
                                        INNER JOIN Rack as R ON D.id_rack = R.id
                                        INNER JOIN Datacenter as DC ON R.id_datacenter = DC.id
                                        WHERE D.deleted IS NULL 
                                        LIMIT :limit OFFSET :offset");
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


function model_obtener_dispositivo($id) {

    try {
        $pdo = getConnection();
        $stmt = $pdo->prepare("SELECT id, id_rack, id_fabricante, id_tipo_dispositivo, ubicacion_rack, modelo, nro_serie, nombre, estado, observaciones 
                                FROM Dispositivo WHERE id = :id and deleted IS NULL");
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);

    } catch (PDOException $e) {
        return false;
    }

}