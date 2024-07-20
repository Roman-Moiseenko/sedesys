<template>
    <h1 class="font-medium text-xl">Добавить нового сотрудника</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto" style="max-width: 500px">
            <el-form-item label="Логин" :rules="{required: true}">
                <el-input v-model="form.name" placeholder="Только латиница и цифры" @input="handleMaskLogin"/>
                <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
            </el-form-item>
            <el-form-item label="Телефон" :rules="{required: true}">
                <el-input v-model="form.phone" placeholder="80000000000" @input="handleMaskPhone"/>
                <div v-if="errors.phone" class="text-red-700">{{ errors.phone }}</div>
            </el-form-item>
            <el-form-item label="Пароль" :rules="{required: true}">
                <el-input v-model="form.password"/>
                <div v-if="errors.password" class="text-red-700">{{ errors.password }}</div>
            </el-form-item>
            <el-divider />
            <el-form-item label="ID Телеграм-бота">
                <el-input v-model="form.telegram_user_id"/>
                <div v-if="errors.telegram_user_id" class="text-red-700">{{ errors.telegram_user_id }}</div>
            </el-form-item>
            <el-form-item label="Должность" :rules="{required: true}">
                <el-input v-model="form.post"/>
                <div v-if="errors.post" class="text-red-700">{{ errors.post }}</div>
            </el-form-item>
            <el-form-item label="Доступ" :rules="{required: true}">
                <el-select v-model="form.role" placeholder="Select" style="width: 240px">
                    <el-option v-for="item in roles" :key="item.value" :label="item.label" :value="item.value"/>
                </el-select>
                <div v-if="errors.role" class="text-red-700">{{ errors.role }}</div>
            </el-form-item>
            <el-divider />
            <el-form-item label="Фамилия" :rules="{required: true}">
                <el-input v-model="form.surname"/>
                <div v-if="errors.surname" class="text-red-700">{{ errors.surname }}</div>
            </el-form-item>
            <el-form-item label="Имя" :rules="{required: true}">
                <el-input v-model="form.firstname"/>
                <div v-if="errors.firstname" class="text-red-700">{{ errors.firstname }}</div>
            </el-form-item>
            <el-form-item label="Отчество">
                <el-input v-model="form.secondname"/>
                <div v-if="errors.secondname" class="text-red-700">{{ errors.secondname }}</div>
            </el-form-item>

            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">There are unsaved form changes.</div>
        </el-form>
    </div>
</template>


<script setup>
import {reactive} from 'vue'
import {router} from "@inertiajs/vue3";
import {func} from "/resources/js/func.js"

const props = defineProps({
    errors: Object,
    route: String,
    roles: Array
});

const form = reactive({
    name: null,
    phone: null,
    email: null,
    password: null,
    role: null,
    post: null,
    telegram_user_id: null,
    surname: null,
    firstname: null,
    secondname: null
})

function handleMaskPhone(val)
{
    form.phone = func.MaskPhone(val);
}

function handleMaskLogin(val)
{
    form.name = func.MaskLogin(val);
}
function onSubmit() {
    router.post(props.route, form)
}

</script>
<script>
import {Head, Link} from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'
import { router } from "@inertiajs/vue3";

export default {
    components: {
        Head,
    },
    layout: Layout,
}
</script>
