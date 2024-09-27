<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ feedback.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid grid-cols-1 divide-x">
            <div class="p-4">
                <el-descriptions :column="2" border>
                    <el-descriptions-item label="Название">{{ feedback.name }}</el-descriptions-item>

                </el-descriptions>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button
                type="primary"
                @click="handleEdit">
                Редактировать
            </el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'

const props = defineProps({
    feedback: Object,
    title: {
        type: String,
        default: 'Карточка feedback',
    },

});
function handleEdit() {
    router.get(route('admin.feedback.feedback.edit', {feedback: props.feedback.id}))
}
</script>

