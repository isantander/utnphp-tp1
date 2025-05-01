# Instrucciones para la instalación del Sistema

## Primero se debe crear la bbdd e importar las tablas del sistema que se encuentran en el directorio utils

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

## Inicar composer para instalar las dependencias

```bash
composer init 
```
*Una vez configurado buscar e instalar vlucas/phpdotenv*



## Probar el sistema con el servidor web integrado a PHP

```bash
php -S localhost:8000
```

