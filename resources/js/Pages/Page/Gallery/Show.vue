<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ gallery.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-2 grid-cols-1 divide-x">
            <div class="p-4">
                <div class="truncate sm:whitespace-normal flex items-center">
                    Галерея&nbsp;<span class="font-medium ml-6">{{ gallery.name}}</span>
                </div>
            <div class="truncate sm:whitespace-normal flex items-center">
                Ссылка&nbsp;<span class="font-medium ml-6">{{ gallery.slug}}</span>
            </div>
            <div class="font-medium mt-1">
                {{ gallery.description }}
            </div>
            </div>
            <div class="p-4">
                <div class="p-3 rounded-lg bg-cyan-100 border border-cyan-600">
                    <div class="font-medium mb-1">Инструкция</div>
                    <div class="text-sm">
                        При добавлении фотографии, чтоб <strong>установить Alt</strong> или удалить ошибочно загруженную фотографию, необходимо обновить страницу.
                    </div>
                    <div class="text-sm">В шаблоне страниц и виджетов используйте функцию <strong>photo(id, thumb)</strong></div>
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

        <el-dialog v-model="dialogVisible" width="80%"

        >
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
                    </el-form>
                    <div class="mt-3">
                        <span>{{ dialogImageUrl }}</span>
                        <el-button type="success" class="text-sm mt-2">Скопировать Url</el-button>
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

function onSubmit() {
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
