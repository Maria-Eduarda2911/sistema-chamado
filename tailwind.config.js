import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                'laravel-red': {
                    'light': '#ff8c8c',
                    'DEFAULT': '#f55247',
                    'dark': '#de3629',
                },
                'primary': defaultTheme.colors.indigo,
                'secondary': defaultTheme.colors.gray,
            }
        },
    },

    plugins: [forms],
};
