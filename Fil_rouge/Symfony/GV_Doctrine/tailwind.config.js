/** @type {import('tailwindcss').Config} */
module.exports = {
  content: ["./assets/**/*.{js,ts,jsx,tsx}", "./templates/**/*.twig"],
  corePlugins: {
    preflight: false,
  },
  theme: {
    extend: {
      fontFamily: {
        title: ["Lato", "sans-serif"],
        body: ["Raleway", "sans-serif"],
        sans: ["Raleway", "sans-serif"],
      },
    },
  },
  plugins: [],
};
