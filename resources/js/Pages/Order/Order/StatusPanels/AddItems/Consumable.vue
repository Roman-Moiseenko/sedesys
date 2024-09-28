<template>
    <el-tab-pane>
        <template #label>
            <span class="custom-tabs-label">
                <el-icon><TakeawayBox/></el-icon>
                <span> Расходники</span>
            </span>
        </template>
        <el-form :model="form">
            <el-form-item label="Материал" :rules="{required: true}">
                <el-select v-model="form.consumable_id"
                           filterable
                           placeholder="Расходный материал"
                >
                    <el-option v-for="item in consumables"
                               :value="item.id"
                               :label="item.name"
                    />
                </el-select>
                <div v-if="errors.consumable_id" class="text-red-700">{{ errors.consumable_id }}</div>
            </el-form-item>

            <el-form-item label="Количество">
                <el-input-number v-model="form.quantity" min="1" max="10"/>
                <div v-if="errors.quantity" class="text-red-700">{{ errors.quantity }}</div>

            </el-form-item>
        <div class="mt-3">
            <el-button type="primary" plain @click="sendForm">Добавить материал</el-button>
        </div>
        </el-form>
    </el-tab-pane>
</template>

<script lang="ts" setup>
import {defineProps, inject, reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";

const errors = inject("prov_errors")
const { consumables } = inject("prov_items")
const props =defineProps({
    order: Object,
})

const form = reactive({
    item: 'consumable',
    consumable_id: null,
    quantity: 1,
})
function sendForm() {
    router.post(route('admin.order.order.add-item', {order: props.order.id}), form)
    form.consumable_id = null

}
</script>

<style scoped>

</style>
