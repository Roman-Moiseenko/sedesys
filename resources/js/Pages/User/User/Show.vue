<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">{{ user.fullname.surname + ' ' + user.fullname.firstname + ' ' + user.fullname.secondname}}</h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid grid-cols-1 divide-x">

            <div class="p-2">
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-4 h-4"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                        &nbsp;{{ user.email}}
                    </div>

                    <div class="truncate sm:whitespace-normal flex items-center text-sm mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="phone" class="lucide lucide-phone stroke-1.5 w-4 h-4"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        &nbsp;{{ user.phone}}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center text-sm mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-map w-4 h-4"><path d="M14.106 5.553a2 2 0 0 0 1.788 0l3.659-1.83A1 1 0 0 1 21 4.619v12.764a1 1 0 0 1-.553.894l-4.553 2.277a2 2 0 0 1-1.788 0l-4.212-2.106a2 2 0 0 0-1.788 0l-3.659 1.83A1 1 0 0 1 3 19.381V6.618a1 1 0 0 1 .553-.894l4.553-2.277a2 2 0 0 1 1.788 0z"/><path d="M15 5.764v15"/><path d="M9 3.236v15"/></svg>
                        &nbsp;{{ user.address.address }}
                    </div>
                </div>
            </div>

        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
        </div>
    </div>

    <div class="mt-5 p-3 bg-white rounded-lg ">
        Данные о заказах клиента
    </div>
</template>

<script>
    import {Head, Link, router} from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'

    export default {
        components: {
            Head,
        },
        layout: Layout,
        props: {
            user: Object,
            edit: String,
            title: {
                type: String,
                default: 'Карточка user',
            }
        },
        methods: {
            goEdit() {
                router.get(this.$props.edit);
            },
        },
    }

</script>

<style scoped>

</style>
