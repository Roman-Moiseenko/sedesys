<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ func.fullName(employee.fullname) }}  </h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-tabs type="border-card" class="">
            <!-- Панель Общая информация -->
            <CommonPanel
                :employee="employee"
                :specializations="specializations"
            />
            <!-- Панель Услуги -->
            <ServicePanel
                :services_data="services_data"
                :employee_id="employee.id"
            />
            <!-- Панель Примеры -->
            <ExamplesPanel
                :examples="examples"
                :employee_id="employee.id"
            />
            <!-- Панель Отзывы -->
            <ReviewPanel :reviews="reviews" />
            <!-- Панель Displayed -->
            <DisplayedShowPanel
                :model="employee"
                :image="image"
                :icon="icon"
            />
        </el-tabs>
    </div>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-button type="primary" @click="handleEdit()">Редактировать</el-button>
        <el-button v-if="!employee.active" type="success" @click="handleToggle">Разблокировать
        </el-button>
        <el-button v-if="employee.active" type="warning" @click="handleToggle">Заблокировать
        </el-button>
    </div>

    <div class="mt-5 p-3 bg-white rounded-lg ">
        Dashboard Персонала - графики, клиенты, записи и т.п.
    </div>
</template>

<script lang="ts" setup>
import {reactive, ref} from "vue";
import {router, Head} from "@inertiajs/vue3";
import {func} from '@/func.js'

import DisplayedShowPanel from '@/Components/Displayed/Show.vue'

import CommonPanel from './Panels/Common.vue'

import ReviewPanel from './Panels/Review.vue'
import ExamplesPanel from './Panels/Examples.vue'
import ServicePanel from './Panels/Service.vue'

const dialogService = ref(false)
const dialogSave = ref(false)

const props = defineProps({
    employee: Object,
    image: String,
    icon: String,
    title: {
        type: String,
        default: 'Карточка Персонала',
    },
    services: Array,
    out_services: Array,
    services_data: Object,
    specializations:  Object,
    examples: Array,
    reviews: Array,

});

const formService = reactive({
    service_id: null,
    extra_cost: null
});
function handleEdit() {
    router.get(route('admin.employee.employee.edit', {employee: props.employee.id}))
}
function handleToggle() {
    router.post(route('admin.employee.employee.toggle', {employee: props.employee.id}));
}
function newExample() {
    router.get(route('admin.service.example.create', {employee_id: props.employee.id}));
}
</script>

