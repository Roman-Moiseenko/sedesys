<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ mail.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="truncate sm:whitespace-normal flex items-center mt-2">
            Служба&nbsp;<span class="font-medium ml-6">{{ mail.mailable}}</span>
        </div>
        <div class="truncate sm:whitespace-normal flex items-center mt-2">
            Получатель&nbsp;<span class="font-medium ml-6">{{ mail.user}}</span>
        </div>
        <div class="truncate sm:whitespace-normal flex items-center mt-2">
            Отправлено&nbsp;<span class="font-medium ml-6">{{ mail.created_at}}</span>
        </div>
        <div class="truncate sm:whitespace-normal flex items-center mt-2">
            Вложения&nbsp;<span v-for="item in mail.attachments" class="font-medium ml-6">{{ mail.item}} | </span>
        </div>
    </div>

    <div v-html="mail.content" class="mt-3 p-3 bg-white rounded-lg">
    </div>

</template>

<script lang="ts" setup>
    import { Head, Link } from '@inertiajs/vue3'

    const props = defineProps({
        mail: Object,
        edit: String,
        title: {
            type: String,
            default: 'Карточка systemMail',
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
