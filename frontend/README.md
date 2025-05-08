# Instrucciones para la instalación del Sistema

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
      "./node_modules/flowbite/**/*.js",
      "./index.php",
      "./views/**/*.php",
      "./resources/utils/*.php"
    ],
    theme: {
      extend: {},
    },
    plugins: [
      require('flowbite/plugin') 
    ],
  }
```

### Crear el archivo css base resource/css/app.css

```css
@tailwind base;
@tailwind components;
@tailwind utilities;
```
### Compilar con tailwindcss

```bash
npx tailwindcss -i ./resources/css/app.css -o ./views/public/css/style.css --watch
o
npm run build
```

## Instalar el framework Flowbite

```bash
npm install flowbite
```

