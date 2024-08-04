<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ title }} <span class="text-red-800" v-if="formChange">*</span> </h1>

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

<script lang="ts">
import Codemirror from "codemirror-editor-vue3";
import {Head, router} from '@inertiajs/vue3'

import "codemirror/mode/htmlmixed/htmlmixed.js";
import "codemirror/theme/bespin.css";
import Layout from '@/Components/Layout.vue'


export default {
    components: {
        Codemirror,
        Head,
    },
    layout: Layout,
    props: {
        template: String,
        content: String,
        type: String,
        route: String,
        title: {
            type: String,
            default: 'Шаблон',
        }
    },

    data() {
        return {
            cmOptions: {
                mode: "htmlmixed", // Language mode
                theme: "bespin", // Theme
            },
            form: {
                content: this.content,
                type: this.type,
                template: this.template,
                close: false,
            },
            formChange: false
        }
    },

    methods: {
        change() {
            this.formChange = true;
        },
        onSubmit(val) {
            this.form.close = val;
            this.formChange = false;
            router.put(this.route, this.form);
            console.log(this.form);
        }
    },
}

</script>

