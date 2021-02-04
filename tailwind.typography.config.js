module.exports = (theme) => ({
  light: {
    css: [
      {
        color: theme('colors.gray.400'),
        '[class~="lead"]': {
          color: theme('colors.gray.300'),
        },
        a: {
          color: theme('colors.gray.100'),
        },
        strong: {
          color: theme('colors.gray.100'),
        },
        'ol > li::before': {
          color: theme('colors.gray.400'),
        },
        'ul > li::before': {
          backgroundColor: theme('colors.gray.700'),
        },
        hr: {
          borderColor: theme('colors.gray.300'),
        },
        blockquote: {
          color: theme('colors.gray.300'),
          borderLeftColor: theme('colors.gray.700'),
        },
        h1: {
          color: theme('colors.gray.100'),
        },
        h2: {
          color: theme('colors.gray.100'),
        },
        h3: {
          color: theme('colors.gray.100'),
        },
        h4: {
          color: theme('colors.gray.100'),
        },
        'figure figcaption': {
          color: theme('colors.gray.400'),
        },
        code: {
          color: theme('colors.gray.300'),
        },
        'a code': {
          color: theme('colors.gray.300'),
        },
        pre: {
          color: theme('colors.gray.300'),
          backgroundColor: theme('colors.gray.900'),
        },
        thead: {
          color: theme('colors.gray.100'),
          borderBottomColor: theme('colors.gray.400'),
        },
        'tbody tr': {
          borderBottomColor: theme('colors.gray.700'),
        },
      },
    ],
  },
})
