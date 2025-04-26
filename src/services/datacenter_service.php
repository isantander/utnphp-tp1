<?php

require_once __DIR__ . '/../models/rack_model.php';
require_once __DIR__ . '/../models/datacenter_model.php';

class RackAsociadoException extends Exception {}

function service_eliminar_datacenter($id){

    if(model_rack_en_datacenter_existe($id)){
        throw new RackAsociadoException("El datacenter tiene uno o más racks asociados");
    }

    return model_eliminar_datacenter($id);
    
}