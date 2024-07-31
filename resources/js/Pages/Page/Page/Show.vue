<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ page.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-2 grid-cols-1 divide-x">
            <div class="p-2">
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        Страница&nbsp;<span class="font-medium ml-6">{{ $props.page.name}}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Ссылка&nbsp;<span class="font-medium ml-6">{{ $props.page.slug}}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Шаблон&nbsp;<span class="font-medium ml-6">{{ $props.page.template}}</span>
                    </div>

                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Родительская страница&nbsp;<span class="font-medium ml-6">{{ $props.parent }}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Заголовок&nbsp;<span class="font-medium ml-6">{{ $props.page.title}}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Описание&nbsp;<span class="font-medium ml-6">{{ $props.page.description}}</span>
                    </div>
                </div>
            </div>
            <div class="p-2">
                <div class="lg:w-56 lg:h-56 image-fit relative">
                    <el-image
                        :src="$props.photo"
                        :zoom-rate="1.2"
                        :max-scale="7"
                        :min-scale="0.2"
                        :preview-src-list="[$props.photo]"
                        :initial-index="0"
                        fit="cover"
                    />
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
            photo: {
                type: String,
                default: null,
            },
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
