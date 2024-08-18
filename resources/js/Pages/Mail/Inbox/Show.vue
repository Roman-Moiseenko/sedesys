<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> Письмо от {{ $props.inbox.from }} < {{ $props.inbox.email }} >  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            <div class="p-2">
                <div class="font-medium">От кого:</div>
                <div class="ml-2">{{ $props.inbox.from }}</div>
                <div class="ml-2">{{ $props.inbox.email }}</div>
                <div class="font-medium mt-1">Тема:</div>
                <div class="">{{ $props.inbox.subject }}</div>
            </div>
            <div class="p-2">
                <div>
                    <span class="font-medium">Получено:</span> <span>{{ $props.inbox.created_at }}</span>
                </div>
                <div class="mt-2">
                    <span class="font-medium">Прочитано:</span> <span
                    v-if="$props.inbox.read">{{ $props.inbox.read_at }}</span>
                </div>
            </div>
            <div class="p-2">
                <div class="font-medium mb-2">Вложенные файлы:</div>
                <div v-for="(item, index) in $props.inbox.attachments" class="ml-1 mt-1">
                    <span class="font-medium cursor-pointer" @click="download(item, index)" title="Скачать файл">{{ index }}</span>
                </div>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goReply">Ответить</el-button>
        </div>
    </div>

    <h2 class="mt-3 font-medium">Письмо:</h2>
    <div class="mt-1 p-3 bg-white rounded-lg" v-html="$props.inbox.message">
    </div>

</template>

<script lang="ts" setup>
    import { Head, Link } from '@inertiajs/vue3'

    const props = defineProps({
        inbox: Object,
        edit: String,
        title: {
            type: String,
            default: 'Входящее письмо',
        },
        reply: String,
        attachment: String,

    });

</script>
<script lang="ts">
    import { router } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'
    import axios from "axios";

    export default {
        layout: Layout,
        methods: {
            goReply() {
                router.get(this.$props.reply);
            },
            download(file, name) {
                axios.get(this.$props.attachment,
                    {responseType: 'arraybuffer', params: {file: file}}
                ).then(res=>{
                    let blob = new Blob([res.data], {type:'application/*'})
                    let link = document.createElement('a')
                    link.href = window.URL.createObjectURL(blob)
                    link.download = name
                    link._target = 'blank'
                    link.click();
                })
            },
        },
    }

</script>

<style>

</style>
