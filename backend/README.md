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



## Instalar tailwindcss

```bash
npm init -y
npm install -D tailwindcss@^3.4 postcss autoprefixer
npx tailwindcss init -p
```
### Editar el archivo tailwind.config.js y agregar :

```js
/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./**/*.html",
    "./**/*.php",
    "./resources/**/*.js",
  ],
  theme: {
    extend: {},
  },
  plugins: [],
};
```

### Crear el archivo css base resource/css/app.css

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```
### Compilar con tailwindcss

```bash
npx tailwindcss -i ./resources/css/app.css -o ./public/css/app.css --watch
npm install flowbite
```
