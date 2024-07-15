import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'



export default defineConfig({
    build: {
        commonjsOptions: {
            include: ["tailwind.config.js", "node_modules/**"],
        },
        chunkSizeWarningLimit: 1600,
    },
    optimizeDeps: {
        include: ["tailwind-config"],
    },
    resolve: {
        alias: {
            '@': '/resources/ts',
        },
    },
    plugins: [
        vue(),
        laravel({
            input: ['resources/css/app.css', 'resources/js/app.js'],
            refresh: true,
        }),

        AutoImport({
            resolvers: [ElementPlusResolver()],
        }),
        Components({
            resolvers: [ElementPlusResolver()],
        }),
    ],
});
