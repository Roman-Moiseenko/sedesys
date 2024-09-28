<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить нового клиента</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto" style="max-width: 500px">
            <el-form-item label="Телефон" :rules="{required: true}">
                <el-input v-model="form.phone" placeholder="80000000000" :formatter="(val) => func.MaskPhone(val)"/>
                <div v-if="errors.phone" class="text-red-700">{{ errors.phone }}</div>
            </el-form-item>
            <el-form-item label="Email">
                <el-input v-model="form.email"/>
                <div v-if="errors.email" class="text-red-700">{{ errors.email }}</div>
            </el-form-item>
            <el-form-item label="Пароль" :rules="{required: true}">
                <el-input v-model="form.password" type="password" show-password/>
                <div v-if="errors.password" class="text-red-700">{{ errors.password }}</div>
            </el-form-item>
            <el-form-item label="Фамилия">
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
            <el-form-item label="Адрес">
                <el-input v-model="form.address" placeholder="Адрес"/>
                <div v-if="errors.address" class="text-red-700">{{ errors.address }}</div>
            </el-form-item>
            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {reactive} from 'vue'
    import {Head, router} from "@inertiajs/vue3";
    import {func} from "/resources/js/func.js"

    const props = defineProps({
        errors: Object,
        title: {
            type: String,
            default: 'Добавить клиента',
        }
    });
    const form = reactive({
        phone: null,
        email: null,
        password: null,
        surname: null,
        firstname: null,
        secondname: null,
        address: null,
    })
    function onSubmit() {
        router.post(route('admin.user.user.store'), form)
    }
</script>

