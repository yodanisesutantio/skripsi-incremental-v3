/** @type {import('tailwindcss').Config} */
export default {
  content: [
    "./resources/**/*.blade.php",
    "./resources/**/*.js",
    "./resources/**/*.vue",
  ],
  theme: {
    colors: {
      'custom-green': '#24596A',
      'custom-green-hover': '#0E3F4F',
      'custom-dark': '#040B0D',
      'custom-dark-hover': '#151C1E',
      'custom-dark-overlay': 'rgba(4,11,13,.7)',
      'custom-dark-low': 'rgba(4,11,13,.6)',
      'custom-white': '#F7F7F7',
      'custom-white-hover': '#FAFAFA',
      'custom-secondary': '#495D64',
      'custom-disabled-light': '#BDCDD2',
      'custom-disabled-dark': '#9F9F9F',
      'custom-grey': '#646464',
      'custom-warning': '#FAB530',
      'custom-destructive': '#FD3124',
      'custom-success': '#3AB500',
    },
    
    extend: {
      fontFamily: {
        'encode': ["Encode Sans", "sans-serif"],
        'league': ["League Spartan", "serif"],
      }
    },
  },
  plugins: [],
}