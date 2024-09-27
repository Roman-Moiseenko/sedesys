// vite.config.js
import { defineConfig } from "file:///C:/Server/localhost/sedesys/node_modules/vite/dist/node/index.js";
import laravel from "file:///C:/Server/localhost/sedesys/node_modules/laravel-vite-plugin/dist/index.js";
import vue from "file:///C:/Server/localhost/sedesys/node_modules/@vitejs/plugin-vue/dist/index.mjs";
import Icons from "file:///C:/Server/localhost/sedesys/node_modules/unplugin-icons/dist/vite.js";
import IconsResolver from "file:///C:/Server/localhost/sedesys/node_modules/unplugin-icons/dist/resolver.js";
import AutoImport from "file:///C:/Server/localhost/sedesys/node_modules/unplugin-auto-import/dist/vite.js";
import Components from "file:///C:/Server/localhost/sedesys/node_modules/unplugin-vue-components/dist/vite.js";
import { ElementPlusResolver } from "file:///C:/Server/localhost/sedesys/node_modules/unplugin-vue-components/dist/resolvers.js";
import path from "path";
var __vite_injected_original_dirname = "C:\\Server\\localhost\\sedesys";
var vite_config_default = defineConfig({
  build: {
    commonjsOptions: {
      include: ["tailwind.config.js", "node_modules/**"]
    },
    chunkSizeWarningLimit: 1600
  },
  optimizeDeps: {
    include: ["tailwind-config"]
  },
  resolve: {
    alias: {
      "@": "/resources/js",
      "tailwind-config.js": path.resolve(__vite_injected_original_dirname, "./tailwind.config.js"),
      "$": "jQuery"
    }
  },
  plugins: [
    vue({
      template: {
        transformAssetUrls: {
          base: null,
          includeAbsolute: false
        }
      }
    }),
    laravel({
      input: [
        "resources/sass/app.scss",
        //'resources/css/app.css',
        "resources/js/app.js",
        "resources/sass/web.scss",
        "resources/js/web.js",
        "resources/js/_frontend.js"
        //'resources/sass/admin.scss',
      ],
      refresh: true
    }),
    AutoImport({
      resolvers: [
        ElementPlusResolver(),
        IconsResolver({
          prefix: "Icon"
        })
      ]
    }),
    Components({
      resolvers: [
        ElementPlusResolver(),
        IconsResolver({
          enabledCollections: ["ep"]
        })
      ]
    }),
    Icons({
      autoInstall: true
    })
  ],
  publicDir: "public"
});
export {
  vite_config_default as default
};
//# sourceMappingURL=data:application/json;base64,ewogICJ2ZXJzaW9uIjogMywKICAic291cmNlcyI6IFsidml0ZS5jb25maWcuanMiXSwKICAic291cmNlc0NvbnRlbnQiOiBbImNvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9kaXJuYW1lID0gXCJDOlxcXFxTZXJ2ZXJcXFxcbG9jYWxob3N0XFxcXHNlZGVzeXNcIjtjb25zdCBfX3ZpdGVfaW5qZWN0ZWRfb3JpZ2luYWxfZmlsZW5hbWUgPSBcIkM6XFxcXFNlcnZlclxcXFxsb2NhbGhvc3RcXFxcc2VkZXN5c1xcXFx2aXRlLmNvbmZpZy5qc1wiO2NvbnN0IF9fdml0ZV9pbmplY3RlZF9vcmlnaW5hbF9pbXBvcnRfbWV0YV91cmwgPSBcImZpbGU6Ly8vQzovU2VydmVyL2xvY2FsaG9zdC9zZWRlc3lzL3ZpdGUuY29uZmlnLmpzXCI7aW1wb3J0IHsgZGVmaW5lQ29uZmlnIH0gZnJvbSAndml0ZSc7XG5pbXBvcnQgbGFyYXZlbCBmcm9tICdsYXJhdmVsLXZpdGUtcGx1Z2luJztcbmltcG9ydCB2dWUgZnJvbSAnQHZpdGVqcy9wbHVnaW4tdnVlJztcblxuaW1wb3J0IEljb25zIGZyb20gJ3VucGx1Z2luLWljb25zL3ZpdGUnXG5pbXBvcnQgSWNvbnNSZXNvbHZlciBmcm9tICd1bnBsdWdpbi1pY29ucy9yZXNvbHZlcidcbmltcG9ydCBBdXRvSW1wb3J0IGZyb20gJ3VucGx1Z2luLWF1dG8taW1wb3J0L3ZpdGUnXG5pbXBvcnQgQ29tcG9uZW50cyBmcm9tICd1bnBsdWdpbi12dWUtY29tcG9uZW50cy92aXRlJ1xuaW1wb3J0IHsgRWxlbWVudFBsdXNSZXNvbHZlciB9IGZyb20gJ3VucGx1Z2luLXZ1ZS1jb21wb25lbnRzL3Jlc29sdmVycydcbmltcG9ydCBwYXRoIGZyb20gXCJwYXRoXCI7XG5cbi8vY29uc3QgcGF0aFNyYyA9IHBhdGgucmVzb2x2ZShfX2Rpcm5hbWUsICdzcmMnKVxuXG5leHBvcnQgZGVmYXVsdCBkZWZpbmVDb25maWcoe1xuICAgIGJ1aWxkOiB7XG4gICAgICAgIGNvbW1vbmpzT3B0aW9uczoge1xuICAgICAgICAgICAgaW5jbHVkZTogW1widGFpbHdpbmQuY29uZmlnLmpzXCIsIFwibm9kZV9tb2R1bGVzLyoqXCJdLFxuICAgICAgICB9LFxuICAgICAgICBjaHVua1NpemVXYXJuaW5nTGltaXQ6IDE2MDAsXG4gICAgfSxcbiAgICBvcHRpbWl6ZURlcHM6IHtcbiAgICAgICAgaW5jbHVkZTogW1widGFpbHdpbmQtY29uZmlnXCJdLFxuICAgIH0sXG4gICAgcmVzb2x2ZToge1xuICAgICAgICBhbGlhczoge1xuICAgICAgICAgICAgJ0AnOiAnL3Jlc291cmNlcy9qcycsXG4gICAgICAgICAgICBcInRhaWx3aW5kLWNvbmZpZy5qc1wiOiBwYXRoLnJlc29sdmUoX19kaXJuYW1lLCBcIi4vdGFpbHdpbmQuY29uZmlnLmpzXCIpLFxuICAgICAgICAgICAgJyQnOiAnalF1ZXJ5JyxcbiAgICAgICAgfSxcbiAgICB9LFxuICAgIHBsdWdpbnM6IFtcbiAgICAgICAgdnVlKHtcbiAgICAgICAgICAgIHRlbXBsYXRlOiB7XG4gICAgICAgICAgICAgICAgdHJhbnNmb3JtQXNzZXRVcmxzOiB7XG4gICAgICAgICAgICAgICAgICAgIGJhc2U6IG51bGwsXG4gICAgICAgICAgICAgICAgICAgIGluY2x1ZGVBYnNvbHV0ZTogZmFsc2UsXG4gICAgICAgICAgICAgICAgfSxcbiAgICAgICAgICAgIH0sXG4gICAgICAgIH0pLFxuICAgICAgICBsYXJhdmVsKHtcbiAgICAgICAgICAgIGlucHV0OiBbXG4gICAgICAgICAgICAgICAgJ3Jlc291cmNlcy9zYXNzL2FwcC5zY3NzJyxcbiAgICAgICAgICAgICAgICAvLydyZXNvdXJjZXMvY3NzL2FwcC5jc3MnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvYXBwLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL3Nhc3Mvd2ViLnNjc3MnLFxuICAgICAgICAgICAgICAgICdyZXNvdXJjZXMvanMvd2ViLmpzJyxcbiAgICAgICAgICAgICAgICAncmVzb3VyY2VzL2pzL19mcm9udGVuZC5qcycsXG4gICAgICAgICAgICAgICAgLy8ncmVzb3VyY2VzL3Nhc3MvYWRtaW4uc2NzcycsXG4gICAgICAgICAgICBdLFxuICAgICAgICAgICAgcmVmcmVzaDogdHJ1ZSxcbiAgICAgICAgfSksXG5cbiAgICAgICAgQXV0b0ltcG9ydCh7XG4gICAgICAgICAgICByZXNvbHZlcnM6IFtcbiAgICAgICAgICAgICAgICBFbGVtZW50UGx1c1Jlc29sdmVyKCksXG4gICAgICAgICAgICAgICAgSWNvbnNSZXNvbHZlcih7XG4gICAgICAgICAgICAgICAgICAgIHByZWZpeDogJ0ljb24nLFxuICAgICAgICAgICAgICAgIH0pLFxuICAgICAgICAgICAgXSxcbiAgICAgICAgfSksXG4gICAgICAgIENvbXBvbmVudHMoe1xuICAgICAgICAgICAgcmVzb2x2ZXJzOiBbXG4gICAgICAgICAgICAgICAgRWxlbWVudFBsdXNSZXNvbHZlcigpLFxuICAgICAgICAgICAgICAgIEljb25zUmVzb2x2ZXIoe1xuICAgICAgICAgICAgICAgICAgICBlbmFibGVkQ29sbGVjdGlvbnM6IFsnZXAnXSxcbiAgICAgICAgICAgICAgICB9KSxcbiAgICAgICAgICAgIF0sXG5cbiAgICAgICAgfSksXG4gICAgICAgIEljb25zKHtcbiAgICAgICAgICAgIGF1dG9JbnN0YWxsOiB0cnVlLFxuICAgICAgICB9KSxcbiAgICBdLFxuICAgIHB1YmxpY0RpcjogJ3B1YmxpYycsXG59KTtcbiJdLAogICJtYXBwaW5ncyI6ICI7QUFBMlEsU0FBUyxvQkFBb0I7QUFDeFMsT0FBTyxhQUFhO0FBQ3BCLE9BQU8sU0FBUztBQUVoQixPQUFPLFdBQVc7QUFDbEIsT0FBTyxtQkFBbUI7QUFDMUIsT0FBTyxnQkFBZ0I7QUFDdkIsT0FBTyxnQkFBZ0I7QUFDdkIsU0FBUywyQkFBMkI7QUFDcEMsT0FBTyxVQUFVO0FBVGpCLElBQU0sbUNBQW1DO0FBYXpDLElBQU8sc0JBQVEsYUFBYTtBQUFBLEVBQ3hCLE9BQU87QUFBQSxJQUNILGlCQUFpQjtBQUFBLE1BQ2IsU0FBUyxDQUFDLHNCQUFzQixpQkFBaUI7QUFBQSxJQUNyRDtBQUFBLElBQ0EsdUJBQXVCO0FBQUEsRUFDM0I7QUFBQSxFQUNBLGNBQWM7QUFBQSxJQUNWLFNBQVMsQ0FBQyxpQkFBaUI7QUFBQSxFQUMvQjtBQUFBLEVBQ0EsU0FBUztBQUFBLElBQ0wsT0FBTztBQUFBLE1BQ0gsS0FBSztBQUFBLE1BQ0wsc0JBQXNCLEtBQUssUUFBUSxrQ0FBVyxzQkFBc0I7QUFBQSxNQUNwRSxLQUFLO0FBQUEsSUFDVDtBQUFBLEVBQ0o7QUFBQSxFQUNBLFNBQVM7QUFBQSxJQUNMLElBQUk7QUFBQSxNQUNBLFVBQVU7QUFBQSxRQUNOLG9CQUFvQjtBQUFBLFVBQ2hCLE1BQU07QUFBQSxVQUNOLGlCQUFpQjtBQUFBLFFBQ3JCO0FBQUEsTUFDSjtBQUFBLElBQ0osQ0FBQztBQUFBLElBQ0QsUUFBUTtBQUFBLE1BQ0osT0FBTztBQUFBLFFBQ0g7QUFBQTtBQUFBLFFBRUE7QUFBQSxRQUNBO0FBQUEsUUFDQTtBQUFBLFFBQ0E7QUFBQTtBQUFBLE1BRUo7QUFBQSxNQUNBLFNBQVM7QUFBQSxJQUNiLENBQUM7QUFBQSxJQUVELFdBQVc7QUFBQSxNQUNQLFdBQVc7QUFBQSxRQUNQLG9CQUFvQjtBQUFBLFFBQ3BCLGNBQWM7QUFBQSxVQUNWLFFBQVE7QUFBQSxRQUNaLENBQUM7QUFBQSxNQUNMO0FBQUEsSUFDSixDQUFDO0FBQUEsSUFDRCxXQUFXO0FBQUEsTUFDUCxXQUFXO0FBQUEsUUFDUCxvQkFBb0I7QUFBQSxRQUNwQixjQUFjO0FBQUEsVUFDVixvQkFBb0IsQ0FBQyxJQUFJO0FBQUEsUUFDN0IsQ0FBQztBQUFBLE1BQ0w7QUFBQSxJQUVKLENBQUM7QUFBQSxJQUNELE1BQU07QUFBQSxNQUNGLGFBQWE7QUFBQSxJQUNqQixDQUFDO0FBQUEsRUFDTDtBQUFBLEVBQ0EsV0FBVztBQUNmLENBQUM7IiwKICAibmFtZXMiOiBbXQp9Cg==
