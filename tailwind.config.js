/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ['./src/**/*.{php,js}', './public/**/*.{php,js}'],
  theme: {
    extend: {},
  },
  plugins: [
    require('daisyui'),
  ],
}

