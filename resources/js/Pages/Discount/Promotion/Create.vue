<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новую акцию</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <!-- Повторить поля -->
                    <el-form-item label="Название" :rules="{required: true}">
                        <el-input v-model="form.name" placeholder="Название" />
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Ссылка">
                        <el-input v-model="form.slug" placeholder="Оставьте пустым для автозаполнения" @input="handleMaskSlug"/>
                        <div v-if="errors.slug" class="text-red-700">{{ errors.slug }}</div>
                    </el-form-item>

                    <el-form-item label="Ссылка условия акции" :rules="{required: true}">
                        <el-input v-model="form.condition_url" placeholder="без домена: /page/action-condition"/>
                        <div v-if="errors.condition_url" class="text-red-700">{{ errors.condition_url }}</div>
                    </el-form-item>
                    <el-form-item label="Описание">
                        <el-input v-model="form.description" placeholder="Выводится в виджетах" type="textarea" rows="4" maxlength="250" show-word-limit/>
                        <div v-if="errors.description" class="text-red-700">{{ errors.description }}</div>
                    </el-form-item>
                    <el-form-item label="Базовая скидка в %%" :rules="{required: true}">
                        <el-input-number v-model="form.discount" placeholder="" />
                        <div v-if="errors.discount" class="text-red-700">{{ errors.discount }}</div>
                    </el-form-item>
                    <el-form-item label="Для акций по расписанию" label-position="top">
                    <el-date-picker
                        v-model="range_at"
                        type="daterange"
                        range-separator="По"
                        start-placeholder="Начало акции"
                        end-placeholder="Конец акции"
                    />
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

            <el-button type="primary" @click="onSubmit" :disabled="!isUnSave">Сохранить</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {Head} from '@inertiajs/vue3'
    import {reactive, ref, watch} from 'vue'
    import {router} from "@inertiajs/vue3";
    import {func} from "/resources/js/func.js"
    import DisplayedFields from '@/Components/DisplayedFields.vue'
    import UploadImageFile from '@/Components/UploadImageFile.vue'

    const range_at = defineModel({ default: null});
    const props = defineProps({
        errors: Object,
        route: String,
        title: {
            type: String,
            default: 'Создание promotion',
        },
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

        description: null,
        condition_url: null,
        start_at: null,
        finish_at: null,
        discount: null,
        range_at: [null, null],
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

    function handleMaskSlug(val) {
        form.slug = func.MaskSlug(val);
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


    function onSubmit() {
        if (form.range_at !== null && form.range_at.length === 2 && form.range_at[0] !== null)
            form.range_at = form.range_at.map(item => func.date(item));
        console.log(form.range_at);
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
