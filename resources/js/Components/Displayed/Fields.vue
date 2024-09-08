<template>
    <el-tab-pane>
        <template #label>
                    <span class="custom-tabs-label">
                        <el-icon><Memo/></el-icon>
                        <span> Отображаемые данные</span>
                    </span>
        </template>
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            <div class="p-4">
                <el-form-item label="Название" :rules="{required: true}">
                    <el-input v-model="$props.displayed.name" placeholder="Название"/>
                    <div v-if="errors['displayed.name']" class="text-red-700">{{ errors['displayed.name'] }}</div>
                </el-form-item>
                <el-form-item label="Ссылка">
                    <el-input v-model="$props.displayed.slug" placeholder="Оставьте пустым для автозаполнения"
                              @input="handleMaskSlug"/>
                    <div v-if="errors['displayed.slug']" class="text-red-700">{{ errors['displayed.slug'] }}</div>
                </el-form-item>

                <el-form-item label="Шаблон">
                    <el-select v-model="$props.displayed.template" placeholder="Select">
                        <el-option :key="null" label="" :value="null"/>
                        <el-option v-for="item in templates" :key="item.value" :label="item.label" :value="item.value"/>
                    </el-select>
                    <div v-if="errors['displayed.template']" class="text-red-700">{{ errors['displayed.template'] }}</div>
                </el-form-item>

                <slot />
            </div>
            <div class="p-4">
                <h3>Секция хлебных крошек</h3>
                <ImagesFromGallery
                    v-model:photo_id="$props.displayed.breadcrumb.photo_id"
                    :error="errors['displayed.breadcrumb.photo_id']"
                    @updatePhotoId="onUpdateParent"
                />
                <el-form-item label="Заголовок">
                    <el-input v-model="$props.displayed.breadcrumb.caption" placeholder="Оставьте пустым, если совпадает с H1" maxlength="200"
                              show-word-limit/>
                    <div v-if="errors['displayed.breadcrumb.caption']" class="text-red-700">{{ errors['displayed.breadcrumb.caption'] }}</div>
                </el-form-item>
                <el-form-item label="Текст">
                    <el-input v-model="$props.displayed.breadcrumb.description" placeholder="Если предусмотренно макетом" :rows="2" type="textarea"
                              maxlength="250" show-word-limit/>
                    <div v-if="errors['displayed.breadcrumb.description']" class="text-red-700">{{ errors['displayed.breadcrumb.description'] }}</div>
                </el-form-item>
            </div>
            <div class="p-4">
                <h3>Мета данные</h3>
                <el-form-item label="H1">
                    <el-input
                        v-model="$props.displayed.meta.h1"
                        placeholder="H1 для вывода на странице" maxlength="160" show-word-limit/>
                    <div v-if="errors['displayed.meta.h1']" class="text-red-700">{{ errors['displayed.meta.h1'] }}</div>
                </el-form-item>
                <el-form-item label="Заголовок">
                    <el-input v-model="$props.displayed.meta.title" placeholder="Meta-Title" maxlength="200" show-word-limit/>
                    <div v-if="errors['displayed.meta.title']" class="text-red-700">{{ errors['displayed.meta.title'] }}</div>
                </el-form-item>
                <el-form-item label="Описание">
                    <el-input v-model="$props.displayed.meta.description" placeholder="Meta-Description" :rows="3" type="textarea" maxlength="250"
                              show-word-limit/>
                    <div v-if="errors['displayed.meta.description']" class="text-red-700">{{ errors['displayed.meta.description'] }}</div>
                </el-form-item>
            </div>
        </div>
    </el-tab-pane>
    <el-tab-pane>
        <template #label>
                    <span class="custom-tabs-label">
                        <el-icon><Document/></el-icon>
                        <span> Текст</span>
                    </span>
        </template>
        <!-- TinyMCE -->
        <editor
            :api-key="tiny_api" v-model="$props.displayed.text"
            :init="store.tiny"
        />
        <div v-if="errors['displayed.text']" class="text-red-700">{{ errors['displayed.text'] }}</div>
    </el-tab-pane>
    <el-tab-pane>
        <template #label>
                    <span class="custom-tabs-label">
                        <el-icon><Picture/></el-icon>
                        <span> Изображения</span>
                    </span>
        </template>
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            <div class="p-4">
                <UploadImageFile
                    label="Изображение для каталога"
                    v-model:image="$props.displayed.image"
                    @selectImageFile="onSelectImage"
                />
            </div>
            <div class="p-4">
                <UploadImageFile
                    label="Иконка для меню"
                    v-model:image="$props.displayed.icon"
                    @selectImageFile="onSelectIcon"
                />
            </div>
            <div class="p-4">
                <h2 class="font-medium mb-3">SVG-иконка для меню</h2>
                <el-form-item label="Font Awesome" class="mt-2">
                    <el-input v-model="$props.displayed.awesome"
                              placeholder="fa-light fa-car" maxlength="50" show-word-limit/>
                    <div v-if="errors['displayed.awesome']" class="text-red-700">{{ errors['displayed.awesome'] }}</div>
                </el-form-item>
            </div>
        </div>


    </el-tab-pane>
</template>

<script lang="ts" setup>
import { defineProps } from 'vue'
import ImagesFromGallery from '@/Components/ImagesFromGallery.vue'
import UploadImageFile from '@/Components/UploadImageFile.vue'
import {useStore} from '/resources/js/store.js'

const store = useStore();

const props = defineProps({
    errors: Object,
    displayed: Object,
    label: {
        type: String,
        default: null,
    },
    templates: Array,
    tiny_api: String,
});
</script>

<script lang="ts">
import Editor from '@tinymce/tinymce-vue'
import {func} from "/resources/js/func.js"

export default {
    components: {
        'editor': Editor,
    },
    data() {
        return {
            displayed: this.$props.displayed,
        }
    },
    methods: {
        onUpdateParent(val) {
            this.$data.displayed.breadcrumb.photo_id = val.photo_id
        },
        onSelectImage(val) {
            this.$data.displayed.clear_image = val.clear_file;
            this.$data.displayed.image = val.file
        },
        onSelectIcon(val) {
            this.$data.displayed.clear_icon = val.clear_file;
            this.$data.displayed.icon = val.file
        },
        handleMaskSlug(val) {
            this.$data.displayed.slug = func.MaskSlug(val);
        }
    },
}

</script>

<style scoped>

</style>
