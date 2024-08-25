<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ example.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid grid-cols-1 divide-x">
            <div class="p-4">
                <el-descriptions :column="2" border>
                    <el-descriptions-item label="Услуга">{{ example.service.name }}</el-descriptions-item>
                    <el-descriptions-item label="Заголовок">{{ example.title }}</el-descriptions-item>
                    <el-descriptions-item label="Стоимость">{{ func.price(example.cost) }}</el-descriptions-item>
                    <el-descriptions-item label="Длительность">{{ example.duration }}</el-descriptions-item>
                    <el-descriptions-item label="Дата оказания">{{ example.date }}</el-descriptions-item>
                    <el-descriptions-item label="Персонал">
                        <el-tag type="info" class="font-medium ml-6" v-for="item in example.employees">{{ func.fullName(item.fullname)}}</el-tag>
                    </el-descriptions-item>
                    <el-descriptions-item label="Описание">{{ example.description }}</el-descriptions-item>
                </el-descriptions>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!example.active" type="success" @click="handleToggle">Показывать на сайте
            </el-button>
            <el-button v-if="example.active" type="warning" @click="handleToggle">Скрыть из показа
            </el-button>
        </div>
    </div>

    <div class="mt-5 p-5 bg-white rounded-lg">
        <h2 class="font-medium text-lg mb-3">Галерея:</h2>
        <el-upload
            v-model:file-list="fileList"
            :action="add"
            list-type="picture-card"
            :on-preview="handlePictureCardPreview"
            :on-remove="handleRemove"
            :headers="{'X-CSRF-TOKEN': csrf}"
        >
            <el-icon><Plus /></el-icon>
        </el-upload>
        <el-dialog v-model="dialogGallery" width="80%">
            <div class="flex">
                <div style="width: 80%" class="grid">
                    <img w-full :src="dialogImageUrl" alt="Preview Image" class="mx-auto"/>
                </div>
                <div class="bg-gray-100 p-2 border border-gray-300" style="width: 20%">
                    <el-form :model="form" label-width="auto">
                        <el-form-item label="ID фото">
                            <el-input v-model="form.photo_id"  readonly />
                        </el-form-item>
                        <el-form-item label="Alt для фото" label-position="top">
                            <el-input v-model="form.alt" placeholder="Напишите Alt для SEO" />
                        </el-form-item>
                        <el-form-item label="Заголовок" label-position="top">
                            <el-input v-model="form.title" placeholder="Заголовок" />
                        </el-form-item>
                        <el-form-item label="Описание" label-position="top">
                            <el-input v-model="form.description" placeholder="Описание" type="textarea" :rows="3"/>
                        </el-form-item>
                        <el-button type="primary" @click="onSubmit">Сохранить</el-button>
                        <span v-if="dialogSave" class="text-lime-500 text-sm ml-3">Сохранено</span>
                    </el-form>
                    <div class="mt-5">
                        <el-input v-model="dialogImageUrl"  readonly />
                        <el-button id="copy_buffer" type="success" class="text-sm mt-2" @click="copyBuffer" plain>Скопировать Url</el-button>
                        <span v-if="dialogCopy" class="text-lime-500 text-sm ml-3">Скопировано</span>
                    </div>
                </div>
            </div>
        </el-dialog>
    </div>

</template>

<script lang="ts" setup>
import {Head, Link, router} from '@inertiajs/vue3'
    import { func} from '@/func.js'
    import type { UploadProps, UploadUserFile, UploadRawFile  } from 'element-plus'
    import {reactive, ref} from 'vue'
    import { Plus } from '@element-plus/icons-vue'

    const dialogImageUrl = ref('')
    const dialogGallery = ref(false)
    const dialogCopy = ref(false)
    const dialogSave = ref(false)
    const imageAlt = ref('')
    const imageId = ref('')

    const props = defineProps({
        example: Object,
        edit: String,
        title: {
            type: String,
            default: 'Карточка Примера работ',
        },
        gallery: Array,
        add: String,
        del: String,
        set: String,
        toggle: String,
    });
    const form = reactive({
        photo_id: null,
        alt: null,
        title: null,
        description: null,
    })
    const fileList = ref<UploadUserFile[]>(props.gallery);

    const handleRemove: UploadProps['onRemove'] = (uploadFile, uploadFiles) => {
        if (uploadFile.id !== undefined) router.post(props.del, {photo_id: uploadFile.id});
    }
    const handlePictureCardPreview: UploadProps['onPreview'] = (uploadFile) => {
        dialogImageUrl.value = uploadFile.url!
        form.photo_id = uploadFile.id;
        form.alt = uploadFile.alt;
        form.title = uploadFile.title;
        form.description = uploadFile.description;
        dialogGallery.value = true
    }
    function copyBuffer(val) {
    console.log(val);
    dialogCopy.value = true;
    setTimeout(() => {
        dialogCopy.value = false;
    }, 2000);
    navigator.clipboard.writeText(dialogImageUrl.value);
}
    function onSubmit() {
        dialogSave.value = true;
        setTimeout(() => {
            dialogSave.value = false;
        }, 2000);
        router.post(props.set, form);
    }


</script>
<script lang="ts">
    import { router } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'

    export default {
        layout: Layout,
        methods: {
            goEdit() {
                router.get(this.$props.edit);
            },
            handleToggle(val) {
                router.post(this.$props.toggle);
            }
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
    }

</script>

<style>

</style>
