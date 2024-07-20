<template>
    <h1> {{ dummyVariableSingular.name }} </h1>
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
        dummyVariableSingular: Object
    }
}
</script>

<style scoped>

</style>
