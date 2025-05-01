/** @type {import('tailwindcss').Config} */
module.exports = {
    content: ["./index.html", "./resources/**/*.{js,vue,php}"],
    theme: {
        extend: {
            colors: {
                "plutus-green": "#75EB78",
            }
        },
    },
    plugins: [],
};
