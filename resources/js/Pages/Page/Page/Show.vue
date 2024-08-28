<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ page.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-6 grid-cols-1 divide-x">
            <div class="p-4 col-span-4">
                <el-descriptions :column="2" border>
                    <el-descriptions-item label="Страница">{{ page.name }}</el-descriptions-item>
                    <el-descriptions-item label="Ссылка">{{ page.slug }}</el-descriptions-item>
                    <el-descriptions-item label="Шаблон">{{ page.template }}</el-descriptions-item>
                    <el-descriptions-item label="Родительская страница">{{ parent }}</el-descriptions-item>
                </el-descriptions>
                <DisplayedShow :displayed="page" />
            </div>
            <div class="p-4 col-span-2 flex">
                <DisplayedImage :image="$props.image" :icon="$props.icon" />
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.page.active" type="success" @click="handleToggle">Опубликовать</el-button>
            <el-button v-if="$props.page.active" type="warning" @click="handleToggle">В черновик</el-button>
        </div>
    </div>

    <div class="mt-3 p-3 bg-white rounded-lg" v-html="$props.page.text"></div>
</template>

<script>
    import { Head, Link, router } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'
    import DisplayedShow from '@/Components/DisplayedShow.vue'
    import DisplayedImage from '@/Components/DisplayedImage.vue'

    export default {
        components: {
            Head,
            DisplayedShow,
            DisplayedImage
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
