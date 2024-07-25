<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ page.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-2 grid-cols-1 divide-x">
            <div class="p-2">
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        Страница&nbsp;{{ $props.page.name}}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center">
                        Ссылка&nbsp;{{ $props.page.slug}}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center">
                        Шаблон&nbsp;{{ $props.page.template}}
                    </div>

                    <div class="truncate sm:whitespace-normal flex items-center">
                        Родительская страница&nbsp;{{ $props.page.parent_id }}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center">
                        Заголовок&nbsp;{{ $props.page.title}}
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center">
                        Описание&nbsp;{{ $props.page.description}}
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

    <div class="mt-3 p-3 bg-white rounded-lg" v-html="$props.page.text">



    </div>
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
