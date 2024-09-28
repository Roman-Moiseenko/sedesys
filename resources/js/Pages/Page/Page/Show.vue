<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ page.name }} </h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-tabs type="border-card" class="mb-4">
            <DisplayedShowPanel
                :model="page"
                :image="image"
                :icon="icon"
            >
                <el-descriptions-item>
                    <template #label>
                        <span class="font-medium">Родительская страница</span>
                    </template>
                    <span class="font-medium">{{ parent }}</span>
                </el-descriptions-item>
            </DisplayedShowPanel>
        </el-tabs>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.page.active" type="success" @click="handleToggle">Опубликовать</el-button>
            <el-button v-if="$props.page.active" type="warning" @click="handleToggle">В черновик</el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
import {Head, router} from '@inertiajs/vue3'
import DisplayedShowPanel from '@/Components/Displayed/Show.vue'

const props = defineProps({
    page: Object,
    edit: String,
    toggle: String,
    title: {
        type: String,
        default: 'Карточка Страницы',
    },
    image: String,
    icon: String,
    parent: String
})

function goEdit() {
    router.get(route('admin.page.page.edit', {page: props.page.id}));
}
function handleToggle(val) {
    router.post(route('admin.page.page.toggle', {page: props.page.id}));
}
</script>

