import { createMemoryHistory, createRouter } from 'vue-router'
//import {routes} from '../core/routes'

import Index        from './components/Index.vue'
import NotFound     from './components/NotFound.vue'
import Welcome      from './components/Welcome.vue'
import Home         from './components/Home.vue'
import auth         from '../modules/admin/routes_auth'

// Load modules routes dynamically.
/*const requireContext = require.context('../modules', true, /routes\.js$/)

const modules = requireContext.keys()
    .map(file =>
        [file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)]
    )
*/
const requireContext = import.meta.glob('/resources/js/modules/*/routes.js', { eager: true })
let modules = Object.fromEntries(
    Object.entries(requireContext).map(([key, value]) => [key.match(/\/modules\/(.+)\/store\/store.js$/)[1], value.routes])
)


let moduleRoutes = []
console.log(modules);
/*
for(let i in modules) {
    moduleRoutes = moduleRoutes.concat(modules[i][1].routes)
}
*/
const  routes = [
    {
        path: '/admin',
        component: Home,
        meta: {auth: true},
        children: [
            ...moduleRoutes,
        ]
    },
    {
        path: '/',
        component: Welcome,
        children: [
            {
                path: '/',
                component: Index,
                name: 'index',
            },
            ...auth,
            {
                path: '*',
                component: NotFound,
                name: 'not_found'
            }
        ]
    },
]

export const router = createRouter({
    history: createMemoryHistory(),
    routes,
})


