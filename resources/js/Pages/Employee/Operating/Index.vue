<template>
    <div>
        <Head title="Dashboard" />
        <h1>Режим работы</h1>
    </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'

export default {
    components: {
        Head,
    },
    layout: Layout,
    props: {
        //staffs: Object
    }
}

</script>

<style scoped>

</style>
