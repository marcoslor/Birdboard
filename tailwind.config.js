module.exports = {
  important: true,
  theme: {
    container: {
      center: true,
    },

    extend: {
      boxShadow: {
        default: '0 0 5px 0 rgba(0, 0, 0, 0.08)'
      },
      colors: {
        'grey-light': '#f5f6f9',
        'blue': '#47cdff',
        'blue-light': '#8ae2fe'
      }
    }
  },
  variants: {
    opacity: ['responsive', 'hover']
  }
};