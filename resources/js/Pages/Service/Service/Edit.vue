<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ service.name }}</h1>
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
            <el-button type="primary" plain @click="onSubmit(false)" :disabled="!isUnSave">Сохранить</el-button>
            <el-button type="primary" @click="onSubmit(true)" :disabled="!isUnSave">Сохранить и Закрыть</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {Head, router} from '@inertiajs/vue3'
    import {reactive, ref, watch} from 'vue'
    import {func} from "/resources/js/func.js"
    import {UploadFile} from "element-plus";
    import {useStore} from '/resources/js/store.js'
    import DisplayedFields from '@/Components/DisplayedFields.vue'
    import UploadImageFile from '@/Components/UploadImageFile.vue'

    const store = useStore()
    const props = defineProps({
        errors: Object,
        route: String,
        service: Object,
        title: {
            type: String,
            default: 'Редактирование услуги',
        },
        image: String,
        icon: String,
        classifications: Array,
        templates: Array,
        tiny_api: String,
    });
    const form = reactive({
        name: props.service.name,
        classification_id: props.service.classification_id,
        slug: props.service.slug,
        meta: props.service.meta,
        breadcrumb: props.service.breadcrumb,

        awesome: props.service.awesome,
        image: null,
        icon: null,
        price: props.service.price,
        duration: props.service.duration,
        template: props.service.template,
        data: props.service.data,
        text: props.service.text,
        close: null,
        _method: 'put',
        clear_image: false,
        clear_icon: false,
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
            }
        });
    }
    ////<=
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
    import Editor from '@tinymce/tinymce-vue'
    export default {
        components: {
            'editor': Editor,
        },
        layout: Layout,
    }
</script>
