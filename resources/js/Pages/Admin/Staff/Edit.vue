<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ staff.name }} </h1>
    <div class="mt-3 p-3 bg-white rounded-lg">

        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <el-form-item label="Логин" :rules="{required: true}">
                        <el-input v-model="form.name" placeholder="Только латиница и цифры" @input="handleMaskLogin"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Телефон" :rules="{required: true}">
                        <el-input v-model="form.phone" placeholder="80000000000" @input="handleMaskPhone"/>
                        <div v-if="errors.phone" class="text-red-700">{{ errors.phone }}</div>
                    </el-form-item>
                    <el-form-item label="Новый Пароль">
                        <el-input v-model="form.password" type="password" show-password/>
                        <div v-if="errors.password" class="text-red-700">{{ errors.password }}</div>
                    </el-form-item>
                    <el-divider/>
                    <el-form-item label="ID Телеграм-бота">
                        <el-input v-model="form.telegram_user_id"/>
                        <div v-if="errors.telegram_user_id" class="text-red-700">{{ errors.telegram_user_id }}</div>
                    </el-form-item>
                    <el-form-item label="Должность" :rules="{required: true}">
                        <el-input v-model="form.post"/>
                        <div v-if="errors.post" class="text-red-700">{{ errors.post }}</div>
                    </el-form-item>
                    <el-form-item label="Доступ" :rules="{required: true}">
                        <el-select v-model="form.role" placeholder="Select" style="width: 240px">
                            <el-option v-for="item in roles" :key="item.value" :label="item.label" :value="item.value"/>
                        </el-select>
                        <div v-if="errors.role" class="text-red-700">{{ errors.role }}</div>
                    </el-form-item>
                    <el-divider/>
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
                    <progress v-if="form.progress" :value="form.progress.percentage" max="100">
                        {{ form.progress.percentage }}%
                    </progress>
                </div>
            </div>
            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">There are unsaved form changes.</div>
        </el-form>

        <!-- File Preview -->
        <el-dialog v-model="dialogVisible">
            <img w-full :src="dialogImageUrl" alt="Preview Image"/>
        </el-dialog>
    </div>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="mt-3 mb-2 font-medium text-gray-800">Сотрудники и персонал, подключившиеся к чат-боту телеграм</div>
        <el-button type="success" @click="onGetChatID" class="mb-3">Получить список</el-button>
        <div v-for="item in chat_ids" class="mt-1 p-2 bg-gray-100">
            Имя: <span class="font-medium mr-5">{{ item.name }}</span>
            User: <span class="font-medium ml-1 mr-5">{{ item.login }}</span>
            ID: <span class="font-medium ml-1">{{ item.id }}</span>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {reactive} from 'vue'
import {router} from "@inertiajs/vue3";
import {func} from "/resources/js/func.js"

import {ref} from 'vue'
import {Delete, Download, Plus, ZoomIn} from '@element-plus/icons-vue'
import type {UploadFile} from 'element-plus'
import axios from 'axios'

const dialogImageUrl = ref('')
const dialogVisible = ref(false)
const disabled = ref(false)
const chat_ids = ref([])

const props = defineProps({
    errors: Object,
    route: String,
    chat_id: String,
    staff: Object,
    roles: Array,
    title: {
        type: String,
        default: 'Редактирование сотрудника',
    },
    photo: {
        type: String,
        default: null
    }
});
/* Загружаем фото назначенное */
let _default = [];
if (props.photo !== null) {
    _default = [{
        name: 'default',
        url: props.photo,
    }];
}
const fileList = ref<UploadFile>(_default);


const form = reactive({
    name: props.staff.name,
    phone: props.staff.phone,
    email: props.staff.email,
    password: null,
    role: props.staff.role,
    post: props.staff.post,
    telegram_user_id: props.staff.telegram_user_id,
    surname: props.staff.fullname.surname,
    firstname: props.staff.fullname.firstname,
    secondname: props.staff.fullname.secondname,
    file: null,
    _method: 'put',
    clear_file: false, //Удалить загруженное ранее фото
})


function handleMaskPhone(val) {
    form.phone = func.MaskPhone(val);
}

function handleMaskLogin(val) {
    form.name = func.MaskLogin(val);
}

function onSubmit() {
    router.post(props.route, form);
}

function onGetChatID() {
    axios.post(props.chat_id)
        .then(response => {
            chat_ids.value = response.data;
        });
}

const handleRemove = (file: UploadFile) => {
    fileList.value.splice(0, 1);
    form.clear_file = true;
}
const handlePictureCardPreview = (file: UploadFile) => {
    dialogImageUrl.value = file.url!
    dialogVisible.value = true
}

</script>
<script lang="ts">
import {Head, Link} from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'

export default {
    components: {
        Head,
    },
    layout: Layout,
}

</script>

<style>


.file-uploader-one > ul > li + div {
    display: none;
}
</style>
