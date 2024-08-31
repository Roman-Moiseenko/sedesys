<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ review.name }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <el-form-item label="Платформа отзывов" :rules="{required: true}">
                        <el-select v-model="form.external">
                            <el-option v-for="item in externals" :value="item.value" :key="item.value" :label="item.label" />
                        </el-select>
                        <div v-if="errors.external" class="text-red-700">{{ errors.external }}</div>
                    </el-form-item>
                    <el-form-item label="Ссылка на отзыв" :rules="{required: true}">
                        <el-input v-model="form.link_review" placeholder="https://otzovik.ru/my_review"/>
                        <div v-if="errors.link_review" class="text-red-700">{{ errors.link_review }}</div>
                    </el-form-item>
                    <el-form-item label="Имя клиента" :rules="{required: true}">
                        <el-input v-model="form.user_name" placeholder=""/>
                        <div v-if="errors.user_name" class="text-red-700">{{ errors.user_name }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <el-form-item label="Услуга" :rules="{required: true}">
                        <el-select v-model="form.service_id">
                            <el-option v-for="item in services" :value="item.id" :key="item.id" :label="item.name" />
                        </el-select>
                        <div v-if="errors.service_id" class="text-red-700">{{ errors.service_id }}</div>
                    </el-form-item>

                    <el-form-item label="Персонал">
                        <el-select v-model="form.employee_id">
                            <el-option v-for="item in employees" :value="item.id" :key="item.id" :label=" func.fullName(item.fullname)" />
                        </el-select>
                        <div v-if="errors.employee_id" class="text-red-700">{{ errors.employee_id }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <el-form-item label="Рейтинг" :rules="{required: true}">
                        <el-rate v-model="form.rating" />
                        <div v-if="errors.rating" class="text-red-700">{{ errors.rating }}</div>
                    </el-form-item>
                    <el-form-item label="Отзыв" :rules="{required: true}">
                        <el-input v-model="form.text" type="textarea" :rules="{required: true}"/>
                        <div v-if="errors.text" class="text-red-700">{{ errors.text }}</div>
                    </el-form-item>
                </div>
            </div>
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
        review: Object,
        title: {
            type: String,
            default: 'Редактирование review',
        },
        externals: Array,
        services: Array,
        employees: Array,
    });

    const form = reactive({
        external: props.review.external.external,
        link_review: props.review.external.link_review,
        user_name: props.review.external.user_name,
        service_id: props.review.service_id,
        employee_id: props.review.employee_id,
        rating: props.review.rating,
        text: props.review.text,
    })

    function onSubmit() {
        router.put(props.route, form)
    }

</script>
<script lang="ts">
    import Layout from '@/Components/Layout.vue'

    export default {
        layout: Layout,
    }
</script>
