import {defineStore} from 'pinia'
export const useStore = defineStore('table_data', {
    state: () => ({
        loading: false,
    }),
    getters: {
        getLoading: (state) => state.loading,
    },
    actions: {
        beforeLoad() {
            this.loading = true;
        },
        afterLoad() {
            this.loading = false;
        }
    },
})
