<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ classification.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            <div class="p-4">
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        Классификация&nbsp;<span class="font-medium ml-6">{{ $props.classification.name}}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Ссылка&nbsp;<span class="font-medium ml-6">{{ $props.classification.slug}}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Страница (H1)&nbsp;<span class="font-medium ml-6">{{ $props.classification.meta.h1}}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Заголовок&nbsp;<span class="font-medium ml-6">{{ $props.classification.meta.title}}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Описание&nbsp;<span class="font-medium ml-6">{{ $props.classification.meta.description}}</span>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <h2 class="font-medium mb-3">Изображение для каталога</h2>
                <div class="lg:w-56 lg:h-56 image-fit relative">
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
            <div class="p-4">
                <h2 class="font-medium mb-3">Иконка для меню</h2>
                <div class="lg:w-56 lg:h-56 image-fit relative">
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
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
        </div>
    </div>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <h2 class="font-medium text-lg mb-3">Услуги:</h2>
        *** список с переходом на услугу
    </div>

</template>

<script lang="ts" setup>
    import { Head, Link } from '@inertiajs/vue3'

    const props = defineProps({
        classification: Object,
        edit: String,
        title: {
            type: String,
            default: 'Карточка категории услуг',
        },
        image: String,
        icon: String,

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
