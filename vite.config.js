import { defineConfig } from 'vite';
import vue from '@vitejs/plugin-vue'; // Thêm import cho plugin Vue
import laravel from 'laravel-vite-plugin';

export default defineConfig({
    plugins: [
        laravel(['resources/js/app.js']),
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                }
            }
        })
    ]
});
