<template>
    <Head><title>{{ title }}</title></Head>
    <h1>{{ staff.fullname.surname }}</h1>
    <div class="p-3 bg-white rounded-lg grid grid-cols-3 divide-x">
        <div class="p-2">
            <h2 class="font-medium">Основные сведения</h2>
            <div>

            </div>
        </div>

        <div class="p-2">
            <h2 class="font-medium">Персональные данные</h2>
            <div>

            </div>
        </div>
        <div class="p-2">
            <h2 class="font-medium">Доступы</h2>
            <div>

            </div>
        </div>
    </div>
</template>

<script>
import {Head, Link} from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'

export default {
    components: {
        Head,
    },
    layout: Layout,
    props: {
        staff: Object,
        title: {
            type: String,
            default: 'Карточка сотрудника',
        }
    }
}
</script>

<style scoped>

</style>
