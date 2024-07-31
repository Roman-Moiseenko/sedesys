<template>
    <div>
        <Head>
            <title>SeDeSys - CRM управления услугами v{{ version }}</title>
        </Head>
        <h1 class="font-medium">Добро пожаловать в Систему Управления Услугами</h1>
        <div class="mt-4 bg-white rounded-lg p-4">
            <div v-for="(items, index) in updates">
                <div class="font-medium mt-3">
                    {{ index}}
                </div>
                <ul class="mt-1">
                    <li v-for="item in items" class="text-sm ml-3">
                        <span class="circle green"></span>
                        {{ item }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'

export default {
    components: {
        Head,
    },
    props: {
        version: String,
        updates: Array,
    },
    layout: Layout,
}

</script>

<style scoped>

</style>
