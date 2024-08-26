<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ page.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-2 grid-cols-1 divide-x">
            <div class="p-4">
                <el-descriptions :column="1" border>
                    <el-descriptions-item label="Страница">{{ page.name }}</el-descriptions-item>
                    <el-descriptions-item label="Ссылка">{{ page.slug }}</el-descriptions-item>
                    <el-descriptions-item label="Шаблон">{{ page.template }}</el-descriptions-item>
                    <el-descriptions-item label="Родительская страница">{{ parent }}</el-descriptions-item>
                    <el-descriptions-item label="Страница (H1)">{{ page.meta.h1 }}</el-descriptions-item>
                    <el-descriptions-item label="Заголовок">{{ page.meta.title }}</el-descriptions-item>
                    <el-descriptions-item label="Описание">{{ page.meta.description }}</el-descriptions-item>
                </el-descriptions>

            </div>
            <div class="p-4 flex">
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
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.page.published" type="success" @click="handleToggle">Опубликовать</el-button>
            <el-button v-if="$props.page.published" type="warning" @click="handleToggle">В черновик</el-button>
        </div>
    </div>

    <div class="mt-3 p-3 bg-white rounded-lg" v-html="$props.page.text"></div>
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
            page: Object,
            edit: String,
            toggle: String,
            title: {
                type: String,
                default: 'Карточка Страницы',
            },
            image: String,
            icon: String,
            parent: String
        },
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

<style scoped>

</style>
