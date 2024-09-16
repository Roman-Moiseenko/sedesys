<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новую запись</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-6 grid-cols-1 divide-x">
                <div class="p-4 col-span-2">
                    <!-- Повторить поля -->
                    <el-form-item label="Услуга" :rules="{required: true}">
                        <el-select v-model="form.service_id" placeholder="Название" @change="handleService">
                            <el-option v-for="item in services" :value="item.id" :key="item.id" :label="item.name"/>
                        </el-select>
                        <div v-if="errors.service_id" class="text-red-700">{{ errors.service_id }}</div>
                    </el-form-item>
                    <el-config-provider :locale="ru" >
                        <el-calendar v-model="form.date"  @click="handleService"  />
                    </el-config-provider>
                </div>
                <div class="p-4 col-span-4">
                    <div class="flex">
                        <el-form-item label="Телефон" :rules="{required: true}">
                            <el-input v-model="form.phone"  placeholder="80000000000" @input="handleMaskPhone" />
                        </el-form-item>
                        <el-form-item label="Имя" :rules="{required: true}">
                            <el-input v-model="form.user"  placeholder="" />
                        </el-form-item>
                        <el-button type="primary" @click="onSubmit" class="ml-3">Записать</el-button>
                    </div>
                    <div class="flex mb-3">
                        <el-input v-model="form.comment"  placeholder="Комментарий к заказу" type="textarea" rows="2" />
                    </div>
                    <h2 v-if="info"> {{ info.service }} <span class="font-medium">{{ info.date }}</span></h2>
                    <div v-for="item in rules">
                        <el-radio-group  v-model="form.time" size="large"  @change="handleTime">
                            <el-form-item :label="item.fullname" class="mt-3 font-medium text-lg" label-position="top" >
                                <el-radio type="success" v-for="time in item.times" :label="time" :value="'['+item.id+']'+time" border class="mt-2" />
                            </el-form-item>
                        </el-radio-group>
                    </div>
                </div>
            </div>



        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {Head} from '@inertiajs/vue3'
    import {reactive} from 'vue'
    import {router} from "@inertiajs/vue3";
    import { usePage } from '@inertiajs/vue3'
    import {func} from "/resources/js/func.js"
    import axios from "axios";
    import ru from 'element-plus/dist/locale/ru.mjs'
    import 'element-plus/es/components/message/style/css'; // this is only needed if the page also used ElMessage
    import 'element-plus/es/components/message-box/style/css';
    import {ElMessage} from "element-plus";

    const url = usePage().url
    const props = defineProps({
        errors: Object,
        //route: String,
        title: {
            type: String,
            default: 'Записать клиента',
        },
        services: Array,
        //employees: Array,
        rules: Array,
        info: Array,
    });

    const form = reactive({
        service_id: null,
        time: null,
        date: null,
        mode: null,
        phone: null,
        user: null,
        comment: null,
        /**
         * Добавить новые поля
         */
    })

    function handleService() {
        form.mode = 'get';
        console.log(form.date);
        if (form.date !== null && form.service_id !== null) {
            router.post(url, form)
        }
    }

    function handleTime(val) {
        console.log(val)
    }
    function handleMaskPhone(val) {
        form.phone = func.MaskPhone(val);
    }
    function onSubmit() {
        form.mode = 'save';
        if (form.date !== null && form.service_id !== null && form.time !== null && form.phone !== null) {
            router.post(url, form)
        } else {
            ElMessage({
                message: 'Не все данные заполнены',
                type: 'error',
                plain: true,
                showClose: true,
                duration: 7000,
                center: true,
            });
        }
    }

</script>

