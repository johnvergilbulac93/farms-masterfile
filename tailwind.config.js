const defaultTheme = require("tailwindcss/defaultTheme");

/** @type {import('tailwindcss').Config} */
module.exports = {
    content: [
        "./vendor/laravel/framework/src/Illuminate/Pagination/resources/views/*.blade.php",
        "./storage/framework/views/*.php",
        "./resources/views/**/*.blade.php",
        "./resources/js/**/*.vue",
    ],

    theme: {
        extend: {
            fontFamily: {
                // sans: ['Nunito', ...defaultTheme.fontFamily.sans],
                roboto: ["Roboto", "sans-serif"],
            },
        },
        // screens: {
        //     xs: "360px",
        //     sm: "540px",
        //     md: "720px",
        //     lg: "960px",
        //     xl: "1140px",
        // },
    },

    plugins: [require("@tailwindcss/forms")],
};
