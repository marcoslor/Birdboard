let colors = {
  default: 'var(--text-default-color)',
  accent: 'var(--text-accent-color)',
  'accent-light': 'var(--text-accent-light-color)',
  muted: 'var(--text-muted-color)',
  'muted-light': 'var(--text-muted-light-color)',
  'error': 'var(--text-error-color)'
};

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
      nav: 'var(--header-background-color)'
    },
    textColor: colors,
    extend: {
      boxShadow: {
        default: '0 0 5px 0 rgba(0, 0, 0, 0.08)'
      },
      colors: colors
    }
  },
  variants: {
    opacity: ['responsive', 'hover']
  }
};
