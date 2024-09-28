<template>
    <div>
        <div v-show="!showEdit">
            <el-tag type="success" effect="dark" class="mr-1">
                <i class="fa-light fa-user"></i>
            </el-tag>
                {{ func.fullName(user.fullname) }}
            <el-button type="warning" @click="showEdit = true" circle size="small" class="ml-1">
                <i class="fa-light fa-pen"></i>
            </el-button>
        </div>

        <div v-show="showEdit" class="flex">
            <el-input v-model="form.surname" placeholder="Фамилия" :disabled="isSaving"/>
            <el-input v-model="form.firstname" placeholder="Имя"  :disabled="isSaving"/>
            <el-input v-model="form.secondname" placeholder="Отчество"  :disabled="isSaving"/>
            <el-button type="success" @click="saveElement"><i class="fa-light fa-floppy-disk"></i></el-button>
            <el-button type="info"  @click="showEdit = false" style="margin-left: 2px;"><i class="fa-light fa-xmark"></i></el-button>
        </div>

    </div>
</template>

<script lang="ts" setup>
import {defineProps, reactive, ref} from "vue";
import {func} from '/resources/js/func.js'
import {router} from "@inertiajs/vue3";

const showEdit = ref(false)
const isSaving = ref(false)
const props = defineProps({
    user: Object,
})

const form = reactive({
    user_id: props.user.id,
    surname: props.user.fullname.surname,
    firstname: props.user.fullname.firstname,
    secondname: props.user.fullname.secondname,
})

function saveElement() {
    isSaving.value = true;

    router.visit(route('admin.user.user.set', {user: props.user.id}), {
        method: "post",
        data: form,
        preserveScroll: true,
        preserveState: true,
        onSuccess(data) {
            showEdit.value = false
            isSaving.value = false
        },
    })

}

</script>

<style scoped>

</style>
