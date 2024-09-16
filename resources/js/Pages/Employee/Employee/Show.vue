<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ employee.fullname.surname + ' ' + employee.fullname.firstname + ' ' + employee.fullname.secondname }}  </h1>
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
            />
            <!-- Панель Примеры -->
            <ExamplesPanel
                :examples="examples"
                :new_example="new_example"
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
        <el-button type="primary" @click="router.get(edit)">Редактировать</el-button>
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
    edit: String,
    image: String,
    icon: String,
    title: {
        type: String,
        default: 'Карточка Персонала',
    },

    attach: String,
    detach: String,
    services: Array,
    out_services: Array,

    services_data: Object,

    new_example: String,
    specializations:  Object,

    examples: Array,
    reviews: Array,

    toggle: String,

});

const formService = reactive({
    service_id: null,
    extra_cost: null
});

function handleToggle() {
    router.post(props.toggle);
}
function newExample() {
    router.get(props.new_example);
}
function handleExtraCost(val) {
    formService.extra_cost = func.MaskInteger(val);
}
function attachService() {
    if (formService.service_id === null) return;
    router.post(props.attach, formService);
    dialogService.value = false;
}

function detachService(row) {
    router.post(props.detach, {
        service_id: row.id
    });
}
function routeClick(row) {
    router.get(row.url)
}
</script>


<style scoped>

</style>
