<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ employee.name }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
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
                    <el-divider/>
                    <el-form-item label="Телефон" :rules="{required: true}">
                        <el-input v-model="form.phone" placeholder="80000000000" @input="handleMaskPhone"/>
                        <div v-if="errors.phone" class="text-red-700">{{ errors.phone }}</div>
                    </el-form-item>
                    <el-form-item label="ID Телеграм-бота">
                        <el-input v-model="form.telegram_user_id"/>
                        <div v-if="errors.telegram_user_id" class="text-red-700">{{ errors.telegram_user_id }}</div>
                    </el-form-item>
                    <el-form-item label="Адрес">
                        <el-input v-model="form.address" placeholder="Адрес"/>
                        <div v-if="errors.address" class="text-red-700">{{ errors.address }}</div>
                    </el-form-item>
                    <el-form-item label="Пароль">
                        <el-input v-model="form.password" type="password" show-password/>
                        <div v-if="errors.password" class="text-red-700">{{ errors.password }}</div>
                    </el-form-item>
                    <el-form-item label="Стаж с какого года" :rules="{required: true}">
                        <el-input v-model="form.experience_year"/>
                        <div v-if="errors.experience_year" class="text-red-700">{{ errors.experience_year }}</div>
                    </el-form-item>
                    <el-divider/>
                    <h2 class="font-medium mb-3">Специализация</h2>
                    <div v-for="specialization in specializations">
                        <el-checkbox v-model="form.specializations" :label="specialization.name"
                                     type="checkbox" :checked="specialization.checked"
                                     :value="specialization.id"
                        />
                    </div>
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
                <div class="p-4">
                    <DisplayedFields
                        :errors="errors"
                        v-model:meta="form.meta"
                        v-model:breadcrumb="form.breadcrumb"
                        v-model:awesome="form.awesome"
                    />

                </div>
            </div>
            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
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
    import {reactive, defineProps, ref} from 'vue'
    import {router} from "@inertiajs/vue3";
    import {func} from "/resources/js/func.js"
    import axios from 'axios'
    import DisplayedFields from '@/Components/DisplayedFields.vue'
    import UploadImageFile from '@/Components/UploadImageFile.vue'

    const chat_ids = ref([])
    const props = defineProps({
        errors: Object,
        route: String,
        chat_id: String,
        employee: Object,
        title: {
            type: String,
            default: 'Редактирование Персонала',
        },
        image: String,
        icon: String,
        specializations: Array,
    });
    const form = reactive({
        phone: props.employee.phone,
        email: props.employee.email,
        password: null,
        telegram_user_id: props.employee.telegram_user_id,
        surname: props.employee.fullname.surname,
        firstname: props.employee.fullname.firstname,
        secondname: props.employee.fullname.secondname,
        address: props.employee.address.address,
        experience_year: props.employee.experience_year,
        meta: props.employee.meta,
        breadcrumb: props.employee.breadcrumb,
        awesome: props.employee.awesome,
        specializations: [],
        image: null,
        icon: null,
        _method: 'put',
        clear_image: false,
        clear_icon: false,
    })

    function handleMaskPhone(val) {
        form.phone = func.MaskPhone(val);
    }
    function onSubmit() {
        router.post(props.route, form)
    }
    function onGetChatID() {
        axios.post(props.chat_id)
            .then(response => {
                chat_ids.value = response.data;
            });
    }
    function handleYear(val) {
        form.experience_year = func.MaskInteger(val);
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
    import {Head} from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'
    export default {
        components: {
            Head,
        },
        layout: Layout,
    }
</script>
