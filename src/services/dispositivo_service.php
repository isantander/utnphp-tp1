<?php

require_once __DIR__ . '/../models/dispositivo_model.php';

class DispositivoNotFoundException extends Exception {}
class RackNotFoundException extends Exception {}
class FabricanteNotFoundException extends Exception {}

function service_crear_dispositivo($id_tipo_dispositivo, $id_rack, $id_fabricante,$ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones) {

    if(!model_obtener_tipo_dispositivo($id_tipo_dispositivo)) {
        throw new DispositivoNotFoundException();
    }
    
    if(!model_obtener_rack($id_rack)) {
        throw new RackNotFoundException();
    }
    
    if(!model_obtener_fabricante($id_fabricante)) {
        throw new FabricanteNotFoundException();
    }
    
    return model_crear_dispositivo($id_tipo_dispositivo, $id_rack, $id_fabricante, $ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones);

}

function service_modificar_dispositivo($id, $id_tipo_dispositivo, $id_rack, $id_fabricante,$ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones) {

    if(!model_obtener_tipo_dispositivo($id_tipo_dispositivo)) {
        throw new DispositivoNotFoundException();
    }
    
    if(!model_obtener_rack($id_rack)) {
        throw new RackNotFoundException();
    }
    
    if(!model_obtener_fabricante($id_fabricante)) {
        throw new FabricanteNotFoundException();
    }
    
    return model_modificar_dispositivo($id, $id_tipo_dispositivo, $id_rack, $id_fabricante, $ubicacion_rack, $modelo, $nro_serie, $nombre, $estado, $observaciones);

}