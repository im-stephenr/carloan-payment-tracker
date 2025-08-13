import { defineConfig } from "vite";
import laravel from "laravel-vite-plugin";
import tailwindcss from "@tailwindcss/vite";
import vue from "@vitejs/plugin-vue"; // ADD THIS TO TELL VITE WE ARE USING VUE

export default defineConfig({
    plugins: [
        vue(), // ADD THIS TO TELL VITE WE ARE USING VUE
        laravel({
            input: ["resources/css/app.css", "resources/js/app.js"],
            refresh: true,
        }),
        tailwindcss(),
    ],
});
