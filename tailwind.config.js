const defaultTheme = require('tailwindcss/defaultTheme')
const typographyConfig = require('./tailwind.typography.config')
const colors = require('tailwindcss/colors')

module.exports = {
  mode: 'jit',
  darkMode: 'class',
  purge: {
    content: [
      './vendor/laravel/jetstream/**/*.blade.php',
      './storage/framework/views/*.php',
      './resources/views/**/*.blade.php',
      './resources/js/**/*.vue',
    ],
    options: {
      // ⚠️ DO NOT camelCase this prop or it will break!
      safelist: [
        //THE DARK SIDE 😈
        'dark',
        // Scrollbar
        'body', 'body.dark', '::-webkit-scrollbar',
        '::-webkit-scrollbar-track', '::-webkit-scrollbar-thumb',
        '::-webkit-scrollbar-thumb:hover ',
        // Colors
        'text-green-600', 'text-green-900',
        'text-indigo-600', 'text-indigo-900',
        'text-red-600', 'text-red-900', 'text-orange-500',
        // Utilities
        'py-8', 'pb-5', 'pt-6',
        'w-88', 'w-96',
      ],
    }
  },

  theme: {
    extend: {
      typography: typographyConfig,
      fontFamily: {
        sans: ['Nunito', ...defaultTheme.fontFamily.sans],
      },
      boxShadow: {
        solid: '0 0 0 2px currentColor',
        outline: `0 0 0 3px rgba(156, 163, 175, .5)`,
        'outline-gray': `0 0 0 3px rgba(254, 202, 202, .5)`,
        'outline-blue': `0 0 0 3px rgba(191, 219, 254, .5)`,
        'outline-green': `0 0 0 3px rgba(167, 243, 208, .5)`,
        'outline-yellow': `0 0 0 3px rgba(253, 230, 138, .5)`,
        'outline-red': `0 0 0 3px rgba(254, 202, 202, .5)`,
        'outline-pink': `0 0 0 3px rgba(251, 207, 232, .5)`,
        'outline-purple': `0 0 0 3px rgba(221, 214, 254,, .5)`,
        'outline-indigo': `0 0 0 3px rgba(199, 210, 254, .5)`,
      },
      padding: {
        '1/2': '50%',
        '1/3': '33.333333%',
        '2/3': '66.666667%',
        '1/4': '25%',
        '2/4': '50%',
        '3/4': '75%',
        '1/5': '20%',
        '2/5': '40%',
        '3/5': '60%',
        '4/5': '80%',
        '1/6': '16.666667%',
        '2/6': '33.333333%',
        '3/6': '50%',
        '4/6': '66.666667%',
        '5/6': '83.333333%',
        '1/12': '8.333333%',
        '2/12': '16.666667%',
        '3/12': '25%',
        '4/12': '33.333333%',
        '5/12': '41.666667%',
        '6/12': '50%',
        '7/12': '58.333333%',
        '8/12': '66.666667%',
        '9/12': '75%',
        '10/12': '83.333333%',
        '11/12': '91.666667%',
        full: '100%',
      },
      spacing: {
        '88': '22rem',
        '104': '26rem',
        '112': '28rem',
      },
      colors: {
        // ...colors
        gray: colors.gray,
        emerald: colors.emerald,
        orange: colors.orange,
      },
    },
  },

  variants: {
    extend: {
      typography: ['dark'],
      backgroundColor: ['group-focus', 'active', 'even', 'odd', 'disabled', 'checked'],
      borderColor: ['group-focus', 'checked'],
      boxShadow: ['group-focus'],
      opacity: ['group-focus', 'disabled'],
      cursor: ['hover', 'focus', 'disabled'],
      textColor: ['group-focus', 'active', 'disabled'],
      textDecoration: ['group-focus'],
      fontWeight: ['hover', 'focus']
    }
  },

  plugins: [
    require('@tailwindcss/forms'),
    require('@tailwindcss/typography'),
    require('@tailwindcss/aspect-ratio'),
  ],
}
