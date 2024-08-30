<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новую специальность</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <!-- Повторить поля -->
                    <el-form-item label="Название" :rules="{required: true}">
                        <el-input v-model="form.name" placeholder="Название"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Ссылка">
                        <el-input v-model="form.slug" placeholder="Оставьте пустым для автозаполнения" @input="handleMaskSlug"/>
                        <div v-if="errors.slug" class="text-red-700">{{ errors.slug }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <DisplayedFields
                        :errors="errors"
                        v-model:meta="form.meta"
                        v-model:breadcrumb="form.breadcrumb"
                        v-model:awesome="form.awesome"
                    />

                </div>
                <div class="p-4">
                    <UploadImageFile
                        label="Изображение для каталога"
                        v-model:image="props.image"
                        @selectImageFile="onSelectImage"
                    />
                    <UploadImageFile
                        label="Иконка для меню"
                        v-model:image="props.icon"
                        @selectImageFile="onSelectIcon"
                    />
                </div>
            </div>
            <div class="mt-3">
                <h2 class="font-medium text-lg mb-3">Специалисты:</h2>
                <div v-for="employee in employees">
                    <el-checkbox v-model="form.employees" :label="employee.fullname"
                                 type="checkbox" :checked="employee.checked"
                                 :value="employee.id"
                    />
                </div>
            </div>
            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {Head, router} from '@inertiajs/vue3'
    import {reactive, ref} from 'vue'
    import {func} from "/resources/js/func.js"
    import {UploadFile} from "element-plus";
    import {useStore} from '/resources/js/store.js'
    import DisplayedFields from '@/Components/DisplayedFields.vue'
    import UploadImageFile from '@/Components/UploadImageFile.vue'

    const store = useStore();

    const props = defineProps({
        errors: Object,
        route: String,
        title: {
            type: String,
            default: 'Создание новой специальности',
        },
        employees: Array,
    });

    const form = reactive({
        name: null,
        slug: null,
        meta: {
            h1: null,
            title: null,
            description: null,
        },
        breadcrumb: {
            photo_id: null,
            caption: null,
            description: null,
        },
        awesome: null,
        image: null,
        icon: null,
        employees: [],

    })
    function handleMaskSlug(val)
    {
        form.slug = func.MaskSlug(val);
    }

    function onSubmit() {
        router.post(props.route, form)
    }

    function onSelectImage(val) {
        form.image = val.file
    }
    function onSelectIcon(val) {
        form.icon = val.file
    }

</script>
<script lang="ts">
    import Layout from '@/Components/Layout.vue'

    export default {
        layout: Layout,
    }
</script>
