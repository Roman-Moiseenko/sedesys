<template>
    <h1 class="font-medium text-xl">Добавить нового сотрудника</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto" style="max-width: 500px">
            <el-form-item label="Логин">
                <el-input v-model="form.name" placeholder="Только латиница и цифры" @input="handleMaskLogin"/>
                <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
            </el-form-item>
            <el-form-item label="Телефон">
                <el-input v-model="form.phone" placeholder="80000000000"
                          @input="handleMaskPhone"
                />
            </el-form-item>
            <el-form-item label="Пароль">
                <el-input v-model="form.password"/>
            </el-form-item>
            <el-divider />
            <el-form-item label="ID Телеграм-бота">
                <el-input v-model="form.telegram_user_id"/>
            </el-form-item>
            <el-form-item label="Должность">
                <el-input v-model="form.post"/>
            </el-form-item>
            <el-form-item label="Доступ">
            <el-select
                v-model="form.role"
                placeholder="Select"
                style="width: 240px"
            >
                <el-option
                    v-for="item in roles"
                    :key="item.value"
                    :label="item.label"
                    :value="item.value"
                />
            </el-select>
            </el-form-item>
            <el-divider />

            <el-form-item label="Фамилия">
                <el-input v-model="form.surname"/>
            </el-form-item>
            <el-form-item label="Имя">
                <el-input v-model="form.firstname"/>
            </el-form-item>
            <el-form-item label="Отчество">
                <el-input v-model="form.secondname"/>
            </el-form-item>

            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
        </el-form>
    </div>
</template>


<script setup>
import {reactive} from 'vue'
import {router} from "@inertiajs/vue3";
///^\d{3}-\d{3}-\d{4}$/
const props = defineProps({
    errors: Object,
    route: String,
    staff: null,
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
    if (val.length === 1) {
        if (val === '+') val = '8';
        if (val !== '8') val = '';
    }
    if (val.length > 1 && val.length < 12) {
        if (val.slice(-1).match(/\d+/g) === null)
            val = val.substring(0, val.length - 1);
    }
    if (val.length >= 12) val = val.substring(0, val.length - 1);
    form.phone = val;
}

function handleMaskLogin(val)
{
    let last = val.slice(-1);
    if (last.match(/\d+/g) === null && last.match(/[a-z]/i) === null) {
        val = val.substring(0, val.length - 1);
    }
    form.name = val;
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
    props: {

    },
}
</script>

<style scoped>

</style>
