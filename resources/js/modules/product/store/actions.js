import * as types from './types'
import productApi from '../api'

export const actions = {
async [types.PRODUCT_FETCH]({commit}, data = null) {
commit(types.PRODUCT_SET_LOADING, true)
const response = await productApi.all(data)
commit(types.PRODUCT_OBTAIN, response.data.data)
commit(types.PRODUCT_META, response.data.meta)
commit(types.PRODUCT_SET_LOADING, false)
},
}
