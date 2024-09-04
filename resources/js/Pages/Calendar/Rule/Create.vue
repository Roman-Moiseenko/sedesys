<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новый rule</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <!-- Повторить поля -->
                    <el-form-item label="Название" :rules="{required: true}">
                        <el-input v-model="form.name" placeholder="Название" @input="handleMaskName"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Периодичность">
                        <el-select
                            v-model="form.regularity"
                            filterable
                            allow-create
                            default-first-option
                            :reserve-keyword="false"
                        >
                            <el-option
                                v-for="item in regularities"
                                :key="item.value"
                                :label="item.label"
                                :value="item.value"
                            />
                        </el-select>
                    </el-form-item>
                    <el-form-item label="Макс.одновременно" :rules="{required: true}">
                        <el-input-number v-model="form.max" placeholder="либо Персонал"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Услуги">
                        <el-select
                            v-model="form.services"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            :reserve-keyword="false"
                            placeholder="Добавьте сотрудников"
                        >
                            <el-option
                                v-for="item in services"
                                :key="item.id"
                                :label="item.name"
                                :value="item.id"
                            />
                        </el-select>
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
        route: String,
        title: {
            type: String,
            default: 'Создание правила',
        },
        services: Array,
        employees: Array,
        regularities: Array,
    });

    const form = reactive({
        name: null,
        services: null,
        employees: null,
        regularity: null,
        max: null,
        /**
         * Добавить новые поля
         */
    })

    function handleMaskName(val)
    {
        /**
         * Функции маски ввода
         * Например, form.phone = func.MaskPhone(val);
         */
    }

    function onSubmit() {
        router.post(props.route, form)
    }

</script>
<script lang="ts">
    import Layout from '@/Components/Layout.vue'

    export default {
        layout: Layout,
    }
</script>
