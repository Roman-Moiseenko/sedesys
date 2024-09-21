<template>
    <el-tab-pane>
        <template #label>
            <span class="custom-tabs-label">
                <el-icon><Box/></el-icon>
                <span> Доп.услуги</span>
            </span>
        </template>
        <el-form :model="form">
            <el-form-item label="Услуга" :rules="{required: true}">
                <el-select v-model="form.extra_id"
                           filterable
                           placeholder="Услуга"
                >
                    <el-option v-for="item in extras"
                               :value="item.id"
                               :label="item.name"
                    />
                </el-select>
                <div v-if="errors.extra_id" class="text-red-700">{{ errors.extra_id }}</div>
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
import {defineProps, reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    extras: Object,
    add_item: String,
    errors: Object,
})

const form = reactive({
    item: 'extra',
    extra_id: null,

    quantity: 1,
})

function sendForm() {
    router.post(props.add_item, form)
    form.extra_id = null

}
</script>

<style scoped>

</style>
