<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ staff.fullname.surname }} </h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <Form v-bind:form="form" :route="route">

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
                        <el-input v-model="form.password" type="password" show-password autocomplete="new-password"/>
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
                    <UploadImageFile
                        label="Фото сотрудника на аватар"
                        v-model:image="$props.photo"
                        @selectImageFile="onSelectImage"
                    />
                </div>
            </div>
        </Form>
        <!--el-form :model="form" label-width="auto">
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
                        <el-input v-model="form.password" type="password" show-password autocomplete="new-password"/>
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
                    <UploadImageFile
                        label="Фото сотрудника на аватар"
                        v-model:image="props.photo"
                        @selectImageFile="onSelectImage"
                    />
                </div>
            </div>

            <el-button type="primary" plain @click="onSubmit(false)" :disabled="!isUnSave">Сохранить</el-button>
            <el-button type="primary" @click="onSubmit(true)" :disabled="!isUnSave">Сохранить и Закрыть</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form-->
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

</script>
<script lang="ts">
import {Head, Link} from '@inertiajs/vue3'
import {router} from "@inertiajs/vue3";
import {func} from "/resources/js/func.js"
import {Delete, Download, Plus, ZoomIn} from '@element-plus/icons-vue'
import axios from 'axios'
import UploadImageFile from '@/Components/UploadImageFile.vue'
import Form from '@/Components/Form.vue'
import {reactive} from "vue";

export default {
    components: {
        Head,
        Form,
        UploadImageFile, Delete, Download, Plus, ZoomIn
    },
    props: {
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
        },

    },
    data() {
        return {
            chat_ids: [],
            form: {
                name: this.$props.staff.name,
                phone: this.$props.staff.phone,
                email: this.$props.staff.email,
                password: null,
                role: this.$props.staff.role,
                post: this.$props.staff.post,
                telegram_user_id: this.$props.staff.telegram_user_id,
                surname: this.$props.staff.fullname.surname,
                firstname: this.$props.staff.fullname.firstname,
                secondname: this.$props.staff.fullname.secondname,
                file: null,
                // close: null,
                _method: 'put',
                clear_file: false, //Удалить загруженное ранее фото
            }
        }
    },
    methods: {
        handleMaskPhone(val) {
            this.$data.form.phone = func.MaskPhone(val);
        },

        handleMaskLogin(val) {
            this.$data.form.name = func.MaskLogin(val);
        },
        onGetChatID() {
            axios.post(this.$props.chat_id)
                .then(response => {
                    this.$data.chat_ids.value = response.data;
                });
        },
        onSelectImage(val) {
            this.$data.form.clear_file = val.clear_file;
            this.$data.form.file = val.file
        },
    },
}

</script>

<style>


.file-uploader-one > ul > li + div {
    display: none;
}
</style>
