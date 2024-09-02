<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ user.name }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto" style="max-width: 500px">
            <el-form-item label="Телефон" :rules="{required: true}">
                <el-input v-model="form.phone" placeholder="80000000000" @input="handleMaskPhone"/>
                <div v-if="errors.phone" class="text-red-700">{{ errors.phone }}</div>
            </el-form-item>
            <el-form-item label="Email">
                <el-input v-model="form.email"/>
                <div v-if="errors.email" class="text-red-700">{{ errors.email }}</div>
            </el-form-item>
            <el-form-item label="Новый пароль">
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
            <el-button type="primary" plain @click="onSubmit(false)" :disabled="!isUnSave">Сохранить</el-button>
            <el-button type="primary" @click="onSubmit(true)" :disabled="!isUnSave">Сохранить и Закрыть</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form>
    </div>
</template>


<script setup>
import {reactive, ref, watch} from 'vue'
    import {router} from "@inertiajs/vue3";
    import {func} from "/resources/js/func.js"

    const props = defineProps({
        errors: Object,
        route: String,
        user: Object,
        title: {
            type: String,
            default: 'Редактирование данных клиента',
        }
    });

    const form = reactive({
        name: props.user.name,
        phone: props.user.phone,
        email: props.user.email,
        password: null,
        surname: props.user.fullname.surname,
        firstname: props.user.fullname.firstname,
        secondname: props.user.fullname.secondname,
        address: props.user.address.address,
        close: null,
        _method: 'put',
    })

    function handleMaskPhone(val) {
        form.phone = func.MaskPhone(val);
    }
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
    router.visit(props.route, {
        method: 'post',
        data: form,
        preserveScroll: true,
        preserveState: true,
        onSuccess: page => {
            isUnSave.value = false
        },
    });
}
////<=
</script>
<script>
    import {Head} from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'
    export default {
        components: {
            Head,
        },
        layout: Layout,
    }
</script>
