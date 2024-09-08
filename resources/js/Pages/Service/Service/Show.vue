<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ service.name }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-tabs type="border-card" class="">
            <!-- Панель Общая информация -->
            <CommonPanel
                :service="service"
            />
            <!-- Панель Галерея -->
            <GalleryPanel
                :add="gallery_data.add"
                :del="gallery_data.del"
                :set="gallery_data.set"
                :gallery="gallery_data.gallery"
            />
            <!-- Панель Персонал -->
            <EmployeePanel
                :attach="employee_data.attach"
                :detach="employee_data.detach"
                :employees="service.employees"
                :out_employees="employee_data.out_employees"
            />
            <!-- Панель Расходники -->
            <ConsumablesPanel />
            <!-- Панель Примеры работ -->
            <ExamplesPanel
                :examples="example_data.examples"
                :new_example="example_data.new_example"
            />
            <!-- Панель Отзывы -->
            <ReviewPanel :reviews="reviews" />
            <!-- Панель Доп.услуги -->
            <ExtraPanel
                :extras="extra_data.extras"
                :errors="errors"
                :add="extra_data.add"
                :service_id="service.id"
            />
            <DisplayedShowPanel
                :model="service"
                :image="image"
                :icon="icon"
            />
        </el-tabs>
    </div>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.service.active" type="success" @click="handleToggle">Показывать</el-button>
            <el-button v-if="$props.service.active" type="warning" @click="handleToggle">Скрыть из показа</el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
import {Head} from '@inertiajs/vue3'
import {router} from "@inertiajs/vue3";
import {func} from '@/func.js'


///Панели

import GalleryPanel from './Panels/Gallery.vue'
import EmployeePanel from './Panels/Employee.vue'
import ConsumablesPanel from './Panels/Consumables.vue'
import ExamplesPanel from './Panels/Examples.vue'
import ExtraPanel from './Panels/Extra.vue'
import ReviewPanel from './Panels/Review.vue'
import CommonPanel from './Panels/Common.vue'
import DisplayedShowPanel from '@/Components/Displayed/Show.vue'

const props = defineProps({
    service: Object,
    edit: String,
    image: String,
    icon: String,
    errors: Object,

    title: {
        type: String,
        default: 'Карточка услуги',
    },
    gallery_data: Array,
    employee_data: Array,

    toggle: String,
    class_name: String,

    example_data: Array,

    reviews: Array,
    extra_data: Array,
});


function handleToggle() {
    router.post(props.toggle);
}


function newExtra() {
    alert('Добавить');
}
</script>

<script lang="ts">
import {router} from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'
;

export default {
    layout: Layout,
    methods: {
        goEdit() {
            router.get(this.$props.edit);
        },
    },
}

</script>

<style>

</style>
