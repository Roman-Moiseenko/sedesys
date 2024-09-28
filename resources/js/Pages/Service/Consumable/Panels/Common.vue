<template>
    <el-tab-pane>
        <template #label>
            <span class="custom-tabs-label">
                <el-icon><TakeawayBox /></el-icon>
                <span> Общая информация</span>
            </span>
        </template>
        <div class="grid lg:grid-cols-6 grid-cols-1 divide-x">
            <div class="p-4 col-span-2">
                <el-descriptions :column="1" border>
                    <el-descriptions-item label="Расходный материал">
                        {{ consumable.name }}
                    </el-descriptions-item>
                    <el-descriptions-item label="Цена">{{ func.price(consumable.price) }} </el-descriptions-item>
                    <el-descriptions-item label="Кол-во на складе">{{ consumable.duration }} шт</el-descriptions-item>
                    <el-descriptions-item label="Описание">{{ consumable.description }}</el-descriptions-item>

                </el-descriptions>
            </div>
            <div class="p-4 col-span-2">
                <h2 class="font-medium mb-3">Изображение сайта</h2>
                <div class="lg:w-48 lg:h-48 image-fit relative">
                    <el-image
                        v-bind:src="consumable.image"
                        :zoom-rate="1.2"
                        :max-scale="3"
                        :min-scale="0.2"
                        :preview-src-list="[consumable.image]"
                        :initial-index="0"
                        fit="cover"
                    />
                </div>
            </div>
        </div>
    </el-tab-pane>
</template>

<script lang="ts" setup>
import {defineProps} from "vue";
import {func} from '@/func.js'

const props = defineProps({
    consumable: Array,
    })
</script>
