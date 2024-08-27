<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">{{ title }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <el-form-item label="Название сайта" :rules="{required: true}">
                        <el-input v-model="form.name" placeholder="Название сайта"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Краткое название" :rules="{required: true}">
                        <el-input v-model="form.short_name" placeholder="Для уведомлений"/>
                        <div v-if="errors.short_name" class="text-red-700">{{ errors.short_name }}</div>
                    </el-form-item>
                    <el-form-item label="Разрешить авторизацию">
                        <el-checkbox v-model="form.auth"/>
                    </el-form-item>
                    <el-form-item label="Авторизация по телефону">
                        <el-checkbox v-model="form.auth_phone"/>
                    </el-form-item>
                    <el-form-item label="Иконки в меню">
                        <el-radio-group v-model="form.menu_icon" label="">
                            <el-radio-button label="Нет" value="none" />
                            <el-radio-button label="Картинка" value="icon" />
                            <el-radio-button label="SVG иконка" value="awesome" />
                        </el-radio-group>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <h2 class="font-medium text-lg mb-3">Мета данные для узловых страниц</h2>

                    <!--h3 class="font-medium mb-3">Специализация</h3>
                    <el-form-item label="H1 страницы">
                        <el-input v-model="form.specializations.h1" placeholder="H1" maxlength="160" show-word-limit/>
                    </el-form-item>
                    <el-form-item label="Заголовок">
                        <el-input v-model="form.specializations.title" placeholder="Meta-Title" maxlength="200" show-word-limit/>
                    </el-form-item>
                    <el-form-item label="Описание">
                        <el-input v-model="form.specializations.description" placeholder="Meta-Description" :rows="3" type="textarea" maxlength="250" show-word-limit/>
                    </el-form-item-->
                    <h3 class="font-medium mb-3">Специализация / Персонал</h3>
                    <el-form-item label="H1 страницы">
                        <el-input v-model="form.employees.h1" placeholder="H1" maxlength="160" show-word-limit/>
                    </el-form-item>
                    <el-form-item label="Заголовок">
                        <el-input v-model="form.employees.title" placeholder="Meta-Title" maxlength="200" show-word-limit/>
                    </el-form-item>
                    <el-form-item label="Описание">
                        <el-input v-model="form.employees.description" placeholder="Meta-Description" :rows="3" type="textarea" maxlength="250" show-word-limit/>
                    </el-form-item>

                    <!--h3 class="font-medium mb-3">Классификация</h3>
                    <el-form-item label="H1 страницы">
                        <el-input v-model="form.classifications.h1" placeholder="H1" maxlength="160" show-word-limit/>
                    </el-form-item>
                    <el-form-item label="Заголовок">
                        <el-input v-model="form.classifications.title" placeholder="Meta-Title" maxlength="200" show-word-limit/>
                    </el-form-item>
                    <el-form-item label="Описание">
                        <el-input v-model="form.classifications.description" placeholder="Meta-Description" :rows="3" type="textarea" maxlength="250" show-word-limit/>
                    </el-form-item-->

                    <h3 class="font-medium mb-3">Классификация / Услуги</h3>
                    <el-form-item label="H1 страницы">
                        <el-input v-model="form.services.h1" placeholder="H1" maxlength="160" show-word-limit/>
                    </el-form-item>
                    <el-form-item label="Заголовок">
                        <el-input v-model="form.services.title" placeholder="Meta-Title" maxlength="200" show-word-limit/>
                    </el-form-item>
                    <el-form-item label="Описание">
                        <el-input v-model="form.services.description" placeholder="Meta-Description" :rows="3" type="textarea" maxlength="250" show-word-limit/>
                    </el-form-item>
                </div>
                <div class="p-4">

                </div>
            </div>
            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
    </div>
</template>


<script setup>
import {reactive} from 'vue'
import {router} from "@inertiajs/vue3";
import {func} from "/resources/js/func.js"

const props = defineProps({
    errors: Object,
    route: String,
    web: Object,
    title: {
        type: String,
        default: 'Настройки сайта',
    }
});

const form = reactive({
    slug: 'web',
    name: props.web.name,
    short_name: props.web.short_name,
    auth: props.web.auth,
    auth_phone: props.web.auth_phone,
    menu_icon: props.web.menu_icon,
   // specializations: props.web.specializations,
    employees: props.web.employees,
   // classifications: props.web.classifications,
    services: props.web.services,

    /**
     * Добавить новые поля
     */
})

function onSubmit() {
    router.put(props.route, form)
}

</script>
<script>
import {Head} from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'

export default {
    components: {
        Head,
    },
    layout: Layout,
}
</script>
