<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ widget.name }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">

            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <!-- Повторить поля -->
                    <el-form-item label="Название" :rules="{required: true}">
                        <el-input v-model="form.name" placeholder="Название"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>

                    <el-form-item label="Шаблон" :rules="{required: true}">
                        <el-select v-model="form.template" placeholder="Select" style="width: 240px">
                            <el-option v-for="item in templates" :key="item.value" :label="item.label" :value="item.value"/>
                        </el-select>
                        <div v-if="errors.template" class="text-red-700">{{ errors.template }}</div>
                    </el-form-item>

                    <el-form-item label="Модель данных" :rules="{required: true}">
                        <el-select v-model="form.model" placeholder="Select" style="width: 240px">
                            <el-option v-for="item in models" :key="item.value" :label="item.label" :value="item.value"/>
                        </el-select>
                        <div v-if="errors.model" class="text-red-700">{{ errors.model }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <el-form-item label="Данные">
                        <el-input v-model="form.data" placeholder="В формате JSON [{}]" :rows="5" type="textarea"/>
                        <div v-if="errors.data" class="text-red-700">{{ errors.data }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <el-form-item label="Опции">
                        <el-input v-model="form.options" placeholder="В формате JSON [{}]" :rows="5" type="textarea"/>
                        <div v-if="errors.options" class="text-red-700">{{ errors.options }}</div>
                    </el-form-item>
                </div>
            </div>


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
        widget: Object,
        title: {
            type: String,
            default: 'Редактирование виджета',
        },
        templates: Array,
        models: Array
    });

    const form = reactive({
        name: props.widget.name,
        model: props.widget.model,
        template: props.widget.template,
        data: props.widget.data,
        options: props.widget.options
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
