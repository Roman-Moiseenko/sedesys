<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ gallery.name }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto" style="max-width: 500px">

            <!-- Повторить поля -->
            <el-form-item label="Название" :rules="{required: true}">
                <el-input v-model="form.name" placeholder="Название"/>
                <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
            </el-form-item>
            <el-form-item label="Ссылка">
                <el-input v-model="form.slug" placeholder="Оставьте пустым для заполнения" @input="handleMaskSlug"/>
                <div v-if="errors.slug" class="text-red-700">{{ errors.slug }}</div>
            </el-form-item>

            <el-form-item label="Описание" :rules="{required: true}">
                <el-input v-model="form.description" placeholder="Описание" :rows="5" type="textarea"/>
                <div v-if="errors.description" class="text-red-700">{{ errors.description }}</div>
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
        gallery: Object,
        title: {
            type: String,
            default: 'Редактирование галереи',
        }
    });

    const form = reactive({
        name: props.gallery.name,
        slug: props.gallery.slug,
        description: props.gallery.description,

    })

    function handleMaskSlug(val) {
        form.slug = func.MaskSlug(val);
    }

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
