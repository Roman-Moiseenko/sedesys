<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">{{ staff.fullname }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid lg:grid-cols-6 grid-cols-1 divide-x">
            <div class="p-4 col-span-2">
                <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                    <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                        <el-image
                            style="width: 100px; height: 100px"
                            :src="$props.photo"
                            :zoom-rate="1.2"
                            :max-scale="7"
                            :min-scale="0.2"
                            :preview-src-list="[$props.photo]"
                            :initial-index="0"
                            fit="cover"
                        />
                    </div>
                    <div class="ml-5">
                        <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">
                            {{ staff.fullname }}
                        </div>
                        <div class="text-slate-500">{{ staff.post }}</div>
                    </div>
                </div>
                <el-descriptions :column="1" border title="Персональные данные">
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon><User /></el-icon>&nbsp;Логин
                            </div>
                        </template>
                        {{ staff.name }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon><iphone  /></el-icon>&nbsp;Телефон
                            </div>
                        </template>
                        {{ staff.phone }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon><Promotion /></el-icon>&nbsp;Телеграм ID
                            </div>
                        </template>
                        {{ staff.telegram_user_id }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon><Lock /></el-icon>&nbsp;Роль
                            </div>
                        </template>
                        {{ staff.role }}
                    </el-descriptions-item>
                </el-descriptions>
            </div>

            <div class="p-4 col-span-4">
                <el-form-item label="Доступы и уведомления" label-position="top">
                    <el-checkbox-group v-model="formResp" class="grid grid-cols-3">
                        <el-checkbox v-for="item in responsibilities" :key="item.value" :value="item.value" :label="item.label"
                                     @change="onChange($event, item.value)"
                                     class="pl-3"
                        />
                    </el-checkbox-group>
                </el-form-item>

                <div class="p-3 rounded-lg bg-sky-100 border border-sky-600">
                    <div class="font-medium mb-1 text-sky-700">Инструкция</div>
                    <div class="text-sm">
                        Для <strong>Руководитель</strong> и <strong>Администратор</strong> доступ полный, но настройка позволит получать уведомления по событиям.
                    </div>
                    <div class="text-sm">Например, при получении нового заказа, или оставлении отзыва.</div>
                    <div class="text-sm"></div>
                </div>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button plain @click="dialogFormVisible = true">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" data-lucide="key-round" class="lucide lucide-key-round w-4 h-4 mr-2"><path d="M2 18v3c0 .6.4 1 1 1h4v-3h3v-3h2l1.4-1.4a6.5 6.5 0 1 0-4-4Z"></path><circle cx="16.5" cy="7.5" r=".5"></circle></svg>
                Сменить пароль
            </el-button>

        </div>
    </div>

    <!-- Dialog -->
    <el-dialog v-model="dialogFormVisible" title="Сменить пароль" width="400">
        <el-form :model="form">
            <el-form-item :rules="{required: true}">
                <el-input v-model="form.password" autocomplete="off" />
                <div v-if="errors.password" class="text-red-700">{{ errors.password }}</div>
            </el-form-item>
        </el-form>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Отмена</el-button>
                <el-button type="primary" @click="subForm">
                    Сохранить
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import { reactive, ref } from 'vue'
import {router, Head} from "@inertiajs/vue3";
const props = defineProps({
    staff: Object,
    photo: {
        type: String,
        default: null,
    },
    errors: Object,
    title: {
        type: String,
        default: 'Карточка сотрудника',
    },
    responsibilities: Array,
});
const dialogFormVisible = ref(false)
const formResp = ref(props.staff.responsibilities)
const form = reactive({
    password: '',
})
//
function subForm() {
    router.visit(
        route('admin.staff.password', {staff: props.staff.id}),
        //props.password,
        {
        method: 'post',
        data: form,
        preserveState: true,
        preserveScroll: true,
        onSuccess: page => {
            dialogFormVisible.value = false
            form.password = '';
            },
    })

}
function goEdit() {
    router.get(route('admin.staff.edit', {staff: props.staff.id}));
}

function onChange(val, index) {
    router.post(route('admin.staff.responsibility', {staff: props.staff.id}), {code: index});
}
</script>

