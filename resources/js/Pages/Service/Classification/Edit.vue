<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ classification.name }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">

            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <!-- Повторить поля -->
                    <el-form-item label="Родительская категория" :rules="{required: true}">
                        <el-select v-model="form.parent_id" placeholder="Select" style="width: 240px">
                            <el-option v-for="item in classifications" :key="item.value" :label="item.label" :value="item.value"/>
                        </el-select>
                        <div v-if="errors.parent_id" class="text-red-700">{{ errors.parent_id }}</div>
                    </el-form-item>
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
            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {Head, router} from '@inertiajs/vue3'
    import {reactive, ref} from 'vue'
    import {func} from "/resources/js/func.js"
    import DisplayedFields from '@/Components/DisplayedFields.vue'
    import UploadImageFile from '@/Components/UploadImageFile.vue'

    const props = defineProps({
        errors: Object,
        route: String,
        classification: Object,
        title: {
            type: String,
            default: 'Редактирование classification',
        },
        image: String,
        icon: String,
        classifications: Array,
    });

    const form = reactive({
        parent_id: props.classification.parent_id,
        name: props.classification.name,
        slug: props.classification.slug,
        meta: props.classification.meta,
        breadcrumb: props.classification.breadcrumb,
        awesome: props.classification.awesome,
        image: null,
        icon: null,
        _method: 'put',
        clear_image: false,
        clear_icon: false,
    })

    function onSubmit() {
        router.post(props.route, form)
    }
    function handleMaskSlug(val) {
        form.slug = func.MaskSlug(val);
    }
    function onSelectImage(val) {
        form.clear_image = val.clear_file;
        form.image = val.file
    }
    function onSelectIcon(val) {
        form.clear_icon = val.clear_file;
        form.icon = val.file
    }
</script>
<script lang="ts">
    import Layout from '@/Components/Layout.vue'

    export default {
        layout: Layout,
    }
</script>
