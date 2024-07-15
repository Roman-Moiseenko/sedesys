/*import './bootstrap';*/

import {createApp} from 'vue'
import App from './core/App.vue'
import {router} from './core/routes'
import store from './core/store';
import ElementPlus from 'element-plus'

//Vue.use(ElementUI, {i18n: (key, value) => i18n.t(key, value)})
//createApp.prototype.config = window.config


const app = createApp(App).use(store).use(router).use(ElementPlus).mount("#app")
 //   .use(store)

