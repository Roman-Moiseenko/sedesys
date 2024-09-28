<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">{{ title }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto" style="max-width: 500px">

            <!-- Повторить поля -->
            <el-form-item label="Название" :rules="{required: true}">
                <el-input v-model="form.name" placeholder="Название"/>
                <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
            </el-form-item>
            <el-form-item label="ИНН" :rules="{required: true}">
                <el-input v-model="form.inn" placeholder="ИНН" @input="handleMaskINN"/>
                <div v-if="errors.inn" class="text-red-700">{{ errors.inn }}</div>
            </el-form-item>
            <el-form-item label="КПП">
                <el-input v-model="form.kpp" placeholder="КПП" @input="handleMaskKPP"/>
                <div v-if="errors.kpp" class="text-red-700">{{ errors.kpp }}</div>
            </el-form-item>
            <el-form-item label="ОГРН">
                <el-input v-model="form.ogrn" placeholder="ОГРН" @input="handleMaskOGRN"/>
                <div v-if="errors.ogrn" class="text-red-700">{{ errors.ogrn }}</div>
            </el-form-item>
            <el-form-item label="БИК">
                <el-input v-model="form.bik" placeholder="БИК" @input="handleMaskBIK"/>
                <div v-if="errors.bik" class="text-red-700">{{ errors.bik }}</div>
            </el-form-item>
            <el-form-item label="Кор/счет">
                <el-input v-model="form.bank_account" placeholder="Кор/счет" @input="handleMaskBankAccount"/>
                <div v-if="errors.bank_account" class="text-red-700">{{ errors.bank_account }}</div>
            </el-form-item>
            <el-form-item label="Банк">
                <el-input v-model="form.bank" placeholder="Банк"/>
                <div v-if="errors.bank" class="text-red-700">{{ errors.bank }}</div>
            </el-form-item>
            <el-form-item label="Расч/счет">
                <el-input v-model="form.account" placeholder="Расч/счет" @input="handleMaskAccount"/>
                <div v-if="errors.account" class="text-red-700">{{ errors.account }}</div>
            </el-form-item>
            <el-form-item label="Индекс" :rules="{required: true}">
                <el-input v-model="form.post" placeholder="Почтовый индекс"/>
                <div v-if="errors.post" class="text-red-700">{{ errors.post }}</div>
            </el-form-item>
            <el-form-item label="Город" :rules="{required: true}">
                <el-input v-model="form.city" placeholder="Город"/>
                <div v-if="errors.city" class="text-red-700">{{ errors.city }}</div>
            </el-form-item>
            <el-form-item label="Адрес" :rules="{required: true}">
                <el-input v-model="form.address" placeholder="Адрес"/>
                <div v-if="errors.address" class="text-red-700">{{ errors.address }}</div>
            </el-form-item>
            <el-form-item label="Телефоны">
                <el-select
                    v-model="form.phones"
                    multiple
                    filterable
                    allow-create
                    default-first-option
                    :reserve-keyword="false"
                    placeholder="Добавьте телефоны"
                >
                    <el-option
                        v-for="item in form.phones"
                        :key="item"
                        :label="item"
                        :value="item"
                    />
                </el-select>
            </el-form-item>

            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
import {reactive} from 'vue'
import {Head, router} from "@inertiajs/vue3";
import {func} from "/resources/js/func.js"

const props = defineProps({
    errors: Object,
    organization: Object,
    title: {
        type: String,
        default: 'Настройки организации',
    }
});

const form = reactive({
    slug: 'organization',
    name: props.organization.name,
    inn: props.organization.inn,
    kpp: props.organization.kpp,
    ogrn: props.organization.ogrn,
    bik: props.organization.bik,
    bank: props.organization.bank,
    bank_account: props.organization.bank_account,
    account: props.organization.account,
    post: props.organization.post,
    city: props.organization.city,
    address: props.organization.address,

    phones: props.organization.phones,
    /**
     * Добавить новые поля
     */
})

function handleMaskINN(val) {
    form.inn = func.MaskInteger(val, 12);
}

function handleMaskKPP(val) {
    form.kpp = func.MaskInteger(val, 9);
}

function handleMaskOGRN(val) {
    form.ogrn = func.MaskInteger(val, 13);
}

function handleMaskBIK(val) {
    form.bik = func.MaskInteger(val, 9);
}

function handleMaskBankAccount(val) {
    form.bank_account = func.MaskInteger(val, 20);
}

function handleMaskAccount(val) {
    form.account = func.MaskInteger(val, 20);
}

function onSubmit() {
    router.put(route('admin.setting.update'), form)
}

</script>

