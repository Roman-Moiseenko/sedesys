<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить Персонал</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <el-tabs type="border-card" class="mb-4">
                <el-tab-pane>
                    <template #label>
                    <span class="custom-tabs-label">
                        <el-icon><User/></el-icon>
                        <span> Персональные данные</span>
                    </span>
                    </template>
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
                        </div>
                        <div class="p-4">
                            <el-form-item label="Телефон" :rules="{required: true}">
                                <el-input v-model="form.phone" placeholder="80000000000" @input="handleMaskPhone"/>
                                <div v-if="errors.phone" class="text-red-700">{{ errors.phone }}</div>
                            </el-form-item>
                            <el-form-item label="ID Телеграм-бота">
                                <el-input v-model="form.telegram_user_id"/>
                                <div v-if="errors.telegram_user_id" class="text-red-700">{{
                                        errors.telegram_user_id
                                    }}
                                </div>
                            </el-form-item>
                            <el-form-item label="Адрес">
                                <el-input v-model="form.address" placeholder="Адрес"/>
                                <div v-if="errors.address" class="text-red-700">{{ errors.address }}</div>
                            </el-form-item>
                            <el-form-item label="Пароль">
                                <el-input v-model="form.password" type="password" show-password
                                          autocomplete="new-password"/>
                                <div v-if="errors.password" class="text-red-700">{{ errors.password }}</div>
                            </el-form-item>
                            <el-form-item label="Стаж с какого года" :rules="{required: true}">
                                <el-input v-model="form.experience_year"/>
                                <div v-if="errors.experience_year" class="text-red-700">{{
                                        errors.experience_year
                                    }}
                                </div>
                            </el-form-item>
                        </div>
                        <div class="p-4">
                            <h2 class="font-medium mb-3">Специализация</h2>
                            <div v-for="specialization in specializations">
                                <el-checkbox v-model="form.specializations" :label="specialization.name"
                                             type="checkbox" :key="specialization.id"
                                             :value="specialization.id"
                                />
                            </div>
                        </div>
                    </div>
                </el-tab-pane>
                <DisplayedFieldsPanel
                    :errors="errors"
                    :templates="templates"
                    :tiny_api="tiny_api"
                    v-model:displayed="form.displayed"
                >
                </DisplayedFieldsPanel>
            </el-tabs>

            <el-button type="primary" @click="onSubmit" :disabled="!isUnSave">Сохранить</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
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
import {Head, router} from '@inertiajs/vue3'
import {reactive, ref, watch} from 'vue'
import {func} from "/resources/js/func.js"
import axios from 'axios'
import DisplayedFieldsPanel from '@/Components/Displayed/Fields.vue'

const chat_ids = ref([])
const props = defineProps({
    errors: Object,
    route: String,
    chat_id: String,
    title: {
        type: String,
        default: 'Создание Персонала',
    },
    specializations: Array,
    templates: Array,
    tiny_api: String,
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
    specializations: [],
    file: null,
    experience_year: null,
    displayed: func.displayedInfo(),
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
