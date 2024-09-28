<template>
    <el-tab-pane>
        <template #label>
            <span class="custom-tabs-label">
                <el-icon><SuitcaseLine/></el-icon>
                <span> Услуги</span>
            </span>
        </template>
        <el-form :model="form">
            <el-form-item label="Услуга" :rules="{required: true}">
                <el-select v-model="form.service_id"
                           filterable
                           placeholder="Услуга"
                >
                    <el-option v-for="item in services"
                               :value="item.id"
                               :label="item.name"
                               @click="employees = [...item.employees]"
                    />
                </el-select>
                <div v-if="errors.service_id" class="text-red-700">{{ errors.service_id }}</div>
            </el-form-item>
            <el-form-item label="Специалист" :rules="{required: true}">
                <el-select v-model="form.employee_id"
                           filterable
                           placeholder="Специалист"
                >
                    <el-option v-for="item in employees"
                               :value="item.id"
                               :label="item.name"
                    />
                </el-select>
                <div v-if="errors.employee_id" class="text-red-700">{{ errors.employee_id }}</div>
            </el-form-item>
            <el-form-item label="Количество">
                <el-input-number v-model="form.quantity" min="1" max="10"/>
                <div v-if="errors.quantity" class="text-red-700">{{ errors.quantity }}</div>

            </el-form-item>
        <div class="mt-3">
            <el-button type="primary" plain @click="sendForm">Добавить услугу</el-button>
        </div>
        </el-form>
    </el-tab-pane>
</template>

<script lang="ts" setup>
import {defineProps, reactive, ref, inject} from "vue";
import {router} from "@inertiajs/vue3";

const errors = inject("prov_errors")
const {services} = inject("prov_items")

const props = defineProps({
    order: Object,
})
const employees = ref([]);
const form = reactive({
    item: 'service',
    service_id: null,
    employee_id: null,
    quantity: 1,
})
function sendForm() {
    router.post(route('admin.order.order.add-item', {order: props.order.id}), form)
    form.service_id = null
    form.employee_id = null
}
</script>

<style scoped>

</style>
