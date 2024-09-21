<template>
    <div>
        <div v-show="!showEdit">
            <el-tag type="success" effect="dark" class="mr-1">
                <i class="fa-light fa-map-location-dot"></i>
            </el-tag>
                {{ user.address }}
            <el-button type="warning" @click="showEdit = true" circle size="small" class="ml-1">
                <i class="fa-light fa-pen"></i>
            </el-button>
        </div>

        <div v-show="showEdit" class="flex">
            <el-input v-model="form.address" placeholder="Адрес клиента" :disabled="isSaving"/>
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
    router: String,
})

const form = reactive({
    user_id: props.user.id,
    address: props.user.address,
})

function saveElement() {
    isSaving.value = true;

    router.visit(props.router, {
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
