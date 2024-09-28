<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ title }} <span class="text-red-800" v-if="formChange">*</span></h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <el-form :model="form">
            <Codemirror
                v-model:value="form.content"
                :options="cmOptions"
                border
                :height="600"
                @change="change"
                original-style
            />
            <el-button type="primary" @click="onSubmit(false)" plain :disabled="!formChange">
                Сохранить
            </el-button>
            <el-button type="primary" @click="onSubmit(true)" class="ml-3" :disabled="!formChange">
                Сохранить и закрыть
            </el-button>
        </el-form>
    </div>

</template>

<script lang="ts" setup>
import Codemirror from "codemirror-editor-vue3";
import {Head, router} from '@inertiajs/vue3'
import {reactive, ref} from 'vue'
import "codemirror/mode/htmlmixed/htmlmixed.js";
import "codemirror/theme/bespin.css";

const props = defineProps({
    template: String,
    content: String,
    type: String,
    title: {
        type: String,
        default: 'Шаблон',
    }
})
const formChange = ref(false)
const form = reactive({
    content: props.content,
    type: props.type,
    template: props.template,
    close: false,
})
const cmOptions = {
    mode: "htmlmixed", // Language mode
    theme: "bespin", // Theme
}
function change() {
    formChange.value = true;
}
function onSubmit(val) {
    form.close = val;
    formChange.value = false;
    router.put(route('admin.page.template.update'), form);
}
</script>

