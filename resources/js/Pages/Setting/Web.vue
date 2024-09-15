<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">{{ title }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">

            <div class="mt-3 p-3 bg-white rounded-lg">
                <el-tabs type="border-card" class="">
                    <!-- Панель Общая информация -->
                    <el-tab-pane>
                        <template #label>
                            <span class="custom-tabs-label">
                                <el-icon><Memo/></el-icon>
                                <span> Общие данные</span>
                            </span>
                        </template>
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
                                <el-form-item label="Кешируемые страницы">
                                    <el-checkbox-group v-model="form.use_caches" class="flex flex-col">
                                        <el-checkbox v-for="item in models" :key="item.value" :value="item.value" :label="item.label" />
                                    </el-checkbox-group>
                                </el-form-item>
                            </div>
                            <div class="p-4">
                                <DisplayedDefault
                                    label="По умолчанию"
                                    :errors="errors"
                                    v-model:meta="form.default_meta"
                                    v-model:breadcrumb="form.default_breadcrumb"
                                    v-model:awesome="form.default_awesome"
                                />
                            </div>
                            <div class="p-4">
                            </div>
                        </div>
                    </el-tab-pane>
                    <!-- Панель Общая информация -->
                    <el-tab-pane>
                        <template #label>
                            <span class="custom-tabs-label">
                                <el-icon><Memo/></el-icon>
                                <span> Узловые страницы</span>
                            </span>
                        </template>
                        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">

                            <div class="p-4">
                                <DisplayedDefault
                                    label="Специализация / Персонал"
                                    :errors="errors"
                                    v-model:meta="form.employees_meta"
                                    v-model:breadcrumb="form.employees_breadcrumb"
                                    v-model:awesome="form.employees_awesome"
                                />
                            </div>
                            <div class="p-4">
                                <DisplayedDefault
                                    label="Классификация / Услуги"
                                    :errors="errors"
                                    v-model:meta="form.services_meta"
                                    v-model:breadcrumb="form.services_breadcrumb"
                                    v-model:awesome="form.services_awesome"
                                />
                            </div>
                            <div class="p-4">

                            </div>
                        </div>
                    </el-tab-pane>
                </el-tabs>
            </div>




            <el-button type="primary" @click="onSubmit">Сохранить</el-button> <el-tag type="warning" class="ml-3">Сохранение очистит кеш страниц</el-tag>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
    </div>
</template>


<script setup>
import {reactive} from 'vue'
import {router} from "@inertiajs/vue3";
import {func} from "/resources/js/func.js"
import DisplayedDefault from '@/Components/Displayed/Default.vue'

const props = defineProps({
    errors: Object,
    route: String,
    web: Object,
    title: {
        type: String,
        default: 'Настройки сайта',
    },
    models: Array,
});

const form = reactive({
    slug: 'web',
    name: props.web.name,
    short_name: props.web.short_name,
    auth: props.web.auth,
    auth_phone: props.web.auth_phone,
    menu_icon: props.web.menu_icon,
    use_caches: props.web.use_caches,

    default_meta: props.web.default_meta,
    default_breadcrumb: props.web.default_breadcrumb,
    default_awesome: props.web.default_awesome,

    employees_meta: props.web.employees_meta,
    employees_breadcrumb: props.web.employees_breadcrumb,
    employees_awesome: props.web.employees_awesome,

    services_meta: props.web.services_meta,
    services_breadcrumb: props.web.services_breadcrumb,
    services_awesome: props.web.services_awesome,



    /**
     * Добавить новые поля
     */
})

console.log(form)

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
