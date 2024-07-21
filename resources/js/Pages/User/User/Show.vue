<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ user.name }}  </h1>
</template>

<script>
    import { Head, Link } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'

    export default {
        components: {
            Head,
        },
        layout: Layout,
        props: {
            user: Object,
            title: {
                type: String,
                default: 'Карточка user',
            }
        }
    }
</script>

<style scoped>

</style>
