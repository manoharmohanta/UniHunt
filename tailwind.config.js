/** @type {import('tailwindcss').Config} */
module.exports = {
  darkMode: "class",
  content: [
    "./app/Views/**/*.php",
    "./public/**/*.js"
  ],
  theme: {
    extend: {
      colors: {
        "primary": "rgb(var(--primary) / <alpha-value>)",
        "primary-hover": "#023a8f",
        "primary-soft": "#e6ebf4",

        "secondary": "rgb(var(--secondary) / <alpha-value>)",
        "secondary-hover": "#e23b55",
        "secondary-soft": "#fde8ec",

        "background-light": "rgb(var(--background) / <alpha-value>)",
        "background-dark": "rgb(var(--background) / <alpha-value>)",

        "card-light": "rgb(var(--surface) / <alpha-value>)",
        "card-dark": "rgb(var(--surface) / <alpha-value>)",

        "surface-light": "rgb(var(--surface) / <alpha-value>)",
        "surface-dark": "rgb(var(--surface) / <alpha-value>)",

        "text-main": "rgb(var(--text-main) / <alpha-value>)",
        "text-muted": "rgb(var(--text-muted) / <alpha-value>)",
        "text-secondary": "rgb(var(--text-muted) / <alpha-value>)",

        "border-light": "rgb(var(--border) / <alpha-value>)",
        "border-dark": "rgb(var(--border) / <alpha-value>)",

        "success": "#1b9c85",
        "warning": "#f0b429",
        "danger": "#d64545",
      },
      fontFamily: {
        "display": ["Manrope", "sans-serif"]
      },
      boxShadow: {
        "soft": "0 4px 20px -2px rgba(14, 117, 129, 0.08)",
        "card": "0 2px 8px -1px rgba(0, 0, 0, 0.05)",
      },
      borderRadius: {
        "DEFAULT": "0.25rem",
        "lg": "0.5rem",
        "xl": "0.75rem",
        "2xl": "1rem",
        "full": "9999px"
      },
    },
  },
  plugins: [
    require('@tailwindcss/typography'),
  ],
}
