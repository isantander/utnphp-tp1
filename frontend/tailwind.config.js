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