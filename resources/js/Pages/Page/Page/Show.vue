<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ page.name }}  </h1>
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

<script>
    import { Head, router } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'
    import DisplayedShowPanel from '@/Components/Displayed/Show.vue'

    export default {
        components: {
            Head,
            DisplayedShowPanel
        },
        layout: Layout,
        props: {
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
        },
        methods: {
            goEdit() {
                router.get(this.$props.edit);
            },
            handleToggle(val) {
                router.post(this.$props.toggle);
            }
        },
    }
</script>

