<template>
    <el-card>
        <el-descriptions :column="2"  border :size="small">
            <!-- Услуги -->
            <el-descriptions-item>
                <template #label>
                    <el-icon><SuitcaseLine /></el-icon>
                </template>
                {{ func.price(order.info.services_base) }}
            </el-descriptions-item>
            <el-descriptions-item>
                <template #label>
                    <el-icon><Coin /></el-icon>
                </template>
                {{ func.price(order.info.services_base - order.info.services_sell) }}
            </el-descriptions-item>

            <!-- Материал -->
            <el-descriptions-item>
                <template #label>
                    <el-icon><Handbag /></el-icon>
                </template>
                {{ func.price(order.info.goods_base) }}
            </el-descriptions-item>
            <el-descriptions-item>
                <template #label>
                    <el-icon><Coin /></el-icon>
                </template>
                {{ func.price(order.info.goods_base - order.info.goods_sell) }}
            </el-descriptions-item>

            <!-- Сумма -->
            <el-descriptions-item
                label-class-name="base-amount-bg"
                class-name="base-amount-bg">
                <template #label>
                    <div class="cell-item ">
                        <i class="fa-light fa-sigma"></i>
                    </div>
                </template>
                {{ func.price(order.info.amount_base) }}
            </el-descriptions-item>
            <el-descriptions-item
                label-class-name="discount-amount-bg"
                class-name="discount-amount-bg">
                <template #label>
                    <div class="cell-item ">
                        <i class="fa-light fa-sigma"></i>
                    </div>
                </template>
                {{ func.price(order.info.amount_base - order.info.amount_sell) }}
            </el-descriptions-item>

            <!-- Итого -->
            <el-descriptions-item
                label-class-name="amount-bg"
                class-name="amount-bg"
                label="ИТОГО">
                <span class="font-medium text-lg">{{ func.price(order.info.amount_sell) }}</span>
            </el-descriptions-item>

        </el-descriptions>
    </el-card>
</template>

<script lang="ts" setup>
import {defineProps} from "vue";
import { func } from '/resources/js/func.js'

const props = defineProps({
    order: Object,
})
</script>

<style scoped>
:deep(.amount-bg) {
    background:  #95d475 !important;
}
:deep(.base-amount-bg) {
    background:  #d1edc4 !important;
}
:deep(.discount-amount-bg) {
    background:  #fcd3d3 !important;
}
</style>
