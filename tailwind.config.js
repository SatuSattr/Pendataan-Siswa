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
                sans: ['"Plus Jakarta Sans"', ...defaultTheme.fontFamily.sans],
            },
            colors: {
                brand: {
                    50: '#ebf8ff',
                    100: '#d5efff',
                    200: '#a7dfff',
                    300: '#77ccff',
                    400: '#45b2f5',
                    500: '#1f9ae6',
                    600: '#0f7fc6',
                    700: '#0f659f',
                    800: '#0f4f7d',
                    900: '#0d3b5e',
                },
            },
        },
    },

    plugins: [forms],
};
