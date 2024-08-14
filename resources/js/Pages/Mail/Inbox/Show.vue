<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ inbox.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            Данные
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
    import { Head, Link } from '@inertiajs/vue3'

    const props = defineProps({
        inbox: Object,
        edit: String,
        title: {
            type: String,
            default: 'Карточка inbox',
        },
        /**
         * Задать props
         */
    });

    /**
     * Методы
     */


</script>
<script lang="ts">
    import { router } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'

    export default {
        layout: Layout,
        methods: {
            goEdit() {
                router.get(this.$props.edit);
            },
        },
    }

</script>

<style>

</style>
