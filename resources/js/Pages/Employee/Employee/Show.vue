<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ employee.fullname.surname + ' ' + employee.fullname.firstname + ' ' + employee.fullname.secondname }}  </h1>
    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            <div class="p-2">
                <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                        <el-image
                            style="width: 100px; height: 100px"
                            :src="$props.photo"
                            :zoom-rate="1.2"
                            :max-scale="7"
                            :min-scale="0.2"
                            :preview-src-list="[$props.photo]"
                            :initial-index="0"
                            fit="cover"
                        />
                    </div>
                    <div class="ml-5">
                        <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">
                            {{ employee.fullname.surname + ' ' + employee.fullname.firstname + ' ' + employee.fullname.secondname }}
                        </div>
                        <div class="text-slate-500">{{ '' }}</div>
                    </div>
                </div>
            </div>
            <div class="p-2">
                <h2 class="font-medium text-center lg:text-left lg:mt-3">Персональные данные</h2>
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center text-sm">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="user" class="lucide lucide-user stroke-1.5 w-4 h-4"><path d="M19 21v-2a4 4 0 0 0-4-4H9a4 4 0 0 0-4 4v2"></path><circle cx="12" cy="7" r="4"></circle></svg>
                        &nbsp;{{ }}
                    </div>

                    <div class="truncate sm:whitespace-normal flex items-center text-sm mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="phone" class="lucide lucide-phone stroke-1.5 w-4 h-4"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"></path></svg>
                        &nbsp;{{ employee.phone}}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center text-sm mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="send" class="lucide lucide-send stroke-1.5 w-4 h-4"><path d="m22 2-7 20-4-9-9-4Z"></path><path d="M22 2 11 13"></path></svg>
                        &nbsp;{{ employee.telegram_user_id }}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center text-sm mt-2">
                        <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="key-round" class="lucide lucide-key-round stroke-1.5 w-4 h-4"><path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"></path><circle cx="16.5" cy="7.5" r=".5"></circle></svg>
                        &nbsp;{{ employee.address.address }}
                    </div>
                </div>
            </div>
            <div class="p-2">
                <h2 class="font-medium">Специализация</h2>
                <div>
                </div>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
        </div>
    </div>
    <div class="mt-5 p-3 bg-white rounded-lg ">
        Dashboard Персонала - графики, клиенты, записи и т.п.
    </div>
</template>

<script>
    import { Head, Link, router } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'

    export default {
        components: {
            Head,
        },
        layout: Layout,
        props: {
            employee: Object,
            edit: String,
            photo: {
                type: String,
                default: null,
            },
            title: {
                type: String,
                default: 'Карточка Персонала',
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
