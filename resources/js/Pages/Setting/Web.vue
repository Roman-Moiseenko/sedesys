<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">{{ title }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto" style="max-width: 500px">

            <el-form-item label="Название сайта" :rules="{required: true}">
                <el-input v-model="form.name" placeholder="Название сайта"/>
                <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
            </el-form-item>
            <el-form-item label="Краткое название" :rules="{required: true}">
                <el-input v-model="form.short_name" placeholder="Для уведомлений"/>
                <div v-if="errors.short_name" class="text-red-700">{{ errors.short_name }}</div>
            </el-form-item>
            <el-form-item label="Разрешить авторизацию пользователям">
                <el-checkbox v-model="form.auth"  />
            </el-form-item>
            <el-form-item label="Авторизация по № телефона">
                <el-checkbox v-model="form.auth_phone" />
            </el-form-item>
            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
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
        web: Object,
        title: {
            type: String,
            default: 'Настройки сайта',
        }
    });

    const form = reactive({
        slug: 'web',
        name: props.web.name,
        short_name: props.web.short_name,
        auth: props.web.auth,
        auth_phone: props.web.auth_phone,
        /**
         * Добавить новые поля
         */
    })

    function onSubmit() {
        router.put(props.route, form)
    }

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
