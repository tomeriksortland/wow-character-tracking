import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php',
        './storage/framework/views/*.php',
        './resources/views/**/*.blade.php',
        './resources/js/**/*.jsx',
    ],

    theme: {
        extend: {
            colors: {
                'battlenet': '#0074e0',
                'battlenet-dark': '#1a1c23',
                'battlenet-light': '#47a6ff',
                'death-knight': '#C41E3A',
                'demon-hunter': '#A330C9',
                'druid': '#FF7C0A',
                'evoker': '#33937F',
                'hunter': '#AAD372',
                'mage': '#3FC7EB',
                'monk': '#00DD98',
                'paladin': '#F48CBA',
                'priest': '#FFFFFF',
                'rogue': '#FFF468',
                'shaman': '#0080DD',
                'warlock': '#8788EE',
                'warrior': '#C69B6D'
            },
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [
        forms,
        require("daisyui")
    ],
};
