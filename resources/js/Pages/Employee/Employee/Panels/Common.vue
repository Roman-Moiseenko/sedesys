<template>
    <el-tab-pane>
        <template #label>
                    <span class="custom-tabs-label">
                        <el-icon><Service/></el-icon>
                        <span> Персональные данные</span>
                    </span>
        </template>
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            <div class="p-2">
                <el-descriptions :column="1" border>
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon><User  /></el-icon>&nbsp;ФИО
                            </div>
                        </template>
                        {{ func.fullName(employee.fullname) }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon><iphone  /></el-icon>&nbsp;Телефон
                            </div>
                        </template>
                        {{ employee.phone }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon><Promotion /></el-icon>&nbsp;Телеграм ID
                            </div>
                        </template>
                        {{ employee.telegram_user_id }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon><Location /></el-icon>&nbsp;Адрес
                            </div>
                        </template>
                        {{ employee.address.address }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon><Calendar /></el-icon>&nbsp;Стаж с
                            </div>
                        </template>
                        <span v-if="employee.experience_year">{{ employee.experience_year }} г</span>
                    </el-descriptions-item>
                </el-descriptions>
            </div>
            <div class="p-2">
                <h2 class="font-medium">Специализация</h2>
                <div v-for="specialization in specializations" class="flex mt-1">
                    <el-image :src="specialization.icon" class="w-8 h-8"/>
                    <span class="ml-2 my-auto">{{ specialization.name }}</span>
                </div>
            </div>
        </div>
    </el-tab-pane>
</template>

<script lang="ts" setup>
import {defineProps} from "vue";
import {func} from '@/func.js'

const props = defineProps({
    employee: Object,
    specializations: Array,
})

</script>
