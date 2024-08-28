<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ specialization.name }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid lg:grid-cols-6 grid-cols-1 divide-x">
            <div class="p-4 col-span-4">
                <el-descriptions :column="1" border>
                    <el-descriptions-item label="Специализация">{{ specialization.name }}</el-descriptions-item>
                    <el-descriptions-item label="Ссылка">{{ specialization.slug }}</el-descriptions-item>
                </el-descriptions>
                <DisplayedShow :displayed="specialization" />
            </div>
            <div class="p-4 col-span-2 flex">
                <DisplayedImage :image="$props.image" :icon="$props.icon" />
            </div>

        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.specialization.active" type="success" @click="handleToggle">Показывать в
                меню/каталогах
            </el-button>
            <el-button v-if="$props.specialization.active" type="warning" @click="handleToggle">Скрыть из показа
            </el-button>
        </div>
    </div>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <h2 class="font-medium text-lg mb-3">Специалисты:</h2>
        <div v-for="item in $props.specialization.employees">
            {{ item.fullname.surname }} {{ item.fullname.firstname }} {{ item.fullname.secondname }}
        </div>
    </div>
</template>

<script lang="ts" setup>
import {Head, Link, router} from '@inertiajs/vue3'
import {reactive} from "vue";
import DisplayedShow from '@/Components/DisplayedShow.vue'
import DisplayedImage from '@/Components/DisplayedImage.vue'

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
