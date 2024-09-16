<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Создать купоны</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <h2>Параметры скидки</h2>
                    <!-- Повторить поля -->
                    <el-form-item label="Скидка ₽" :rules="{required: true}">
                        <el-input-number v-model="form.bonus" placeholder=""/>
                        <div v-if="errors.bonus" class="text-red-700">{{ errors.bonus }}</div>
                    </el-form-item>

                    <el-form-item label="Мин.сумма оплаты ₽">
                        <el-input-number v-model="form.min" placeholder=""/>


                        <div v-if="errors.min" class="text-red-700">{{ errors.min }}</div>
                    </el-form-item>
                    <el-form-item label="Дата окончания">
                        <el-date-picker
                            v-model="form.finished_at"
                            type="date"
                        />
                        <div v-if="errors.finished_at" class="text-red-700">{{ errors.finished_at }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <h2>Получатели скидки</h2>
                    <el-form-item label="Всем">
                        <el-checkbox v-model="form.condition.all" />
                    </el-form-item>
                    <el-form-item label="По № телефона">
                        <el-select
                        v-model="form.users"
                        multiple
                        filterable
                        remote
                        reserve-keyword
                        placeholder="Введите №№ телефонов"
                        :remote-method="remoteMethod"
                        :loading="loading"
                        style="width: 240px"
                        :disabled="form.condition.all"
                    >
                        <el-option
                            v-for="item in options"
                            :key="item.value"
                            :label="item.label"
                            :value="item.value"
                        />
                    </el-select>
                    </el-form-item>
                    <el-form-item label="Дней с последнего заказа">
                        <el-input-number v-model="form.condition.long_days" :disabled="form.condition.all"/>
                    </el-form-item>
                    <el-form-item label="Потрачено менее">
                        <el-input-number v-model="form.condition.payment_before" :disabled="form.condition.all"/>
                    </el-form-item>
                    <el-form-item label="Потрачено более">
                        <el-input-number v-model="form.condition.payment_before" :disabled="form.condition.all"/>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <div class="p-3 rounded-lg bg-sky-100 border border-sky-600">
                        <div class="font-medium mb-1 text-sky-700">Инструкция</div>
                        <div class="text-sm">
                            Получатели скидки по купону выбираются либо все сразу, либо по списку и условиям.
                        </div>
                        <div class="text-sm">Все параметры условий работают как <strong>ИЛИ</strong>. Т.е. если клиент соответсвует одному из условий, он получает купон.</div>
                        <div class="text-sm"><strong>Например,</strong> можно создать купон для тех, кто давно не приобретал, установив Дней с заказа - 30,
                            также, установив "Потрачено менее" 1 500 - для тех, кто только начал приобретать услуги/товары, и "Потрачено более" 100 000 - для ВИП-клиентов.

                        </div>
                        <div class="text-sm">Все эти параметры можно устанавливать сразу. Двойного купона клиенты не получат.</div>
                        <div class="text-sm">Если не указать дату окончания, купон будет бесрочный</div>
                    </div>
                </div>
            </div>
            <el-button type="primary" @click="onSubmit" :disabled="!isUnSave">Сохранить</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {Head} from '@inertiajs/vue3'
    import {reactive, ref, watch} from 'vue'
    import {router} from "@inertiajs/vue3";
    import {func} from "/resources/js/func.js"
    import axios from 'axios'

    const props = defineProps({
        errors: Object,
        route: String,
        find_phone: String,
        title: {
            type: String,
            default: 'Создание купонов',
        },
    });

    const form = reactive({
        bonus: null,
        finished_at: null,
        min: null,
        users: [],

        condition: {
            all: null,
            long_days: null,
            payment_before: null,
            payment_after: null,
        },

        /**
         * Добавить новые поля
         */
    })


    interface ListItem {
        value: string
        label: string
    }

    const options = ref<ListItem[]>([])
    const loading = ref(false)

    const remoteMethod = (query: string) => {
        console.log(query, props.find_phone)
        if (query) {
            loading.value = true
            axios.post(props.find_phone, {phone: query}).then(response => {
                console.log(response.data);
                options.value = response.data
                loading.value = false
            });
        } else {
            options.value = []
        }
    }

    function handleMaskName(val)
    {
        /**
         * Функции маски ввода
         * Например, form.phone = func.MaskPhone(val);
         */
    }

    function onSubmit() {
        if (form.condition.all === true) {
            form.users = [];
            form.condition.payment_after = null
            form.condition.payment_before = null
            form.condition.long_days = null
        }
        if (form.finished_at !== null) form.finished_at = func.date(form.finished_at);
        router.post(props.route, form)
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
