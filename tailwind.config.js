const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    purge: [
        './vendor/laravel/jetstream/**/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.vue',
    ],

    theme: {
        extend: {
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
            }
        },
    },

    variants: {
        opacity: ['responsive', 'hover', 'focus', 'disabled'],
        cursor: ['hover', 'focus', 'disabled'],
        extend: {
            backgroundColor: ['group-focus', 'active'],
            borderColor: ['group-focus'],
            boxShadow: ['group-focus'],
            opacity: ['group-focus'],
            textColor: ['group-focus', 'active'],
            textDecoration: ['group-focus'],
            fontWeight: ['hover', 'focus']
        }
    },

    plugins: [
        require('@tailwindcss/forms'),
        require('@tailwindcss/typography'),
        require('@tailwindcss/aspect-ratio'),
    ],
};
