<template>
    <h1>Добавить нового сотрудника</h1>
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
        staff: Object
    }
}
</script>

<style scoped>

</style>
