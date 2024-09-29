<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новый платеж</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <!-- Повторить поля -->
                    <el-form-item label="Заказ" :rules="{required: true}">
                        <el-select v-model="form.order_id" filterable clearable>
                            <el-option v-for="item in orders" :value="item.id" :key="item.id" :label="item.number">
                                <span style="float: left; color: var(--el-text-color-secondary);font-size: 13px;">№ </span>
                                <span style="margin-left: 6px; float: left">{{ item.number }}</span>
                                <span style="float: right;color: var(--el-text-color-secondary);font-size: 13px;">
                        {{ func.date(item.created_at) }}
                      </span>
                            </el-option>
                        </el-select>
                        <div v-if="errors.order_id" class="text-red-700">{{ errors.order_id }}</div>
                    </el-form-item>
                    <el-form-item label="Платеж" :rules="{required: true}">
                        <el-input v-model="form.amount" placeholder="Сумма по документу"
                                  :formatter="(value) => func.MaskInteger(value)">
                            <template #append>₽</template>
                        </el-input>
                        <div v-if="errors.amount" class="text-red-700">{{ errors.amount }}</div>
                    </el-form-item>
                    <el-form-item label="Способ оплаты" :rules="{required: true}">
                        <el-select v-model="form.method">
                            <el-option v-for="item in methods" :value="item.value" :key="item.value"
                                       :label="item.label"/>
                        </el-select>
                        <div v-if="errors.method" class="text-red-700">{{ errors.method }}</div>
                    </el-form-item>
                    <el-form-item label="Документ">
                        <el-input v-model="form.document" placeholder="Документ или комментарий"/>
                        <div v-if="errors.document" class="text-red-700">{{ errors.document }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                </div>
                <div class="p-4">
                </div>
            </div>
            <el-button type="primary" @click="onSubmit" :disabled="!isUnSave">Сохранить</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
import {Head} from '@inertiajs/vue3'
import {reactive, ref, watch, defineProps} from 'vue'
import {router} from "@inertiajs/vue3";
import {func} from "/resources/js/func.js"

const props = defineProps({
    orders: Object,
    errors: Object,
    methods: Array,
    title: {
        type: String,
        default: 'Создание платежа',
    },
});

const form = reactive({
    name: null,
    order_id: null,
    method: null,
    document: null,
})


function onSubmit() {
    router.post(route('admin.order.payment.store'), form)
}

///Блок сохранения и обновления=>
const isUnSave = ref(false)
watch(
    () => ({...form}),
    function (newValue, oldValue) {
        isUnSave.value = true
    },
    {deep: true}
);
</script>

