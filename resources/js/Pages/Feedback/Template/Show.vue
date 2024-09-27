<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ template.name }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid grid-cols-1 divide-x">
            <div class="p-4">
                <el-descriptions :column="2" border>
                    <el-descriptions-item label="Название">{{ template.name }}</el-descriptions-item>
                    <el-descriptions-item label="Цвет карточки">
                        {{ template.color }} <span class="py-2 px-4 ml-3"
                                                   :style="{ 'background-color': template.color }"></span>
                    </el-descriptions-item>
                    <el-descriptions-item label="Шаблон">
                        <span v-html="template.template"></span>
                    </el-descriptions-item>
                </el-descriptions>

            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="handleEdit()">Редактировать</el-button>
            <el-button v-if="!template.active" type="success" @click="handleToggle">Разблокировать
            </el-button>
            <el-button v-if="template.active" type="warning" @click="handleToggle">Заблокировать
            </el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
import {Head, router} from '@inertiajs/vue3'

const props = defineProps({
    template: Object,
    edit: String,
    title: {
        type: String,
        default: 'Карточка шаблона формы',
    },
});
function handleToggle() {
    router.post(route('admin.feedback.template.toggle', {template: props.template.id}));
}
function handleEdit() {
    router.get(route('admin.feedback.template.edit', {template: props.template.id}))
}
</script>

<style>

</style>
