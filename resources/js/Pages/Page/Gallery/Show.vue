<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ gallery.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-2 grid-cols-1 divide-x">
            <div class="p-4">
                <el-descriptions :column="1" border>
                    <el-descriptions-item label="Галерея">{{ gallery.name }}</el-descriptions-item>
                    <el-descriptions-item label="Ссылка">{{ gallery.slug }}</el-descriptions-item>
                    <el-descriptions-item label="Описание">{{ gallery.description }}</el-descriptions-item>
                </el-descriptions>
            </div>
            <div class="p-4">
                <div class="p-3 rounded-lg bg-sky-100 border border-sky-600">
                    <div class="font-medium mb-1 text-sky-700">Инструкция</div>
                    <div class="text-sm">
                        После добавления фотографии, чтоб <strong>установить Alt</strong> или удалить ошибочно загруженную фотографию, необходимо обновить страницу.
                    </div>
                    <div class="text-sm">В шаблоне страниц и виджетов используйте функцию <strong>photo(id, thumb)</strong> для получения ссылки</div>
                    <div class="text-sm">Для получения полных данных -  <strong>photo_std(id, thumb)</strong> возвращает объект stdClass {url, alt, title, description} </div>
                    <div class="text-sm">id - идентификатор изображения, thumb - вид карточки (mini, thumb, card, original - по-умолчанию)</div>
                    <div class="text-sm"></div>
                </div>
            </div>
        </div>

        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
        </div>
    </div>

    <div class="mt-5 p-5 bg-white rounded-lg">
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
        <el-dialog v-model="dialogVisible" width="80%">
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
import {reactive, ref} from 'vue'
import { Plus } from '@element-plus/icons-vue'
import {router} from "@inertiajs/vue3";
import type { UploadProps, UploadUserFile, UploadRawFile  } from 'element-plus'


const dialogImageUrl = ref('')
const dialogVisible = ref(false)
const dialogCopy = ref(false)
const dialogSave = ref(false)
const imageAlt = ref('')
const imageId = ref('')

const props = defineProps({
    gallery: Object,
    edit: String,
    title: {
        type: String,
        default: 'Карточка Галереи',
    },
    photos: Array,
    add: String,
    del: String,
    set: String,
});

const form = reactive({
    photo_id: null,
    alt: null,
    title: null,
    description: null,
})

const fileList = ref<UploadUserFile[]>(props.photos);

const handleRemove: UploadProps['onRemove'] = (uploadFile, uploadFiles) => {
    if (uploadFile.id !== undefined) router.post(props.del, {photo_id: uploadFile.id});
}

const handlePictureCardPreview: UploadProps['onPreview'] = (uploadFile) => {
    dialogImageUrl.value = uploadFile.url!
    form.photo_id = uploadFile.id;
    form.alt = uploadFile.alt;
    form.title = uploadFile.title;
    form.description = uploadFile.description;
    dialogVisible.value = true
}

function copyBuffer(val) {
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

<script lang="ts" >
    import { Head, Link, router } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'
    import {ref} from "vue";

    export default {
        components: {
            Head,
        },
        layout: Layout,
        methods: {
            goEdit() {
                router.get(this.$props.edit);
            },

        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },

    }

</script>

<style scoped>

</style>
