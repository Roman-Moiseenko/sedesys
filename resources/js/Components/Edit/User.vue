<template>
    <!-- Клиент -->
    <div v-if="user">
        <span>Клиент</span> <span class="font-medium">{{ func.fullName(user.fullname) }}</span>
        <el-button type="primary" plain @click="showHidden = !showHidden" class="ml-3"><i class="fa-light fa-user-pen"></i></el-button>
        <div v-show="showHidden" class="my-3 border rounded-md p-2">
            <!-- ФИО -->
            <UserFullName :user="user" :router="user.set"/>
            <UserPhone :user="user" :router="user.set"/>
            <UserEmail :user="user" :router="user.set"/>
            <UserAddress :user="user" :router="user.set"/>
        </div>
    </div>
    <!-- Гость -->
    <div v-else>
        Гость
        <el-button @click="showHidden = !showHidden"><i class="fa-light fa-user-plus"></i></el-button>
        <div v-show="showHidden" class="my-3">
            <el-form-item label="Телефон">
                <el-input v-model="form.phone"
                          placeholder="№ телефона"
                          :formatter="(value) => func.MaskPhone(value)" @change="findUser"
                          :disabled="isSaving"
                />
            </el-form-item>
            <el-form-item label="Имя клиента">
                <el-input v-model="form.firstname" placeholder="Имя клиента" :disabled="isSaving"/>
            </el-form-item>
            <el-button type="info" :plain @click="showHidden = false">Отмена</el-button>
            <el-button type="primary" @click="saveData">Сохранить</el-button>
        </div>
    </div>
</template>

<script lang="ts" setup>
import {defineProps, reactive, ref} from "vue";
import {func} from '/resources/js/func.js'
import {router} from "@inertiajs/vue3";
import axios from "axios";

//Элементы
import UserFullName from './UserElements/FullName.vue'
import UserPhone from './UserElements/Phone.vue'
import UserEmail from './UserElements/Email.vue'
import UserAddress from './UserElements/Address.vue'

const isSaving = ref(false)
const form = reactive({
    user_id: null,
    phone: null,
    firstname: null,
})
const showHidden = ref(false)
const props = defineProps({
    user: Object,
    create: String,
    set_user: String, //url для callback операции
})
function findUser() {
    isSaving.value = true;
    axios.post(route('admin.user.user.find'), {phone: form.phone})
        .then(response => {
            console.log(response.data);
            if (response.data === false) {
            } else {
                form.user_id = response.data.id
                form.firstname = response.data.fullname.firstname
            }
            isSaving.value = false
        });
}
function saveData() {
    router.post(props.set_user, form)
}
</script>
