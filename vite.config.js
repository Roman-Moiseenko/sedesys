import { defineConfig } from 'vite';
import laravel from 'laravel-vite-plugin';
import vue from '@vitejs/plugin-vue';

import Icons from 'unplugin-icons/vite'
import IconsResolver from 'unplugin-icons/resolver'
import AutoImport from 'unplugin-auto-import/vite'
import Components from 'unplugin-vue-components/vite'
import { ElementPlusResolver } from 'unplugin-vue-components/resolvers'
import path from "path";

//const pathSrc = path.resolve(__dirname, 'src')

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
            '$': 'jQuery',
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
                'resources/sass/app.scss',
                //'resources/css/app.css',
                'resources/js/app.js',
                'resources/sass/web.scss',
                'resources/js/web.js',
                'resources/js/_frontend.js',
                //'resources/sass/admin.scss',
            ],
            refresh: true,
        }),

        AutoImport({
            resolvers: [
                ElementPlusResolver(),
                IconsResolver({
                    prefix: 'Icon',
                }),
            ],
        }),
        Components({
            resolvers: [
                ElementPlusResolver(),
                IconsResolver({
                    enabledCollections: ['ep'],
                }),
            ],

        }),
        Icons({
            autoInstall: true,
        }),
    ],
    publicDir: 'public',
});
