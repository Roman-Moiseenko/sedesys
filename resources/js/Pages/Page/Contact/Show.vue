<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ contact.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid grid-cols-2 divide-x">
        <div class="p-2">
            <div class="truncate sm:whitespace-normal flex items-center">
                Название&nbsp;<span class="font-medium ml-6">{{ $props.contact.name}}</span>
            </div>
            <div class="truncate sm:whitespace-normal flex items-center mt-2">
                Описание при наведении курсора&nbsp;<span class="font-medium ml-6">{{ $props.contact.title}}</span>
            </div>
            <div class="truncate sm:whitespace-normal flex items-center mt-2">
                Иконка FontAwesome&nbsp;<span class="font-medium ml-6">{{ $props.contact.icon}}</span>
            </div>
            <div class="truncate sm:whitespace-normal flex items-center mt-2">
                Ссылка&nbsp;<span class="font-medium ml-6">{{ $props.contact.url}}</span>
            </div>
            <div class="truncate sm:whitespace-normal flex items-center mt-2">
                Цвет&nbsp;<span class="font-medium ml-6">{{ $props.contact.color}}
                <span class="w-4 h-4 p-5 ml-3" v-bind:style="{ 'background-color': $props.contact.color }"
            ></span></span>
            </div>
        </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.contact.active" type="success" @click="handleToggle">Опубликовать</el-button>
            <el-button v-if="$props.contact.active" type="warning" @click="handleToggle">В черновик</el-button>
        </div>
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
            contact: Object,
            edit: String,
            title: {
                type: String,
                default: 'Карточка контактных данных',
            },
            toggle: String,
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
