<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ promotion.name }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid grid-cols-6 divide-x">
            <div class="p-4 col-span-4">
                <el-descriptions :column="2" border>
                    <el-descriptions-item label="Название">{{ promotion.name }}</el-descriptions-item>
                    <el-descriptions-item label="Ссылка">{{ promotion.slug }}</el-descriptions-item>
                    <el-descriptions-item label="Ссылка на условия">{{ promotion.condition_url }}</el-descriptions-item>
                    <el-descriptions-item label="Скидка">{{ promotion.discount }} %</el-descriptions-item>
                    <el-descriptions-item label="Расписание">
                        <span v-if="promotion.start_at">
                            С {{ func.date(promotion.start_at) }} по {{ func.date(promotion.finish_at) }}
                        </span>
                        <span v-else>
                            Вручную
                        </span>
                    </el-descriptions-item>
                    <el-descriptions-item label="Описание для виджета">{{
                            promotion.description
                        }}
                    </el-descriptions-item>
                </el-descriptions>
                <DisplayedShow :displayed="promotion"/>
            </div>
            <div class="p-4 col-span-2 flex">
                <DisplayedImage :image="$props.image" :icon="$props.icon"/>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
        </div>
    </div>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-select v-model="formAdd.service_id" placeholder="Услуга" style="width: 240px" filterable multiple>
            <el-option-group
                v-for="group in services_data.group_services"
                :key="group.label"
                :label="group.label"
            >
                <el-option
                    v-for="item in group.options"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                />
            </el-option-group>
        </el-select>
        <el-button type="primary" plain class="ml-3" @click="onAttach">Добавить</el-button>

        <el-table
            :data="state.attaches"
        >
            <el-table-column prop="name" label="Акция" width="300" show-overflow-tooltip/>
            <el-table-column label="Скидка" width="200">
                <template #default="scope">
                    <el-input-number v-model="scope.row.price" @change="onState(scope.row)" :disabled="scope.row.disabled"/>
                </template>
            </el-table-column>
            <el-table-column label="Действия"  width="200">
                <template #default="scope">
                    <el-button type="danger" @click="onDetach(scope.row)"><el-icon><Delete /></el-icon></el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script lang="ts" setup>
import {Head, Link, router} from '@inertiajs/vue3'
import DisplayedShow from '@/Components/DisplayedShow.vue'
import DisplayedImage from '@/Components/DisplayedImage.vue'
import {func} from '@/func.js'
import {reactive} from "vue";

const props = defineProps({
    promotion: Object,
    edit: String,
    title: {
        type: String,
        default: 'Карточка Акции',
    },
    toggle: String,
    start: String,
    finish: String,
    image: String,
    icon: String,
    services_data: Object,
    group_services: Array,
    attach: String,
    /**
     * Задать props
     */
});
// console.log(props.promotion)

const formAdd = reactive({
    service_id: null,
})
const state = reactive({
    attaches: [],
})

props.promotion.services.forEach(item => {
    state.attaches.push({
        id: item.id,
        name: item.name,
        price: item.pivot.price,
        disabled: false,
    })

})
console.log(state)

function onAttach() {
    router.visit(props.services_data.attach, {
        method: 'post',
        data: formAdd,
        preserveScroll: true,
        preserveState: false,
    })
}

function onDetach(item) {
    router.visit(props.services_data.detach, {
        method: 'post',
        data: {service_id: item.id},
        preserveScroll: true,
        preserveState: false,
    })
}

function onState(item){
    item.disabled = true
    router.visit(props.services_data.set, {
        method: 'post',
        preserveScroll: true,
        preserveState: true,
        data: {
            service_id: item.id,
            price: item.price,
        },
        onSuccess: page => {
            item.disabled = false;
        }
    })
}
/**
 * Методы
 */


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
        handleToggle(index, row) {
            router.visit(this.$props.toggle, {
                method: 'post'
            });
        },
        handleStart(index, row) {
            console.log(row.start)
            router.visit(this.$props.start, {
                method: 'post'
            });
        },
        handleFinish(index, row) {
            router.visit(this.$props.finish, {
                method: 'post'
            });
        },
    },
}

</script>

<style>

</style>
