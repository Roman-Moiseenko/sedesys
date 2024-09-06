<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ specialization.name }}</h1>
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
                        <el-input v-model="form.slug" placeholder="Оставьте пустым для автозаполнения"
                                  @input="handleMaskSlug"/>
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
            <div class="my-3">
                <h2 class="font-medium text-lg mb-3">Специалисты:</h2>

                <el-checkbox-group v-model="form.employees">
                    <el-checkbox v-for="employee in employees"
                                 :label="employee.fullname"
                                 :value="employee.id"
                                 :key="employee.id"
                    />
                </el-checkbox-group>
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
import DisplayedFields from '@/Components/DisplayedFields.vue'
import UploadImageFile from '@/Components/UploadImageFile.vue'


const props = defineProps({
    errors: Object,
    route: String,
    specialization: Object,
    title: {
        type: String,
        default: 'Редактирование специализации',
    },
    image: String,
    icon: String,
    employees: Array,
});

const form = reactive({
    name: props.specialization.name,
    slug: props.specialization.slug,
    meta: props.specialization.meta,
    breadcrumb: props.specialization.breadcrumb,
    awesome: props.specialization.awesome,
    image: null,
    icon: null,
    _method: 'put',
    clear_image: false,
    clear_icon: false,
    close: null,
    employees: [...props.specialization.employees.map(item => item.id)],
})
///Блок сохранения и обновления=>
const isUnSave = ref(false)
watch(
    () => ({...form}),
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
