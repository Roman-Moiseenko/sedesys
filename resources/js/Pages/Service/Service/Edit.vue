<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ service.name }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">

            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <!-- Повторить поля -->
                    <el-form-item label="Классификация">
                        <el-select v-model="form.classification_id" placeholder="Select" style="width: 240px">
                            <el-option v-for="item in classifications" :key="item.value" :label="item.label" :value="item.value"/>
                        </el-select>
                        <div v-if="errors.classification_id" class="text-red-700">{{ errors.classification_id }}</div>
                    </el-form-item>
                    <el-form-item label="Название" :rules="{required: true}">
                        <el-input v-model="form.name" placeholder="Название"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Ссылка">
                        <el-input v-model="form.slug" placeholder="Оставьте пустым для автозаполнения" @input="handleMaskSlug"/>
                        <div v-if="errors.slug" class="text-red-700">{{ errors.slug }}</div>
                    </el-form-item>
                    <el-form-item label="Шаблон">
                        <el-select v-model="form.template" placeholder="Select" style="width: 240px">
                            <el-option v-for="item in templates" :key="item.value" :label="item.label" :value="item.value"/>
                        </el-select>
                        <div v-if="errors.template" class="text-red-700">{{ errors.template }}</div>
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
                    <el-form-item label="Font Awesome" class="mt-2">
                        <el-input v-model="form.awesome" placeholder="fa-light fa-car" maxlength="200" show-word-limit/>
                        <div v-if="errors.awesome" class="text-red-700">{{ errors.awesome }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <el-form-item label="Цена">
                        <el-input v-model="form.price" placeholder="В рублях" @input="handleMaskPrice">
                            <template #append>₽</template>
                        </el-input>
                        <div v-if="errors.price" class="text-red-700">{{ errors.price }}</div>
                    </el-form-item>
                    <el-form-item label="Длительность">
                        <el-input v-model="form.duration" placeholder="В минутах" @input="handleMaskDuration">
                            <template #append>мин</template>
                        </el-input>
                        <div v-if="errors.duration" class="text-red-700">{{ errors.duration }}</div>
                    </el-form-item>

                    <el-form-item label="Опции">
                        <el-input v-model="form.data" placeholder="В формате JSON [{}]" :rows="5" type="textarea"/>
                        <div v-if="errors.data" class="text-red-700">{{ errors.data }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <div>
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
                    </div>
                    <div>
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
                </div>
            </div>
            <div class="w-full mt-3 mb-5">
                <!-- TinyMCE -->
                <editor
                    :api-key="$props.tiny_api" v-model="form.text"
                    :init="store.tiny"
                />
                <div v-if="errors.text" class="text-red-700">{{ errors.text }}</div>
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

    const store = useStore()
    const dialogImageUrl = ref('')
    const dialogVisible = ref(false)
    const disabled = ref(false)

    const Images = ref<UploadFile>([]);
    const Icons = ref<UploadFile>([]);

    const props = defineProps({
        errors: Object,
        route: String,
        service: Object,
        title: {
            type: String,
            default: 'Редактирование услуги',
        },
        image: String,
        icon: String,
        classifications: Array,
        templates: Array,
        tiny_api: String,
    });
    if (props.image !== null) Images.value.push({name: 'default', url: props.image,});
    if (props.icon !== null) Icons.value.push({name: 'default', url: props.icon,});
    const form = reactive({
        name: props.service.name,
        classification_id: props.service.classification_id,
        slug: props.service.slug,
        h1: props.service.meta.h1,
        title: props.service.meta.title,
        description: props.service.meta.description,
        awesome: props.service.awesome,
        image: null,
        icon: null,
        price: props.service.price,
        duration: props.service.duration,
        template: props.service.template,
        data: props.service.data,
        text: props.service.text,
        _method: 'put',
    })

    function handleMaskSlug(val) {
        form.slug = func.MaskSlug(val);
    }
    function handleMaskPrice(val) {
        form.price = func.MaskInteger(val);
    }
    function handleMaskDuration(val) {
        form.duration = func.MaskInteger(val);
    }

    function onSubmit() {
        router.post(props.route, form)
    }

</script>
<script lang="ts">
    import Layout from '@/Components/Layout.vue'
    import Editor from '@tinymce/tinymce-vue'

    export default {
        components: {
            'editor': Editor,
        },
        layout: Layout,
    }
</script>
