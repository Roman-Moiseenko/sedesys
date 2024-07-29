<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ widget.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            Данные
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
        </div>
    </div>

    <div class="mt-3 p-3 bg-white rounded-lg" v-html="view">
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
            widget: Object,
            view: String,
            edit: String,
            title: {
                type: String,
                default: 'Карточка виджета',
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
