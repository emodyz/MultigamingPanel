module.exports = (theme) => ({
  light: {
    css: [
      {
        color: theme('colors.zinc.400'),
        '[class~="lead"]': {
          color: theme('colors.zinc.300'),
        },
        a: {
          color: theme('colors.zinc.100'),
        },
        strong: {
          color: theme('colors.zinc.100'),
        },
        'ol > li::before': {
          color: theme('colors.zinc.400'),
        },
        'ul > li::before': {
          backgroundColor: theme('colors.zinc.700'),
        },
        hr: {
          borderColor: theme('colors.zinc.600'),
        },
        blockquote: {
          color: theme('colors.zinc.300'),
          borderLeftColor: theme('colors.zinc.700'),
        },
        h1: {
          color: theme('colors.zinc.100'),
        },
        h2: {
          color: theme('colors.zinc.100'),
        },
        h3: {
          color: theme('colors.zinc.100'),
        },
        h4: {
          color: theme('colors.zinc.100'),
        },
        'figure figcaption': {
          color: theme('colors.zinc.400'),
        },
        code: {
          color: theme('colors.zinc.300'),
        },
        'a code': {
          color: theme('colors.zinc.300'),
        },
        pre: {
          color: theme('colors.zinc.300'),
          backgroundColor: theme('colors.zinc.900'),
        },
        thead: {
          color: theme('colors.zinc.100'),
          borderBottomColor: theme('colors.zinc.600'),
        },
        'tbody tr': {
          borderBottomColor: theme('colors.zinc.700'),
        },
      },
    ],
  },
})
