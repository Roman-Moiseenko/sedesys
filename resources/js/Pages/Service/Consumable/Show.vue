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
                :consumable_id="consumable.id"
                :services="consumable.services"
                :out_services="out_services"
            />
        </el-tabs>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="handleEdit">Редактировать</el-button>
            <el-button v-if="!consumable.active" type="success" @click="handleToggle">В расчет услуг</el-button>
            <el-button v-if="consumable.active" type="warning" @click="handleToggle">Убрать из расчета</el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
import { Head, router } from '@inertiajs/vue3'
import CommonPanel from './Panels/Common.vue'
import ServicePanel from './Panels/Service.vue'

const props = defineProps({
    consumable: Object,
    title: {
        type: String,
        default: 'Карточка расходного материала',
    },
    out_services: Array,
});
function handleToggle() {
    router.post(route('admin.service.consumable.toggle', {consumable: props.consumable.id}));
}
function handleEdit() {
    router.get(route('admin.service.consumable.edit', {consumable: props.consumable.id}))
}
</script>

