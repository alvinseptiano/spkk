/** @type {import('tailwindcss').Config} */
export default {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./src/**/*.{vue,js,ts,jsx,tsx}",
        // './resources/**/*.blade.php',
        // './resources/**/*.js',
        // './resources/**/*.vue',
    ],
    theme: {
        extend: {},
    },
    daisyui: {
        themes: ["light", "dark", "valentine", "lemonade", "coffee"],
    },
    plugins: [require("daisyui")],
};
