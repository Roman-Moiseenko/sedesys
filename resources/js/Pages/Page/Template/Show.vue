<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ title }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            Данные
        </div>
        <div class="mt-3 flex flex-row">
            {{ template }}
        </div>
    </div>

</template>

<script lang="ts" setup>
import {Head, Link, router} from '@inertiajs/vue3'

const props = defineProps({
    template: String,

    title: {
        type: String,
        default: 'Шаблон',
    }
});

</script>

<script lang="ts">
import Layout from '@/Components/Layout.vue'

export default {
    layout: Layout,
}

</script>

