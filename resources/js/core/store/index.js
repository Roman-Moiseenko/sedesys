//import { createApp } from 'vue'
import { createStore } from 'vuex'
import {store as core} from './store'

const requireContext = import.meta.glob('/resources/js/modules/*/store/store.js', { eager: true })
let modules = Object.fromEntries(
    Object.entries(requireContext).map(([key, value]) => [key.match(/\/modules\/(.+)\/store\/store.js$/)[1], value.store])
)
modules = {...modules, core}
export default createStore(modules);

//    require.context('../../modules', true, /store\.js$/)
//console.log(requireContext);


/*
let modules = requireContext.keys()
    .map(file =>
        [file.replace(/(^.\/)|(\.js$)/g, ''), requireContext(file)]
    )
    .reduce((modules, [path, module]) => {
        let name = path.split('/')[0]
        return { ...modules, [name]: module.store }
    }, {})
*/

//console.log(modules);



/*
export default new Vuex.Store({
    modules
})*/
