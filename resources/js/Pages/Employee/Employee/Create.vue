<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить Персонал</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <el-form-item label="Телефон" :rules="{required: true}">
                        <el-input v-model="form.phone" placeholder="80000000000" @input="handleMaskPhone"/>
                        <div v-if="errors.phone" class="text-red-700">{{ errors.phone }}</div>
                    </el-form-item>
                    <el-form-item label="Пароль" :rules="{required: true}">
                        <el-input v-model="form.password"/>
                        <div v-if="errors.password" class="text-red-700">{{ errors.password }}</div>
                    </el-form-item>
                    <el-divider/>
                    <el-form-item label="ID Телеграм-бота">
                        <el-input v-model="form.telegram_user_id"/>
                        <div v-if="errors.telegram_user_id" class="text-red-700">{{ errors.telegram_user_id }}</div>
                    </el-form-item>
                    <el-form-item label="Фамилия" :rules="{required: true}">
                        <el-input v-model="form.surname"/>
                        <div v-if="errors.surname" class="text-red-700">{{ errors.surname }}</div>
                    </el-form-item>
                    <el-form-item label="Имя" :rules="{required: true}">
                        <el-input v-model="form.firstname"/>
                        <div v-if="errors.firstname" class="text-red-700">{{ errors.firstname }}</div>
                    </el-form-item>
                    <el-form-item label="Отчество">
                        <el-input v-model="form.secondname"/>
                        <div v-if="errors.secondname" class="text-red-700">{{ errors.secondname }}</div>
                    </el-form-item>
                    <el-form-item label="Адрес">
                        <el-input v-model="form.address" placeholder="Адрес"/>
                        <div v-if="errors.address" class="text-red-700">{{ errors.address }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <h2 class="font-medium mb-3">Фото сотрудника на аватар</h2>
                    <!-- FileUpload -->
                    <el-upload action="#" list-type="picture-card"
                               :limit="1"
                               :auto-upload="false"
                               v-model:fileList="fileList"
                               @input="form.file = $event.target.files[0]" :on-remove="handleRemove"
                               class="file-uploader-one"
                               ref="template"
                    >
                        <el-icon>
                            <Plus/>
                        </el-icon>
                        <template #file="{ file }">
                            <div>
                                <img class="el-upload-list__item-thumbnail" :src="file.url" alt=""/>
                                <span class="el-upload-list__item-actions">
                                  <span class="el-upload-list__item-preview" @click="handlePictureCardPreview(file)">
                                    <el-icon><zoom-in/></el-icon>
                                  </span>
                                  <span v-if="!disabled" class="el-upload-list__item-delete"
                                        @click="handleRemove(file)">
                                    <el-icon><Delete/></el-icon>
                                  </span>
                              </span>
                            </div>
                        </template>
                    </el-upload>
                    <!-- End FileUpload -->
                </div>

            </div>
            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
        <!-- File Preview -->
        <el-dialog v-model="dialogVisible">
            <img w-full :src="dialogImageUrl" alt="Preview Image"/>
        </el-dialog>
    </div>
</template>


<script lang="ts" setup>
import {reactive} from 'vue'
import {router} from "@inertiajs/vue3";
import {func} from "/resources/js/func.js"
import {ref} from 'vue'
import {Delete, Download, Plus, ZoomIn} from '@element-plus/icons-vue'
import type {UploadFile} from 'element-plus'

const dialogImageUrl = ref('')
const dialogVisible = ref(false)
const disabled = ref(false)
const fileList = ref<UploadFile>();

const props = defineProps({
    errors: Object,
    route: String,
    title: {
        type: String,
        default: 'Создание Персонала',
    }
});

const form = reactive({
    phone: null,
    email: null,
    password: null,
    telegram_user_id: null,
    surname: null,
    firstname: null,
    secondname: null,
    address: null,
    file: null,
})

function handleMaskPhone(val) {
    form.phone = func.MaskPhone(val);
}

function onSubmit() {
    router.post(props.route, form)
}

const handleRemove= (file: UploadFile) => {
    fileList.value.splice(0, 1);
}
const handlePictureCardPreview = (file: UploadFile) => {
    dialogImageUrl.value = file.url!
    dialogVisible.value = true
}
</script>
<script lang="ts" >
import {Head} from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'

export default {
    components: {
        Head,
    },
    layout: Layout,
}
</script>
