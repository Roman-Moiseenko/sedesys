import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'
import path from "path";


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
            '@': '/resources/js',
            "tailwind-config.js": path.resolve(__dirname, "./tailwind.config.js"),
        },
    },
    plugins: [
        vue({
            template: {
                transformAssetUrls: {
                    base: null,
                    includeAbsolute: false,
                },
            },
        }),
        laravel({
            input: [
                'resources/css/app.css',
                'resources/js/app.js',
                'resources/sass/web.scss',
                'resources/js/web.js',
                //'resources/sass/admin.scss',
            ],
            refresh: true,
        }),

        AutoImport({
            resolvers: [ElementPlusResolver()],
        }),
        Components({
            resolvers: [ElementPlusResolver()],
        }),
    ],
    publicDir: 'public',
});
