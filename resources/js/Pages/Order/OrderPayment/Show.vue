<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ orderPayment.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid grid-cols-1 divide-x">
            <div class="p-4">
                <el-descriptions :column="2" border>
                    <el-descriptions-item label="Платеж от">{{ orderPayment.created_at }}</el-descriptions-item>
                    <el-descriptions-item label="Сумма">{{ func.price(orderPayment.amount) }}</el-descriptions-item>
                    <el-descriptions-item label="Клиент Ф.И.О">{{ func.fullName(orderPayment.user.fullname) }}</el-descriptions-item>
                    <el-descriptions-item label="Клиент Телефон">{{ func.phone(orderPayment.user.phone) }}</el-descriptions-item>
                    <el-descriptions-item label="Оплата">{{ orderPayment.method_text }}</el-descriptions-item>
                    <el-descriptions-item label="Документ">{{ orderPayment.document }}</el-descriptions-item>
                    <el-descriptions-item label="Заказ">
                        <Link :href="route('admin.order.order.show', {order: props.orderPayment.order_id})"
                              class="text-cyan-600 hover:text-cyan-500"
                        >
                            {{ orderPayment.order }}
                        </Link>
                    </el-descriptions-item>

                </el-descriptions>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button
                type="primary"
                @click="handleEdit()">
                Редактировать
            </el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
import { Head, Link } from '@inertiajs/vue3'
import { router } from '@inertiajs/vue3'
import { func } from '/resources/js/func.js'

const props = defineProps({
    orderPayment: Object,
    edit: String,
    title: {
        type: String,
        default: 'Карточка orderPayment',
    },
    /**
     * Задать props
     */
});
function handleEdit() {
    router.get(route('admin.order.payment.edit', {payment: props.orderPayment.id}))
}


</script>

<style>

</style>
