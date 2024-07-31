<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новый контакт</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto" style="max-width: 500px">

            <el-form-item label="Название" :rules="{required: true}">
                <el-input v-model="form.name" placeholder="Внутреннее название" />
                <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
            </el-form-item>
            <el-form-item label="Описание">
                <el-input v-model="form.title" placeholder="Описание по наведению курсора"/>
                <div v-if="errors.title" class="text-red-700">{{ errors.title }}</div>
            </el-form-item>
            <el-form-item label="Иконка">
                <el-input v-model="form.icon" placeholder="Font Awesome"/>
                <div v-if="errors.icon" class="text-red-700">{{ errors.icon }}</div>
            </el-form-item>
            <el-form-item label="Цвет иконки">
                <el-color-picker v-model="form.color"/>
                <div v-if="errors.color" class="text-red-700">{{ errors.color }}</div>
            </el-form-item>
            <el-form-item label="Ссылка">
                <el-input v-model="form.url" placeholder=""/>
                <div v-if="errors.url" class="text-red-700">{{ errors.url }}</div>
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
        title: {
            type: String,
            default: 'Создание контакта',
        }
    });

    const form = reactive({
        name: null,
        title: null,
        icon: null,
        color: null,
        url: null,
    })


    function onSubmit() {
        router.post(props.route, form)
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
