<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ calendar.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid grid-cols-1 divide-x">
            <div class="p-4">
                <el-descriptions :column="2" border>
                    <el-descriptions-item label="Название">{{ calendar.name }}</el-descriptions-item>

                </el-descriptions>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="router.get(edit)">Редактировать</el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
    import { Head, router } from '@inertiajs/vue3'

    const props = defineProps({
        calendar: Object,
        edit: String,
        title: {
            type: String,
            default: 'Карточка calendar',
        },
        /**
         * Задать props
         */
    });

    /**
     * Методы
     */


</script>

<style>

</style>
