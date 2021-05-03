const defaultTheme = require('tailwindcss/defaultTheme');

module.exports = {
    // mode: 'jit',
    purge: [
        './resources/views/**/*.blade.php',
        './resources/views/*.blade.php',
        './resources/js/**/*.vue',
        './resources/js/*.vue'
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Nunito', ...defaultTheme.fontFamily.sans],
            },
            animation: {
                'pulse': 'pulse 2s cubic-bezier(0.4, 0, 0.6, 1) 5;',
            }
        },
    },

    variants: {
        extend: {
            opacity: ['disabled'],
        },
        display: ['group-hover']
    },

    plugins: [require('@tailwindcss/forms'), require('@tailwindcss/typography')],
};
