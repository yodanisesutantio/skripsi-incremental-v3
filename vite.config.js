// vite.config.js
import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'], // Your input files
            refresh: true,
        }),
    ],
    base: '/kemudi2/', // Adjust based on your directory structure
});
