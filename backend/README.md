# Instrucciones para la instalación del Sistema

## Primero ingresar en el directorio backend

## Luego se debe crear la bbdd e importar las tablas del sistema que se encuentran en el directorio utils

*Ejemplo de creación de bbdd, usuario, permisos y creacion de tablas*

```bash
mysql -u root -p
CREATE DATABASE tp1;
CREATE USER 'tp1'@'localhost' IDENTIFIED BY 'contraseña';
GRANT ALL PRIVILEGES ON tp1.* TO 'tp1'@'localhost';
FLUSH PRIVILEGES;
use tp1;
source utils/crear_tablas.sql;
exit;
``` 

## A continuación crear el archivo .env con las credenciales de la bbdd, ejemplo:

```bash
DB_HOST=127.0.0.1
DB_DATABASE=tp1
DB_USERNAME=tp1
DB_PASSWORD=contraseña
```

## Inicar composer para instalar las dependencias

```bash
composer init 
```

*Una vez configurado buscar e instalar vlucas/phpdotenv*

```bash
composer require vlucas/phpdotenv
```

## Probar el sistema con el servidor web integrado a PHP

```bash
php -S localhost:8000
```

## Test
*En la carpeta test se encuentran algunos test para verificar el correcto funcionamiento de la API, para ejecutarlo desde el directorio backend se debe ejecuar*

```bash
vendor/bin/phpunit tests/apiTest.php
```

## Importante, un test intentará eliminar un datacenter que tenga dispositivos asociados, se espera un error 409 pero dará un error 404. 
## Este test aún requiere ser corregido, para probar y que no falle es necesario consultar la bbdd y tomar un id que esté en uso. Es importante recordar que el test busca el error, por lo tanto solo es necesario cambiar la línea 
*'id' => 4 // Id que tiene varios racks asociados*
## Luego de esa corrección todos los test pasaran sin problemas, en caso de errores no se hicieron todos los pasos indicados

