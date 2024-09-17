<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новую форму</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-6 grid-cols-1 divide-x">
                <div class="p-4 col-span-2">
                    <!-- Повторить поля -->
                    <el-form-item label="Название" :rules="{required: true}">
                        <el-input v-model="form.name" placeholder="Название"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Цвет карточки">
                        <el-color-picker v-model="form.color"/>
                        <div v-if="errors.color" class="text-red-700">{{ errors.color }}</div>
                    </el-form-item>

                    <div class="p-3 rounded-lg bg-sky-100 border border-sky-600 mt-3">
                        <div class="font-medium mb-1 text-sky-700">Инструкция</div>
                        <div class="text-sm">
                            Поля <strong>user</strong>, <strong>email</strong>, <strong>phone</strong>, <strong>message</strong> фиксируются в отдельных столбцах.
                        </div>
                        <div class="text-sm">По полю <strong>email</strong> сформируется ответное письмо.</div>
                        <div class="text-sm">Все остальные поля запишутся как пары "поле" => "значение" в столбце Данные</div>
                        <div class="text-sm">Стили можно задать в файле <strong>custom.css</strong> в модуле Страницы</div>
                        <div class="text-sm">Классы для маски вводимых данных <strong>mask-phone</strong>,  <strong>mask-email</strong> </div>
                        <div class="text-sm mt-1">Для подключения используйте класс "feedback" <strong>&lt;div class="feedback" data-id="1"&gt;&lt;/div&gt;</strong></div>
                    </div>
                </div>
                <div class="p-4 col-span-4">
                    <Codemirror
                        v-model:value="form.template"
                        :options="cmOptions"
                        border
                        :height="400"
                        original-style
                    />
                </div>
            </div>
            <el-button type="primary" @click="onSubmit" :disabled="!isUnSave">Сохранить</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {Head} from '@inertiajs/vue3'
    import {reactive, ref, watch, defineProps} from 'vue'
    import {router} from "@inertiajs/vue3";
    import {func} from "/resources/js/func.js"
    import Codemirror from "codemirror-editor-vue3";

    const props = defineProps({
        errors: Object,
        route: String,
        title: {
            type: String,
            default: 'Создание шаблона формы заявки',
        },
    });

    const form = reactive({
        name: null,
        color: null,
        template: null,
        /**
         * Добавить новые поля
         */
    })

    const  cmOptions = {
        mode: "htmlmixed", // Language mode
        theme: "bespin", // Theme
    }


    function onSubmit() {
        router.post(props.route, form)
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

