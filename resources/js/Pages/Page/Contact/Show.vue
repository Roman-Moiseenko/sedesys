<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ contact.name }} </h1>
    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid grid-cols-2 divide-x">
            <div class="p-2">
                <el-descriptions :column="1" border>
                    <el-descriptions-item label="Название">{{ contact.name }}</el-descriptions-item>
                    <el-descriptions-item label="Описание при наведении курсора">{{
                            contact.title
                        }}
                    </el-descriptions-item>
                    <el-descriptions-item label="Иконка FontAwesome">{{ contact.icon }}</el-descriptions-item>
                    <el-descriptions-item label="Ссылка">{{ contact.url }}</el-descriptions-item>
                    <el-descriptions-item label="Цвет">
                        {{ contact.color }} <span class="py-2 px-4 ml-3"
                                                  v-bind:style="{ 'background-color': contact.color }"></span>
                    </el-descriptions-item>
                </el-descriptions>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.contact.active" type="success" @click="handleToggle">Опубликовать</el-button>
            <el-button v-if="$props.contact.active" type="warning" @click="handleToggle">В черновик</el-button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {Head, router} from '@inertiajs/vue3'

const props = defineProps({
    contact: Object,
    title: {
        type: String,
        default: 'Карточка контактных данных',
    },
})
function goEdit() {
    router.get(route('admin.page.contact.edit', {contact: props.contact.id}));
}

function handleToggle(val) {
    router.post(route('admin.page.contact.toggle', {contact: props.contact.id}));
}
</script>

