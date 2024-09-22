import.meta.glob([
    '../images/**',
]);



import { createApp, h } from 'vue'
import { createInertiaApp } from '@inertiajs/vue3'
import { createPinia } from 'pinia'
import * as ElementPlusIconsVue from '@element-plus/icons-vue'
import 'dayjs/locale/ru';
import Layout from './Components/Layout.vue'
import DeleteEntityModal from  './Plugins/DeleteEntity'

const pinia = createPinia();

createInertiaApp({
    resolve: name => {
        const pages = import.meta.glob('./Pages/**/*.vue', { eager: true })

        let page = pages[`./Pages/${name}.vue`]
        //console.log(name)
        if (name !== 'Admin/Auth/Login' && name !== 'Base/404')
            page.default.layout = page.default.layout || Layout
        return page
        //return pages[`./Pages/${name}.vue`]
    },
    setup({ el, App, props, plugin }) {

        const app = createApp({ render: () => h(App, props) })
            .use(plugin)
            .use(pinia)
            .use(DeleteEntityModal);
        for (const [key, component] of Object.entries(ElementPlusIconsVue)) {
            app.component(key, component)
        }
        app.mount(el)
    },
})






