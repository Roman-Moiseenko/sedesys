<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ rule.name }}</h1>
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

            <el-button type="primary" plain @click="onSubmit(false)" :disabled="!isUnSave">Сохранить</el-button>
            <el-button type="primary" @click="onSubmit(true)" :disabled="!isUnSave">Сохранить и Закрыть</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {Head, router} from '@inertiajs/vue3'
    import {reactive, defineProps, watch, ref} from 'vue'
    import {func} from "/resources/js/func.js"

    const props = defineProps({
        errors: Object,
        rule: Object,
        title: {
            type: String,
            default: 'Редактирование правила',
        },
        services: Array,
        employees: Array,
        dates: Array,
        regularities: Array,
    });
    const form = reactive({
        name: props.rule.name,
        services: [...props.rule.services.map(item => item.id)],
        employees: [...props.rule.employees.map(item => item.id)],
        regularity: props.rule.regularity,
        max: props.rule.max,
        close: null,
        _method: 'put',
    })
    ///Блок сохранения и обновления=>
    const isUnSave = ref(false)
    watch(
        () => ({ ...form }),
        function (newValue, oldValue) {
            isUnSave.value = true
        },
        {deep: true}
    );
    function onSubmit(val) {
        form.close = val
        router.visit(route('admin.calendar.rule.update', {rule: props.rule.id}), {
            method: 'post',
            data: form,
            preserveScroll: true,
            preserveState: true,
            onSuccess: page => {
                isUnSave.value = false
            }
        });
    }
    ////<=
</script>

