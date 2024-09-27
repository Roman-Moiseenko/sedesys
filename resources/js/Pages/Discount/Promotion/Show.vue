<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ promotion.name }} </h1>


    <div class="mt-3 p-3 bg-white rounded-lg">

        <el-tabs type="border-card" class="mb-4">
            <el-tab-pane>
                <template #label>
                <span class="custom-tabs-label">
                    <el-icon><Present/></el-icon>
                    <span> Акция</span>
                </span>
                </template>
                <el-descriptions :column="2" border>
                    <el-descriptions-item label="Скидка">{{ promotion.discount }} %</el-descriptions-item>
                    <el-descriptions-item label="Ссылка на условия">{{ promotion.condition_url }}</el-descriptions-item>

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
            </el-tab-pane>

            <DisplayedShowPanel
                :model="promotion"
                :image="image"
                :icon="icon"
            />
        </el-tabs>

        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit()">Редактировать</el-button>
        </div>
    </div>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-select v-model="formAdd.service_id" placeholder="Услуга" style="width: 240px" filterable multiple>
            <el-option-group
                v-for="group in group_services"
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
            :data="promotion.services"
        >
            <el-table-column prop="name" label="Акция" width="300" show-overflow-tooltip/>
            <el-table-column label="Скидка" width="200">
                <template #default="scope">
                    <el-input-number v-model="scope.row.pivot.price" @change="onState(scope.row)"
                                     :disabled="scope.row.disabled"/>
                </template>
            </el-table-column>
            <el-table-column label="Действия" width="200">
                <template #default="scope">
                    <el-button type="danger" @click="onDetach(scope.row)">
                        <el-icon>
                            <Delete/>
                        </el-icon>
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
</template>

<script lang="ts" setup>
import {Head, router} from '@inertiajs/vue3'

import {func} from '@/func.js'
import {reactive} from "vue";
import DisplayedShowPanel from '@/Components/Displayed/Show.vue'

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
    group_services: Array,
    attach: String,
});

const formAdd = reactive({
    service_id: null,
})

function onAttach() {
    router.post(
        route('admin.discount.promotion.attach', {promotion: props.promotion.id}),
        formAdd
    );
}

function onDetach(item) {
    router.post(
        route('admin.discount.promotion.detach', {promotion: props.promotion.id}),
        {service_id: item.id}
    );
}

function onState(item) {
    item.disabled = true
    router.visit(
        route('admin.discount.promotion.set', {promotion: props.promotion.id}),
        {
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

function goEdit() {
    router.get(route('admin.discount.promotion.edit', {promotion: props.promotion.id}));
}
function handleToggle(index, row) {
    router.visit(route('admin.discount.promotion.toggle', {promotion: props.promotion.id}), {
        method: 'post'
    });
}
function handleStart(index, row) {

    router.visit(
        route('admin.discount.promotion.start', {promotion: props.promotion.id}),
        {
            method: 'post'
        }
    );
}
function handleFinish(index, row) {
    router.visit(
        route('admin.discount.promotion.finish', {promotion: props.promotion.id}),
        {
            method: 'post'
        }
    );
}

</script>


