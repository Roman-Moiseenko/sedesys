<template>
    <el-tab-pane>
        <template #label>
            <span class="custom-tabs-label">
                <el-icon><SuitcaseLine /></el-icon>
                <span> Общая информация</span>
            </span>
        </template>
        <div class="grid lg:grid-cols-6 grid-cols-1 divide-x">
            <div class="p-4 col-span-2">
                <el-descriptions :column="1" border>
                    <el-descriptions-item label="Классификация" v-if="service.classification_id !== null">
                        {{ service.classification.name }}
                    </el-descriptions-item>

                    <el-descriptions-item label="Цена">{{ func.price(service.price) }}</el-descriptions-item>
                    <el-descriptions-item label="Длительность">{{ service.duration }} мин</el-descriptions-item>
                    <el-descriptions-item label="Данные">{{ service.data }}</el-descriptions-item>

                </el-descriptions>
            </div>
            <div class="p-4 col-span-2 flex">
                ** вычисляемые поля ... на будущее
            </div>
        </div>
    </el-tab-pane>
</template>

<script lang="ts" setup>
import {defineProps} from "vue";
import {func} from '@/func.js'

const props = defineProps({
    service: Array,
    })
</script>
