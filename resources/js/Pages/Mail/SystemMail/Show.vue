<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ mail.name }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            <div class="p-2">
                <div class="truncate sm:whitespace-normal flex items-center mt-2">
                    Служба&nbsp;<span class="font-medium ml-6">{{ mail.mailable }}</span>
                </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-2">
                    Заголовок&nbsp;<span class="font-medium ml-6">{{ mail.title }}</span>
                </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-2">
                    Получатель&nbsp;<span class="font-medium ml-6">{{ mail.user }}</span>
                </div>
                <div class="truncate sm:whitespace-normal flex items-center mt-2">
                    Отправлено&nbsp;<span class="font-medium ml-6">{{ mail.created_at }}</span>
                </div>
            </div>
            <div class="p-2">
                <div class="truncate sm:whitespace-normal items-center mt-2">
                    Вложения:&nbsp;
                    <div v-for="(item, index) in mail.attachments" class="ml-1 mt-1">
                        <span class="font-medium cursor-pointer" @click="download(item, index)" title="Скачать файл">{{ index }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div v-html="mail.content" class="mt-3 p-3 bg-white rounded-lg">
    </div>

</template>

<script lang="ts" setup>
import {Head, Link} from '@inertiajs/vue3'

const props = defineProps({
    mail: Object,
    edit: String,
    attachment: String,
    title: {
        type: String,
        default: 'Карточка systemMail',
    },
});

</script>
<script lang="ts">
import {router} from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'
import axios from "axios";

export default {
    layout: Layout,
    methods: {
        goEdit() {
            router.get(this.$props.edit);
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
