<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ coupon.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid grid-cols-1 divide-x">
            <div class="p-4">
                <el-descriptions :column="2" border>
                    <el-descriptions-item label="Название">{{ coupon.name }}</el-descriptions-item>

                </el-descriptions>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="handleEdit()">Редактировать</el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
import { Head, router } from '@inertiajs/vue3'

const props = defineProps({
    coupon: Object,
    title: {
        type: String,
        default: 'Карточка coupon',
    },
});
function handleEdit() {
    router.get(route('admin.discount.coupon.edit', {coupon: props.coupon.id}))
}

</script>


<style>

</style>
