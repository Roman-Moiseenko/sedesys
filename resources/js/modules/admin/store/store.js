import * as types from './types'

export const store = {
    state: {
        isAuth: false,
        isTest: true,
    },
    mutations: {
        SET_AUTH: (state, isAuth) => {
            state.isAuth = isAuth
        },
    }
}
