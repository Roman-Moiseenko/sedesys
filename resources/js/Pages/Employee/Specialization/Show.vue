<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ specialization.name }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            <div class="p-4">
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <el-descriptions :column="1" border>
                        <el-descriptions-item label="Специализация">{{ specialization.name }}</el-descriptions-item>
                        <el-descriptions-item label="Ссылка">{{ specialization.slug }}</el-descriptions-item>
                        <el-descriptions-item label="Страница (H1)">{{ specialization.meta.h1 }}</el-descriptions-item>
                        <el-descriptions-item label="Заголовок">{{ specialization.meta.title }}</el-descriptions-item>
                        <el-descriptions-item label="Описание">{{ specialization.meta.description }}</el-descriptions-item>
                        <el-descriptions-item label="Font Awesome">{{ specialization.awesome }}</el-descriptions-item>
                    </el-descriptions>
                </div>
            </div>
            <div class="p-4 flex justify-between">
                <div>
                    <h2 class="font-medium mb-3">Изображение для каталога</h2>
                    <div class="lg:w-48 lg:h-48 image-fit relative">
                        <el-image
                            :src="$props.image"
                            :zoom-rate="1.2"
                            :max-scale="3"
                            :min-scale="0.2"
                            :preview-src-list="[$props.image]"
                            :initial-index="0"
                            fit="cover"
                        />
                    </div>
                </div>
                <div>
                    <h2 class="font-medium mb-3">Иконка для меню</h2>
                    <div class="lg:w-48 lg:h-48 image-fit relative">
                        <el-image
                            :src="$props.icon"
                            :zoom-rate="1.2"
                            :max-scale="1"
                            :min-scale="0.2"
                            :preview-src-list="[$props.icon]"
                            :initial-index="0"
                            fit="cover"
                        />
                    </div>
                </div>
            </div>
            <div class="p-4">
                <h2 class="font-medium text-lg mb-3">Специалисты:</h2>
                <div v-for="item in $props.specialization.employees">
                    {{ item.fullname.surname }} {{ item.fullname.firstname }} {{ item.fullname.secondname }}
                </div>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.specialization.active" type="success" @click="handleToggle">Показывать в
                меню/каталогах
            </el-button>
            <el-button v-if="$props.specialization.active" type="warning" @click="handleToggle">Скрыть из показа
            </el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
import {Head, Link, router} from '@inertiajs/vue3'
import {reactive} from "vue";

const props = defineProps({
    specialization: Object,
    edit: String,
    title: {
        type: String,
        default: 'Карточка специализации',
    },
    toggle: String,
    attach: String,
    image: String,
    icon: String,
});

</script>
<script lang="ts">
import {router} from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'

export default {
    layout: Layout,
    methods: {
        goEdit() {
            router.get(this.$props.edit);
        },
        handleToggle(val) {
            router.post(this.$props.toggle);
        }
    },
}

</script>

<style>

</style>
