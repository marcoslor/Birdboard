module.exports = {
  important: true,
  theme: {
    container: {
      center: true,
    },
    backgroundColor: {
      page: 'var(--page-background-color)',
      card: 'var(--card-background-color)',
      button: 'var(--button-background-color)',
      nav: 'var(--page-nav-background-color)'
    },
    textColor: {
      default: 'var(--text-default-color)',
      accent: 'var(--text-accent-color)',
      'accent-light': 'var(--text-accent-light-color)',
      muted: 'var(--text-muted-color)',
      'muted-light': 'var(--text-muted-light-color)',
      error: 'var(--text-error-color)'
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
