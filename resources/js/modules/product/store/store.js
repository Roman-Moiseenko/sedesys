import * as types from './types'
import {actions} from './actions'

export const store = {
state: {
products: [],
productsMeta: [],
productsLoading: true,
},
getters: {
products: state => state.products,
productsMeta: state => state.productsMeta,
productsLoading: state => state.productsLoading,
},
mutations: {
[types.PRODUCT_OBTAIN](state, products) {
state.products = products
},
[types.PRODUCT_CLEAR](state) {
state.products = []
},
[types.PRODUCT_SET_LOADING](state, loading) {
state.productsLoading = loading
},
[types.PRODUCT_META](state, meta) {
state.productsMeta = meta
},
},
actions
}
