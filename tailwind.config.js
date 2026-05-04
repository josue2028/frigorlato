import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.js',
    ],

    theme: {
        extend: {
            colors: {
                ivory: '#F5F5DC',
                bone: '#FFF8E7',
                brand: {
                    50: '#fef2f2',
                    100: '#fde8e8',
                    200: '#fbd5d5',
                    300: '#f8b4b4',
                    400: '#f98080',
                    500: '#f05252',
                    600: '#e02424',
                    700: '#c81e1e',
                    800: '#B22222',
                    900: '#8B0000',
                },
            },
            fontFamily: {
                sans: ['Instrument Sans', ...defaultTheme.fontFamily.sans],
                display: ['Bricolage Grotesque', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                soft: '0 10px 30px rgba(139, 0, 0, 0.08)',
            },
        },
    },

    plugins: [forms],
};
