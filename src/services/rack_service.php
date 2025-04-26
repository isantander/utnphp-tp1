<?php

require_once __DIR__ . '/../models/rack_model.php';
require_once __DIR__ . '/../models/datacenter_model.php';

class DataCenterNotFoundException extends Exception {};

function service_crear_rack($id_datacenter, $numero, $descripcion){

    if(!model_obtener_datacenter($id_datacenter)){
        throw new DataCenterNotFoundException("El datacenter no existe");
    }

    return model_crear_rack($id_datacenter, $numero, $descripcion);
    
}

function service_modificar_rack($id,$id_datacenter, $numero, $descripcion) {

    if(!model_obtener_datacenter($id_datacenter)){
        throw new DataCenterNotFoundException("El datacenter no existe");
    }

    return model_modificar_rack($id,$id_datacenter, $numero, $descripcion);
}
