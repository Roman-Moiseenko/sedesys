<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новую специальность</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <!-- Повторить поля -->
                    <el-form-item label="Название" :rules="{required: true}">
                        <el-input v-model="form.name" placeholder="Название"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Ссылка">
                        <el-input v-model="form.slug" placeholder="Оставьте пустым для автозаполнения" @input="handleMaskSlug"/>
                        <div v-if="errors.slug" class="text-red-700">{{ errors.slug }}</div>
                    </el-form-item>
                    <el-form-item label="H1">
                        <el-input v-model="form.h1" placeholder="H1 для вывода на странице" maxlength="160" show-word-limit/>
                        <div v-if="errors.h1" class="text-red-700">{{ errors.h1 }}</div>
                    </el-form-item>
                    <el-form-item label="Заголовок">
                        <el-input v-model="form.title" placeholder="Meta-Title" maxlength="200" show-word-limit/>
                        <div v-if="errors.title" class="text-red-700">{{ errors.title }}</div>
                    </el-form-item>
                    <el-form-item label="Описание">
                        <el-input v-model="form.description" placeholder="Meta-Description" :rows="3" type="textarea" maxlength="250" show-word-limit/>
                        <div v-if="errors.description" class="text-red-700">{{ errors.description }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <h2 class="font-medium mb-3">Изображение для каталога</h2>
                    <!-- FileUpload -->
                    <el-upload action="#" list-type="picture-card"
                               :limit="1"
                               :auto-upload="false"
                               v-model:fileList="Images"
                               @input="form.image = $event.target.files[0]" :on-remove="handleRemoveImages"
                               class="file-uploader-one"
                               ref="template"
                    >
                        <el-icon><Plus/></el-icon>
                        <template #file="{ file }">
                            <div>
                                <img class="el-upload-list__item-thumbnail" :src="file.url" alt=""/>
                                <span class="el-upload-list__item-actions">
                                  <span class="el-upload-list__item-preview" @click="handlePictureCardPreview(file)">
                                    <el-icon><zoom-in/></el-icon>
                                  </span>
                                  <span v-if="!disabled" class="el-upload-list__item-delete" @click="handleRemoveImages(file)">
                                    <el-icon><Delete/></el-icon>
                                  </span>
                              </span>
                            </div>
                        </template>
                    </el-upload>
                    <!-- End FileUpload -->
                    <h2 class="font-medium mb-3">Иконка для меню</h2>
                    <!-- FileUpload -->
                    <el-upload action="#" list-type="picture-card"
                               :limit="1"
                               :auto-upload="false"
                               v-model:fileList="Icons"
                               @input="form.icon = $event.target.files[0]" :on-remove="handleRemoveIcons"
                               class="file-uploader-one"
                               ref="template"
                    >
                        <el-icon><Plus/></el-icon>
                        <template #file="{ file }">
                            <div>
                                <img class="el-upload-list__item-thumbnail" :src="file.url" alt=""/>
                                <span class="el-upload-list__item-actions">
                                  <span class="el-upload-list__item-preview" @click="handlePictureCardPreview(file)">
                                    <el-icon><zoom-in/></el-icon>
                                  </span>
                                  <span v-if="!disabled" class="el-upload-list__item-delete" @click="handleRemoveIcons(file)">
                                    <el-icon><Delete/></el-icon>
                                  </span>
                              </span>
                            </div>
                        </template>
                    </el-upload>
                    <!-- End FileUpload -->
                </div>
                <div class="p-4">
                    <h2 class="font-medium text-lg mb-3">Специалисты:</h2>
                    <div v-for="employee in employees">
                        <el-checkbox v-model="form.employees" :label="employee.fullname"
                                     type="checkbox" :checked="employee.checked"
                                     :value="employee.id"
                        />
                    </div>
                </div>
            </div>
            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>

        <!-- File Preview -->
        <el-dialog v-model="dialogVisible">
            <img w-full :src="dialogImageUrl" alt="Preview Image"/>
        </el-dialog>
    </div>
</template>


<script lang="ts" setup>
    import {Head} from '@inertiajs/vue3'
    import {reactive, ref} from 'vue'
    import {router} from "@inertiajs/vue3";
    import {func} from "/resources/js/func.js"
    import {UploadFile} from "element-plus";
    import {useStore} from '/resources/js/store.js'
    const store = useStore();

    const dialogImageUrl = ref('')
    const dialogVisible = ref(false)
    const disabled = ref(false)
    const Images = ref<UploadFile>();
    const Icons = ref<UploadFile>();

    const props = defineProps({
        errors: Object,
        route: String,
        title: {
            type: String,
            default: 'Создание новой специальности',
        },
        employees: Array,
    });

    const form = reactive({
        name: null,
        slug: null,
        h1: null,
        title: null,
        description: null,
        image: null,
        icon: null,
        employees: [],

    })
    function handleMaskSlug(val)
    {
        form.slug = func.MaskSlug(val);
    }

    function onSubmit() {
        router.post(props.route, form)
    }

    const handleRemoveImages = (file: UploadFile) => {
        Images.value.splice(0, 1);
    }

    const handleRemoveIcons = (file: UploadFile) => {
        Icons.value.splice(0, 1);
    }

    const handlePictureCardPreview = (file: UploadFile) => {
        dialogImageUrl.value = file.url!
        dialogVisible.value = true
    }

</script>
<script lang="ts">
    import Layout from '@/Components/Layout.vue'

    export default {
        layout: Layout,
    }
</script>
