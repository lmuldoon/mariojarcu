module.exports = {
  purge: {
    enable: true,
    content: [
      __dirname + '/../assets/src/js/**/*',
      __dirname + '/../template-parts/**/**/*',
      __dirname + '/../page-templates/**/**/*',
      __dirname + '/../*.php',
    ]
  },
  important: true,
  darkMode: false, // or 'media' or 'class'
  theme: {
    colors: {
      transparent: 'var(--color-transparent)',
      black: 'var(--color-black)',
      carbon: 'var(--color-carbon)',
      ink: 'var(--color-ink)',
      white: 'var(--color-white)',
      gold: 'var(--color-gold)',
      'gold-dark': 'var(--color-gold-dark)',
      'gold-bright': 'var(--color-gold-bright)',
      'gold-light': 'var(--color-gold-light)',
      'cream-heading': 'var(--color-cream-heading)',
      'ink-text': 'var(--color-ink-text)',
      'gold-on': 'var(--color-gold-on)',
      muted: 'var(--color-muted)',
      error: 'var(--color-error)',
      warning: 'var(--color-warning)',
      success: 'var(--color-success)'
    },
    screens: {
      'sm': '576px',
      'md': '768px',
      'lg': '1024px',
      'mobile-menu': '1000px',
      'xl': '1351px',
      '2xl': '1636px',
    },
    fontFamily: {
      body: ['Montserrat', 'sans-serif'],
      heading: ['Montserrat', 'sans-serif'],
      serif: ['Cormorant Garamond', 'serif'],
      kicker: ['Space Mono', 'monospace'],
    },
    fontWeight: {
      light: 300,
      normal: 400,
      medium: 500,
      semibold: 600,
      bold: 700,
    },
    lineHeight: {
      'tight': 1.1,
      'regular': 1.55,
    },
    variables: {
      DEFAULT: {
        size: {
          "300": 'clamp(0.7em, 0.66rem + 0.2vw, 0.8em)',
          "400": 'clamp(0.88em, 0.83em + 0.24vw, 1em)',
          "500": 'clamp(1.09em, 1em + 0.47vw, 1.275em)',
          "600": 'clamp(1.37em, 1em + 0.8vw, 1.5em)',
          "700": 'clamp(1.5em, 1.45em + 0.78vw, 2.1em)',
          "800": 'clamp(2.14em, 1.74em + 1.99vw, 3.16em)',
          "900": 'clamp(2.67em, 2.0em + 3vw, 3.8em)',
          "1000": 'clamp(3.34em, 2.45em + 4.43vw, 5.61em)',
          "headline": 'clamp(2em, calc(2em + 6.66vw), 192px)'
        },
        color: {
          black: '#131313',
          carbon: '#0E0E0E',
          ink: '#1B1B1B',
          white: '#EDE7DC',
          gold: '#C39A43',
          'gold-dark': '#8C6E24',
          'gold-bright': '#D4AC52',
          'gold-light': '#E3C57C',
          'cream-heading': '#F4EFE6',
          'ink-text': '#1C1813',
          'gold-on': '#1A150B',
          muted: '#57514A',
          error: '#d81e1e',
          warning: '#ff6700',
          success: '#4bb543'
        },
      },
      // '.container': {
      //   sizes: {
      //     medium: '1.5em',
      //   },
      // },
    },
  },
  variants: {
    extend: {

    },
  },
  plugins: [require('@mertasan/tailwindcss-variables')],
  corePlugins: {
    preflight: false
  }

};
