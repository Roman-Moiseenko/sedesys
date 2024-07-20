import {defineStore} from 'pinia'
export const useStore = defineStore('table_data', {
    state: () => ({
        loading: false,
    }),
    getters: {
        //doubleCount: (state) => state.count * 2,
    },
    actions: {
        load() {
            this.loading = true;
        },
        stop() {
            this.loading = false;
        }
    },
})
