<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ specialization.name }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-tabs type="border-card" class="mb-4">
        <el-tab-pane>
            <template #label>
            <span class="custom-tabs-label">
                <el-icon><User/></el-icon>
                <span> Специалисты</span>
            </span>
            </template>
            !!! *** Таблица с добавлением и отсоединением

            <div v-for="item in $props.specialization.employees">
                {{ func.fullName(item.fullname) }}
            </div>
        </el-tab-pane>

        <DisplayedShowPanel
            :model="specialization"
            :image="image"
            :icon="icon"
        >
        </DisplayedShowPanel>
        </el-tabs>

        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.specialization.active" type="success" @click="handleToggle">Показывать в
                меню/каталогах
            </el-button>
            <el-button v-if="$props.specialization.active" type="warning" @click="handleToggle">Скрыть из показа
            </el-button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {Head, router} from '@inertiajs/vue3'
import DisplayedShowPanel from '@/Components/Displayed/Show.vue'
import {func} from '@/func.js'

const props = defineProps({
    specialization: Object,
    edit: String,
    title: {
        type: String,
        default: 'Карточка специализации',
    },
    toggle: String,
    attach: String,
    image: String,
    icon: String,
});

</script>
<script lang="ts">
import {router} from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'

export default {
    layout: Layout,
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

<style>

</style>
