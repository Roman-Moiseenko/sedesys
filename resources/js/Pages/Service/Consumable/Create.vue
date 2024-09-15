<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новый расходный материал</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <!-- Повторить поля -->
                    <el-form-item label="Название" :rules="{required: true}">
                        <el-input v-model="form.name" placeholder="Название"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Цена" :rules="{required: true}">
                        <el-input v-model="form.price" :formatter="(value) => func.MaskInteger(value)" min="0">
                            <template #append>₽</template>
                        </el-input>
                        <div v-if="errors.price" class="text-red-700">{{ errors.price }}</div>
                    </el-form-item>
                    <el-form-item label="Кол-во">
                        <el-input v-model="form.count" placeholder="Для неограниченного оставьте пустым" :formatter="(value) => func.MaskInteger(value)"/>
                        <div v-if="errors.count" class="text-red-700">{{ errors.count }}</div>
                    </el-form-item>
                    <el-form-item label="Описание">
                        <el-input v-model="form.description" placeholder="Описание на сайт" type="textarea" rows="3"/>
                        <div v-if="errors.description" class="text-red-700">{{ errors.description }}</div>
                    </el-form-item>
                    <el-form-item label="Показывать в услуге">
                        <el-checkbox v-model="form.show"/>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <UploadImageFile
                        label="Изображение для клиента"
                        @selectImageFile="onSelectImage"
                    />
                </div>
                <div class="p-4">
                </div>
            </div>
            <el-button type="primary" @click="onSubmit" :disabled="!isUnSave">Сохранить</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {Head} from '@inertiajs/vue3'
    import {reactive, ref, watch, defineProps} from 'vue'
    import {router} from "@inertiajs/vue3";
    import {func} from "/resources/js/func.js"
    import UploadImageFile from "/resources/js/Components/UploadImageFile.vue"

    const props = defineProps({
        errors: Object,
        route: String,
        title: {
            type: String,
            default: 'Создание расходного материала',
        },
    });

    const form = reactive({
        name: null,
        description: null,
        price: null,
        count: null,
        show: null,
        clear_image: null,
        image: null,
    })

    function onSubmit() {
        router.post(props.route, form)
    }
    function onSelectImage(val) {
        form.clear_image = val.clear_file;
        form.image = val.file
    }

    ///Блок сохранения и обновления=>
    const isUnSave = ref(false)
    watch(
        () => ({...form}),
        function (newValue, oldValue) {
            isUnSave.value = true
        },
        {deep: true}
    );
</script>
<script lang="ts">
import Layout from '@/Components/Layout.vue'

export default {
    layout: Layout,
}
</script>
