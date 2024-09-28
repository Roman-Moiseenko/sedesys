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
                :add="route('admin.service.service.add', {service: service.id})"
                :del="route('admin.service.service.del', {service: service.id})"
                :set="route('admin.service.service.set', {service: service.id})"
                :gallery="gallery"
            />
            <!-- Панель Персонал -->
            <EmployeePanel
                :service_id="service.id"
                :employees="service.employees"
                :out_employees="out_employees"
            />
            <!-- Панель Расходники -->
            <ConsumablesPanel
                :service_id="service.id"
                :consumables="service.consumables"
                :out_consumables="out_consumables"
            />
            <!-- Панель Примеры работ -->
            <ExamplesPanel
                :service_id="service.id"
                :examples="examples"
                :new_example="route('admin.service.example.create', {service_id: service.id})"
            />
            <!-- Панель Отзывы -->
            <ReviewPanel :reviews="reviews" />
            <!-- Панель Доп.услуги -->
            <ExtraPanel
                :extras="extras"
                :errors="errors"
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
            <el-button type="primary" @click="handleEdit">Редактировать</el-button>
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
    image: String,
    icon: String,
    errors: Object,
    title: {
        type: String,
        default: 'Карточка услуги',
    },
    gallery: Array,
    out_employees: Array,
    class_name: String,
    examples: Array,
    out_consumables: Array,
    reviews: Array,
    extras: Array,
});

function handleEdit() {
    router.post(route('admin.service.service.edit', {service: props.service.id}));
}
function handleToggle() {
    router.post(route('admin.service.service.toggle', {service: props.service.id}));
}
</script>

