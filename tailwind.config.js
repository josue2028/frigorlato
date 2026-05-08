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
                ivory: '#FDF8F0',
                bone: '#FFFDF8',
                charcoal: '#4A4A4A',
                brand: {
                    50: '#f8ebeb',
                    100: '#f1d6d7',
                    200: '#e2aeb0',
                    300: '#d38487',
                    400: '#c45a5e',
                    500: '#b43135',
                    600: '#900C0F',
                    700: '#7c0a0d',
                    800: '#67080b',
                    900: '#530609',
                },
                accent: {
                    50: '#fff7ef',
                    100: '#fde8cf',
                    200: '#f7c991',
                    300: '#eea853',
                    400: '#d58a34',
                    500: '#b96f1f',
                },
            },
            fontFamily: {
                sans: ['Manrope', ...defaultTheme.fontFamily.sans],
                display: ['Outfit', ...defaultTheme.fontFamily.sans],
            },
            boxShadow: {
                soft: '0 22px 56px rgba(144, 12, 15, 0.14)',
                panel: '0 18px 44px rgba(74, 74, 74, 0.10)',
            },
        },
    },

    plugins: [forms],
};
