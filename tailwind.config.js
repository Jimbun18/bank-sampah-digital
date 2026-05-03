/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    extend: {
      colors: {
        'hijau-utama': '#16a34a',
        'hijau-gelap': '#15803d',
      }
    },
  },
  plugins: [],
}