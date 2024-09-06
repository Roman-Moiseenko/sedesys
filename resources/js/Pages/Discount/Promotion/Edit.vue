<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ promotion.name }}</h1>
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
                            v-model="form.range_at"
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

            <el-button type="primary" plain @click="onSubmit(false)" :disabled="!isUnSave">Сохранить</el-button>
            <el-button type="primary" @click="onSubmit(true)" :disabled="!isUnSave">Сохранить и Закрыть</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {Head, router} from '@inertiajs/vue3'
    import {reactive, defineProps, watch, ref} from 'vue'
    import {func} from "/resources/js/func.js"
    import DisplayedFields from '@/Components/DisplayedFields.vue'
    import UploadImageFile from '@/Components/UploadImageFile.vue'



    const props = defineProps({
        errors: Object,
        route: String,
        promotion: Object,
        title: {
            type: String,
            default: 'Редактирование promotion',
        },
        image: String,
        icon: String,
    });

    const form = reactive({
        /*
        name: props.promotion.name,
        slug: props.promotion.slug,
        meta: props.promotion.meta,
        breadcrumb: props.promotion.breadcrumb,
        awesome: props.promotion.awesome,
        image: props.promotion.image,
        icon: props.promotion.icon,

        description: props.promotion.description,
        condition_url: props.promotion.condition_url,
        start_at: props.promotion.start_at,
        finish_at: props.promotion.finish_at,
        discount: props.promotion.discount,
        */
        ...props.promotion,
        //Images props
        image: null,
        icon: null,
        _method: 'put',
        clear_image: false,
        clear_icon: false,
        close: null,
        range_at: [],
    })
    form.range_at.push(form.start_at, form.finish_at)
    //if (form.start_at !== null && form.)
    //const range_at = reactive({ ...props.promotion.start_at, ...props.promotion.finish_at});
    //console.log(range_at);
    function handleMaskName(val)
    {
        /**
         * Функции маски ввода
         * Например, form.phone = func.MaskPhone(val);
         */
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
        if (form.range_at !== null && form.range_at.length === 2 && form.range_at[0] !== null)
            form.range_at = form.range_at.map(item => func.date(item));

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

    export default {
        layout: Layout,
    }
</script>
