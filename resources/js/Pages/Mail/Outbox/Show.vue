<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ outbox.name }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            <div class="p-2">
                <div class="font-medium">Получатели:</div>
                <div v-for="item in $props.outbox.emails">{{ item }}</div>
                <div class="font-medium mt-1">Тема:</div>
                <div class="">{{ $props.outbox.subject }}</div>
            </div>
            <div class="p-2">
                <div>
                    <span class="font-medium">Создано:</span> <span>{{ $props.outbox.created_at }}</span>
                </div>
                <div class="mt-2">
                    <span class="font-medium">Отправлено:</span> <span
                    v-if="$props.outbox.sent">{{ $props.outbox.read_at }}</span>
                </div>
            </div>
            <div class="p-2">
                <div class="font-medium mb-2">Вложенные файлы:</div>
                <div v-for="(item, index) in $props.outbox.attachments">{{ index }}</div>
            </div>
        </div>


        <div class="mt-3 flex flex-row">
            <el-button v-if="!$props.outbox.sent" type="info" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.outbox.sent" type="primary" @click="goEdit">Отправить</el-button>
        </div>
    </div>

    <h2 class="mt-3 font-medium">Письмо:</h2>
    <div class="mt-1 p-3 bg-white rounded-lg" v-html="$props.outbox.message">
    </div>

</template>

<script lang="ts" setup>
import {Head, Link} from '@inertiajs/vue3'

const props = defineProps({
    outbox: Object,
    edit: String,
    title: {
        type: String,
        default: 'Карточка outbox',
    },
    /**
     * Задать props
     */
});

/**
 * Методы
 */


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
    },
}

</script>

<style>

</style>
