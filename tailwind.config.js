/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./*.php", "./**/*.php"],
  
  // --- TAMBAHKAN SAFELIST DI SINI ---
  safelist: [
    'booked',
    'available',
    'empty'
  ],
  // ----------------------------------

  theme: {
    extend: {
      colors: {
        sipblue: '#009EF7',
        sipbluehover: '#007BB5',
        sipred: '#DE2828',
        sipdark: '#16181e',
        sipbg: '#1c202a',
        sipborder: '#2d3240',
        siptext: '#64748B'
      },
      fontFamily: {
        sans: ['Inter', 'sans-serif'],
      }
    },
  },
  plugins: [],
}