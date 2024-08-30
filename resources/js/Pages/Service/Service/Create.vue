<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новую услугу</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <!-- Повторить поля -->
                    <el-form-item label="Классификация">
                        <el-select v-model="form.classification_id" placeholder="Select" style="width: 240px">
                            <el-option v-for="item in classifications" :key="item.value" :label="item.label" :value="item.value"/>
                        </el-select>
                        <div v-if="errors.classification_id" class="text-red-700">{{ errors.classification_id }}</div>
                    </el-form-item>
                    <el-form-item label="Название" :rules="{required: true}">
                        <el-input v-model="form.name" placeholder="Название"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Ссылка">
                        <el-input v-model="form.slug" placeholder="Оставьте пустым для автозаполнения" @input="handleMaskSlug"/>
                        <div v-if="errors.slug" class="text-red-700">{{ errors.slug }}</div>
                    </el-form-item>
                    <el-form-item label="Шаблон">
                        <el-select v-model="form.template" placeholder="Select" style="width: 240px">
                            <el-option v-for="item in templates" :key="item.value" :label="item.label" :value="item.value"/>
                        </el-select>
                        <div v-if="errors.template" class="text-red-700">{{ errors.template }}</div>
                    </el-form-item>
                    <el-form-item label="Цена">
                        <el-input v-model="form.price" placeholder="В рублях" @input="handleMaskPrice">
                            <template #append>₽</template>
                        </el-input>
                        <div v-if="errors.price" class="text-red-700">{{ errors.price }}</div>
                    </el-form-item>
                    <el-form-item label="Длительность">
                        <el-input v-model="form.duration" placeholder="В минутах" @input="handleMaskDuration">
                            <template #append>мин</template>
                        </el-input>
                        <div v-if="errors.duration" class="text-red-700">{{ errors.duration }}</div>
                    </el-form-item>
                    <el-form-item label="Опции">
                        <el-input v-model="form.data" placeholder="В формате JSON [{}]" :rows="5" type="textarea"/>
                        <div v-if="errors.data" class="text-red-700">{{ errors.data }}</div>
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
            <div class="w-full mt-3 mb-5">
                <!-- TinyMCE -->
                <editor
                    :api-key="$props.tiny_api" v-model="form.text"
                    :init="store.tiny"
                />
                <div v-if="errors.text" class="text-red-700">{{ errors.text }}</div>
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
            default: 'Создание услуги',
        },
        classifications: Array,
        templates: Array,
        tiny_api: String,
    });

    const form = reactive({
        name: null,
        classification_id: null,
        slug: null,
        awesome: null,
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
        image: null,
        icon: null,
        price: null,
        duration: null,
        template: null,
        data: null,
        text: null,
    })

    function handleMaskSlug(val) {
        form.slug = func.MaskSlug(val);
    }
    function handleMaskPrice(val) {
        form.price = func.MaskInteger(val);
    }
    function handleMaskDuration(val) {
        form.duration = func.MaskInteger(val);
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
    import Editor from '@tinymce/tinymce-vue'

    export default {
        components: {
            'editor': Editor,
        },
        layout: Layout,
    }
</script>
