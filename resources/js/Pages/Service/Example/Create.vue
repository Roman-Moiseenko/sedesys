<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новый пример</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">

                    <el-form-item label="Услуга">
                        <el-select v-model="form.service_id">
                            <el-option v-for="item in services" :value="item.id" :key="item.id" :label="item.name"/>
                        </el-select>
                        <div v-if="errors.service_id" class="text-red-700">{{ errors.service_id }}</div>
                    </el-form-item>
                    <el-form-item label="Заголовок">
                        <el-input v-model="form.title" placeholder="Заголовок"/>
                        <div v-if="errors.title" class="text-red-700">{{ errors.title }}</div>
                    </el-form-item>
                    <el-form-item label="Стоимость оказанной услуги">
                        <el-input v-model="form.cost" placeholder="" @input="handleCost">
                            <template #append>₽</template>
                        </el-input>
                        <div v-if="errors.cost" class="text-red-700">{{ errors.cost }}</div>
                    </el-form-item>
                    <el-form-item label="Длительность">
                        <el-input v-model="form.duration" placeholder="Текстом: 3 часа/15 раб.дней и т.п. "/>
                        <div v-if="errors.duration" class="text-red-700">{{ errors.duration }}</div>
                    </el-form-item>
                    <el-form-item label="Дата оказания">
                        <el-date-picker v-model="form.date" type="date"/>
                    </el-form-item>
                    <el-form-item label="Описание">
                        <el-input v-model="form.description" type="textarea" :rows="5"/>
                        <div v-if="errors.description" class="text-red-700">{{ errors.description }}</div>
                    </el-form-item>
                    <el-form-item label="Персонал">
                        <el-select
                            v-model="form.employees"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            :reserve-keyword="false"
                            placeholder="Добавьте сотрудников"
                        >
                            <el-option
                                v-for="item in employees"
                                :key="item.id"
                                :label="func.fullName(item.fullname)"
                                :value="item.id"
                            />
                        </el-select>
                    </el-form-item>
                </div>
                <div class="p-4">
                </div>
                <div class="p-4">
                </div>
            </div>

            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
import {Head} from '@inertiajs/vue3'
import {reactive} from 'vue'
import {router} from "@inertiajs/vue3";
import {func} from "/resources/js/func.js"

const props = defineProps({
    errors: Object,
    title: {
        type: String,
        default: 'Создание примера работ',
    },
    services: Array,
    employees: Array,
    service_id: Number,
    employee_id: Number,
});

const form = reactive({
    title: null,
    description: null,
    service_id: null,
    cost: null,
    duration: null,
    date: null,
    employees: [],
})
if (props.service_id > 0) form.service_id = props.service_id;
if (props.employee_id > 0) form.employees = [props.employee_id];

function onSubmit() {
    router.post(route('admin.service.example.store'), form)
}

function handleCost(val) {
    form.cost = func.MaskInteger(val)
}
</script>

