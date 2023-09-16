/** @type {import('tailwindcss').Config} */
module.exports = {
  content: [
    "./assets/**/*.js",
    "./templates/**/*.html.twig",
  ],
  theme: {
    screens: {
      xs: "380px",
      sm: "640px",
      md: "768px",
      lg: "1024px",
      xl: "1280px",
      "2xl": "1536px",
      "3xl": "1920px",
    },
    extend: {
      colors: {
        primary: "#E43371",
        dark: "#292D35",
        'gray-1':'#3A3A49',
        'gray-2':'#7B809A',
        green:'#53C22B',
        "neutral-1": "#191919",
        "neutral-2": "#313131",
        "neutral-3": "#474747",
        "neutral-4": "#5A5A5A",
        "neutral-5": "#737373",
        "neutral-6": "#9E9E9E",
        "neutral-7": "#BCBCBC",
        "neutral-8": "#CCCCCC",
        "neutral-9": "#DDDDDD",
        "neutral-10": "#ECECEC",
        "neutral-11": "#F6F6F6",
        "neutral-12": "#FFFFFF",
      },
    },
    container: {
      center: true,
      padding: {
        DEFAULT: "1rem",
        sm: "1rem",
        lg: "1.5rem",
        xl: "2rem",
        "2xl": "2rem",
      },
    },
  },
  plugins: [],
}
