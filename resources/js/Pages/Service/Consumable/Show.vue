<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ consumable.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-tabs type="border-card" class="">
            <!-- Панель Общая информация -->
            <CommonPanel
                :consumable="consumable"
            />
            <ServicePanel
                :services="consumable.services"
                :attach="consumable.attach"
                :detach="consumable.detach"
                :out_services="out_services"
            />
        </el-tabs>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="router.get(consumable.edit)">Редактировать</el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
    import { Head, Link, router } from '@inertiajs/vue3'
    import CommonPanel from './Panels/Common.vue'
    import ServicePanel from './Panels/Service.vue'

    const props = defineProps({
        consumable: Object,
        edit: String,
        title: {
            type: String,
            default: 'Карточка расходного материала',
        },
        out_services: Array,
    });

</script>
<script lang="ts">
    import { router } from '@inertiajs/vue3'

    export default {

        methods: {
            goEdit() {
                router.get(this.$props.consumable.edit);
            },
        },
    }

</script>

<style>

</style>
