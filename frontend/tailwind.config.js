/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
      "./node_modules/flowbite/**/*.js",
      "./index.php",
      "./views/**/*.php"
    ],
    theme: {
      extend: {},
    },
    plugins: [
      require('flowbite/plugin') 
    ],
  }