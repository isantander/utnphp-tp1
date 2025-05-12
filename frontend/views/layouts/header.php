<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistema de Inventario - <?php echo ucfirst(str_replace('-', ' ', $page)); ?></title>
    <link href="<?php echo BASE_URL; ?>/views/public/css/styles.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <script src="ps://cdn.jsdelivr.net/npm/jquery@3.6.0/dist/jquery.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.8.1/flowbite.min.js"></script>  
    
    <script src="<?php echo BASE_URL; ?>/assets/js/app.js"></script>

    <style>
        .nav-btn {
            @apply text-white font-medium rounded-xl text-sm px-6 py-3.5 text-center transition-all duration-300;
            min-width: 200px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            position: relative;
            overflow: hidden;
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 3px;
            border-radius: 4px;
        }
        
        .nav-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 0, 0, 0.2);
        }
    </style> 
</head>
<body class="bg-gray-50">
    <div class="container mx-auto px-4 py-8">
        <header class="mb-10 text-center">
            <h1 class="text-4xl font-bold text-gray-800">Trabajo practico Nro 1</h1>
            <p class="mt-2 text-lg text-gray-600">Gestión centralizada de activos tecnológicos</p>
        </header>
        