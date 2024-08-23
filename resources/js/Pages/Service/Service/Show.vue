<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ service.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-tabs type="border-card" class="demo-tabs">
            <!-- Панель Общая информация -->
            <el-tab-pane>
                <template #label>
                    <span class="custom-tabs-label">
                        <el-icon><Memo /></el-icon>
                        <span> Общая информация</span>
                    </span>
                </template>
                <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                    <div class="p-4">
                        <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                            <div class="truncate sm:whitespace-normal flex items-center" v-if="$props.service.classification_id !== null">
                                Классификация&nbsp;<span class="font-medium ml-6">{{ $props.service.classification.name}}</span>
                            </div>
                            <div class="truncate sm:whitespace-normal flex items-center">
                                Услуга&nbsp;<span class="font-medium ml-6">{{ $props.service.name}}</span>
                            </div>
                            <div class="truncate sm:whitespace-normal flex items-center mt-2">
                                Шаблон&nbsp;<span class="font-medium ml-6">{{ $props.service.template }}</span>
                            </div>
                            <div class="truncate sm:whitespace-normal flex items-center mt-2">
                                Ссылка&nbsp;<span class="font-medium ml-6">{{ $props.service.slug}}</span>
                            </div>
                            <div class="truncate sm:whitespace-normal flex items-center mt-2">
                                Страница (H1)&nbsp;<span class="font-medium ml-6">{{ $props.service.meta.h1}}</span>
                            </div>
                            <div class="truncate sm:whitespace-normal flex items-center mt-2">
                                Заголовок&nbsp;<span class="font-medium ml-6">{{ $props.service.meta.title}}</span>
                            </div>
                            <div class="truncate sm:whitespace-normal flex items-center mt-2">
                                Описание&nbsp;<span class="font-medium ml-6">{{ $props.service.meta.description}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="p-4">
                        <div class="truncate sm:whitespace-normal flex items-center mt-2">
                            Цена&nbsp;<span class="font-medium ml-6">{{ $props.service.price }} ₽</span>
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-2">
                            Длительность&nbsp;<span class="font-medium ml-6">{{ $props.service.duration }} мин</span>
                        </div>
                        <div class="truncate sm:whitespace-normal flex items-center mt-2">
                            Данные&nbsp;<span class="font-medium ml-6">{{ $props.service.data}}</span>
                        </div>
                    </div>
                    <div class="p-4 flex">
                        <div>
                            <h2 class="font-medium mb-3">Изображение для каталога</h2>
                            <div class="lg:w-56 lg:h-56 image-fit relative">
                                <el-image
                                    :src="$props.image"
                                    :zoom-rate="1.2"
                                    :max-scale="3"
                                    :min-scale="0.2"
                                    :preview-src-list="[$props.image]"
                                    :initial-index="0"
                                    fit="cover"
                                />
                            </div>
                        </div>
                        <div>
                            <h2 class="font-medium mb-3">Иконка для меню</h2>
                            <div class="lg:w-56 lg:h-56 image-fit relative">
                                <el-image
                                    :src="$props.icon"
                                    :zoom-rate="1.2"
                                    :max-scale="1"
                                    :min-scale="0.2"
                                    :preview-src-list="[$props.icon]"
                                    :initial-index="0"
                                    fit="cover"
                                />
                            </div>
                        </div>

                    </div>
                </div>

            </el-tab-pane>
            <!-- Панель Описание -->
            <el-tab-pane>
                <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><Document /></el-icon>
                      <span> Описание</span>
                    </span>
                </template>
                <div class="mt-5 p-5 bg-white rounded-lg border shadow" v-html="$props.service.text"></div>
            </el-tab-pane>
            <!-- Панель Галерея -->
            <el-tab-pane>
                <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><Picture /></el-icon>
                      <span> Галерея</span>
                    </span>
                </template>
                <div class="mt-5 p-5 bg-white rounded-lg">
                    <h2 class="font-medium text-lg mb-3">Галерея:</h2>
                    <el-upload
                        v-model:file-list="fileList"
                        :action="add"
                        list-type="picture-card"
                        :on-preview="handlePictureCardPreview"
                        :on-remove="handleRemove"
                        :headers="{'X-CSRF-TOKEN': csrf}"
                    >
                        <el-icon><Plus /></el-icon>
                    </el-upload>
                    <el-dialog v-model="dialogGallery" width="80%">
                        <div class="flex">
                            <div style="width: 80%" class="grid">
                                <img w-full :src="dialogImageUrl" alt="Preview Image" class="mx-auto"/>
                            </div>
                            <div class="bg-gray-100 p-2 border border-gray-300" style="width: 20%">
                                <el-form :model="form" label-width="auto">
                                    <el-form-item label="ID фото">
                                        <el-input v-model="form.photo_id"  readonly />
                                    </el-form-item>
                                    <el-form-item label="Alt для фото" label-position="top">
                                        <el-input v-model="form.alt" placeholder="Напишите Alt для SEO" />
                                    </el-form-item>
                                    <el-form-item label="Заголовок" label-position="top">
                                        <el-input v-model="form.title" placeholder="Заголовок" />
                                    </el-form-item>
                                    <el-form-item label="Описание" label-position="top">
                                        <el-input v-model="form.description" placeholder="Описание" type="textarea" :rows="3"/>
                                    </el-form-item>
                                    <el-button type="primary" @click="onSubmit">Сохранить</el-button>
                                    <span v-if="dialogSave" class="text-lime-500 text-sm ml-3">Сохранено</span>
                                </el-form>
                                <div class="mt-5">
                                    <el-input v-model="dialogImageUrl"  readonly />
                                    <el-button id="copy_buffer" type="success" class="text-sm mt-2" @click="copyBuffer" plain>Скопировать Url</el-button>
                                    <span v-if="dialogCopy" class="text-lime-500 text-sm ml-3">Скопировано</span>
                                </div>
                            </div>
                        </div>
                    </el-dialog>
                </div>
            </el-tab-pane>
            <!-- Панель Персонал -->
            <el-tab-pane>
                <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><Service /></el-icon>
                      <span> Персонал</span>
                    </span>
                </template>
                <div class="mb-5">
                    <el-table :data="service.employees"
                        style="width: 100%;"

                    >
                        <el-table-column label="Персонал" width="250" >
                            <template #default="scope">
                                {{ func.fullName(scope.row.fullname)}}
                            </template>
                        </el-table-column>
                        <el-table-column label="Специализация" width="250" >
                            <template #default="scope">
                                | <span v-for="item in scope.row.specializations">{{ item.name }} | </span>
                            </template>
                        </el-table-column>
                        <el-table-column label="Стаж" width="250" >
                            <template #default="scope">
                                {{ func.experience(scope.row.experience_year)}}
                            </template>
                        </el-table-column>
                        <el-table-column label="Доп.сбор" width="250" >
                            <template #default="scope">
                                {{ func.price(scope.row.pivot.extra_cost) }}
                            </template>
                        </el-table-column>
                        <el-table-column label="Действия" width="250" >
                            <template #default="scope">
                                <el-button type="warning" @click.stop="handleDetach(scope.row.id)" >Detach</el-button>
                            </template>
                        </el-table-column>

                    </el-table>
                </div>

                <el-button type="success" plain @click="dialogEmployee = true">
                    <el-icon><Service /></el-icon> Добавить Персонал
                </el-button>
                <!--Dialog-->
                <el-dialog v-model="dialogEmployee" width="400" class="p-4" center>
                    <el-form :model="formEmployee" class="mt-3">
                        <el-form-item label="Персонал">
                            <el-select v-model="formEmployee.employee_id">
                                <el-option v-for="item in $page.props.out_employees" :value="item.id" :key="item.id" :label="func.fullName(item.fullname)"/>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="Дополнительная наценка" class="mb-3">
                            <el-input v-model="formEmployee.extra_cost" @input="handleExtraCost" placeholder="" class="mb-3">
                                <template #append>₽</template>
                            </el-input>
                        </el-form-item>
                        <el-button type="info" plain @click="dialogEmployee = false">
                            Отмена
                        </el-button>
                        <el-button type="primary" @click="attachEmployee">Сохранить</el-button>
                        <span v-if="dialogSave" class="text-lime-500 text-sm ml-3">Сохранено</span>
                    </el-form>
                </el-dialog>
            </el-tab-pane>

            <!-- Панель Отзывы -->
            <el-tab-pane>
                <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><ChatLineSquare /></el-icon>
                      <span> Отзывы</span>
                    </span>
                </template>
                Список + рейтинг + пагинация с подгрузгой
            </el-tab-pane>
            <!-- Панель Расходники -->
            <el-tab-pane>
                <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><TakeawayBox /></el-icon>
                      <span> Расходники</span>
                    </span>
                </template>
                Список материала + кол-во + цена за 1 шт.
            </el-tab-pane>
        </el-tabs>
    </div>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.service.active" type="success" @click="handleToggle">Показывать</el-button>
            <el-button v-if="$props.service.active" type="warning" @click="handleToggle">Скрыть из показа</el-button>
        </div>

    </div>


</template>

<script lang="ts" setup>
    import { Head, Link } from '@inertiajs/vue3'
    import {reactive, ref} from 'vue'
    import { Plus } from '@element-plus/icons-vue'
    import {router} from "@inertiajs/vue3";
    import {func} from '@/func.js'
    import type { UploadProps, UploadUserFile, UploadRawFile  } from 'element-plus'

    const dialogImageUrl = ref('')
    const dialogGallery = ref(false)
    const dialogEmployee = ref(false)
    const dialogCopy = ref(false)
    const dialogSave = ref(false)
    const imageAlt = ref('')
    const imageId = ref('')

    const props = defineProps({
        service: Object,
        edit: String,
        title: {
            type: String,
            default: 'Карточка услуги',
        },
        gallery: Array,
        image: String,
        icon: String,
        add: String,
        del: String,
        set: String,
        attach: String,
        detach: String,
        toggle: String,
        class_name: String,
        out_employees: Object,
    });

    const form = reactive({
        photo_id: null,
        alt: null,
        title: null,
        description: null,
    })
    const formEmployee = reactive({
        employee_id: null,
        extra_cost: null
    });

    const fileList = ref<UploadUserFile[]>(props.gallery);

    const handleRemove: UploadProps['onRemove'] = (uploadFile, uploadFiles) => {
        if (uploadFile.id !== undefined) router.post(props.del, {photo_id: uploadFile.id});
    }
    const handlePictureCardPreview: UploadProps['onPreview'] = (uploadFile) => {
        dialogImageUrl.value = uploadFile.url!
        form.photo_id = uploadFile.id;
        form.alt = uploadFile.alt;
        form.title = uploadFile.title;
        form.description = uploadFile.description;
        dialogGallery.value = true
    }

    function onSubmit() {
        dialogSave.value = true;
        setTimeout(() => {
            dialogSave.value = false;
        }, 2000);
        router.post(props.set, form);
    }
    function attachEmployee() {
        if (formEmployee.employee_id === null) return;
        router.post(props.attach, formEmployee);
        dialogEmployee.value = false;
    }
    function detachEmployee(row) {
        router.post(props.detach, {
            employee_id: row.id
        });
    }
    function handleExtraCost(val) {
        formEmployee.extra_cost = func.MaskInteger(val);
    }
    function routeClick(row) {
        router.get(row.url)
    }
    function handleDetach(val) {
        router.post(props.detach, {employee_id: val})
    }

</script>

<script lang="ts">
import { Head, Link, router } from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'
import {ref} from "vue";

    export default {
        layout: Layout,
        methods: {
            goEdit() {
                router.get(this.$props.edit);
            },
            handleToggle(val) {
                router.post(this.$props.toggle);
            }
        },
        data() {
            return {
                csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            }
        },
    }

</script>

<style>

</style>
