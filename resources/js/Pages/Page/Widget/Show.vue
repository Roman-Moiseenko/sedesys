<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ widget.name }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-2 grid-cols-1 divide-x">
            <div class="p-2">
                <el-descriptions :column="1" border>
                    <el-descriptions-item label="Название">{{ widget.name }}</el-descriptions-item>
                    <el-descriptions-item label="Шаблон">{{ widget.template }}</el-descriptions-item>
                    <el-descriptions-item label="Модель">{{ widget.model }}</el-descriptions-item>
                    <el-descriptions-item label="Данные">{{ widget.data }}</el-descriptions-item>
                    <el-descriptions-item label="Опции">{{ widget.options }}</el-descriptions-item>
                </el-descriptions>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
        </div>
    </div>

    <div class="mt-3 p-3 bg-white rounded-lg" v-html="view">
    </div>

</template>

<script lang="ts" setup>
import {Head, Link, router} from '@inertiajs/vue3'

const props = defineProps({
    widget: Object,
    view: String,
    title: {
        type: String,
        default: 'Карточка виджета',
    }
})

function goEdit() {
    router.get(route('admin.page.widget.edit', {widget: props.widget.id}));
}


</script>

<style scoped>

</style>
