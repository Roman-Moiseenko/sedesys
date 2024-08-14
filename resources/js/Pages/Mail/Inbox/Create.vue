<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новый inbox</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto" style="max-width: 500px">

            <!-- Повторить поля -->
            <el-form-item label="Название" :rules="{required: true}">
                <el-input v-model="form.name" placeholder="Название" @input="handleMaskName"/>
                <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
            </el-form-item>


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
            default: 'Создание inbox',
        },
    });

    const form = reactive({
        name: null,
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
