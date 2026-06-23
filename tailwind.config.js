import defaultTheme from 'tailwindcss/defaultTheme';
import forms from '@tailwindcss/forms';

/** @type {import('tailwindcss').Config} */
export default {
    content: [
        './resources/**/*.blade.php',
        './resources/**/*.js',
        './resources/**/*.vue',
    ],

    safelist: [
        'bg-emerald-500',
        'hover:bg-emerald-600',
        'bg-blue-500',
        'hover:bg-blue-600',
        'text-white',
        'rounded-lg',
        'px-3',
        'py-2',
        'text-xs',
        'font-medium',
        'transition',
    ],

    theme: {
        extend: {
            fontFamily: {
                sans: ['Figtree', ...defaultTheme.fontFamily.sans],
            },
        },
    },

    plugins: [forms],
};
