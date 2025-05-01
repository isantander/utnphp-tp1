<?php
// Función para determinar si la ruta está activa
function isActive($currentEntity, $entity) {
    return $currentEntity === $entity ? 'ring-2 ring-opacity-50' : '';
}

// Obtener la entidad actual del router
global $entity;
?>

<div class="flex flex-wrap justify-center gap-6 mb-12">
    <a href="<?php echo BASE_URL; ?>/datacenters" 
       class="nav-btn bg-gradient-to-br from-blue-500 to-blue-600 <?php echo isActive($entity, 'datacenters'); ?>">
        <i class="mr-2 fas fa-server"></i> Datacenter
    </a>
    <a href="<?php echo BASE_URL; ?>/racks" 
       class="nav-btn bg-gradient-to-br from-green-500 to-green-600 <?php echo isActive($entity, 'racks'); ?>">
        <i class="mr-2 fas fa-layer-group"></i> Rack
    </a>
    <a href="<?php echo BASE_URL; ?>/fabricantes" 
       class="nav-btn bg-gradient-to-br from-purple-500 to-purple-600 <?php echo isActive($entity, 'fabricantes'); ?>">
        <i class="mr-2 fas fa-industry"></i> Fabricantes
    </a>
    <a href="<?php echo BASE_URL; ?>/tipo-dispositivos" 
       class="nav-btn bg-gradient-to-br from-amber-500 to-amber-600 <?php echo isActive($entity, 'tipo-dispositivos'); ?>">
        <i class="mr-2 fas fa-laptop-code"></i> Tipo Dispositivos
    </a>
    <a href="<?php echo BASE_URL; ?>/dispositivos" 
       class="nav-btn bg-gradient-to-br from-red-500 to-red-600 <?php echo isActive($entity, 'dispositivos'); ?>">
        <i class="mr-2 fas fa-network-wired"></i> Dispositivos
    </a>
</div>

