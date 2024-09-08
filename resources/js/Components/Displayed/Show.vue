<template>
    <el-tab-pane>
        <template #label>
            <span class="custom-tabs-label">
                <el-icon><Document/></el-icon>
                <span> Текст</span>
            </span>
        </template>
        <div class="mt-5 p-5 bg-white rounded-lg border shadow" v-html="model.text" style="min-height: 300px; max-height: 600px; overflow-y:scroll;"></div>
    </el-tab-pane>
    <el-tab-pane>
        <template #label>
            <span class="custom-tabs-label">
                <el-icon><Memo/></el-icon>
                <span> Отображаемые данные</span>
            </span>
        </template>
        <div class="grid lg:grid-cols-6 grid-cols-1 divide-x">
            <div class="p-4 col-span-4">
                <el-descriptions :column="2" border>
                    <slot />
                    <el-descriptions-item label="Название">{{ model.name }}</el-descriptions-item>
                    <el-descriptions-item label="Ссылка">{{ model.slug }}</el-descriptions-item>
                    <el-descriptions-item label="Шаблон">{{ model.template }}</el-descriptions-item>
                    <el-descriptions-item label="Страница (H1)">{{ model.meta.h1 }}</el-descriptions-item>
                    <el-descriptions-item label="Заголовок (meta)">{{ model.meta.title }}</el-descriptions-item>
                    <el-descriptions-item label="Описание (meta)">{{ model.meta.description }}</el-descriptions-item>
                    <el-descriptions-item label="Фон для секции">
                        <div class="" style="height: 32px; display: flex;width: auto;">
                            <el-image
                                :src="selectedPhoto"
                                :zoom-rate="1.2"
                                :max-scale="1"
                                :min-scale="0.2"
                                :preview-src-list="[selectedPhoto]"
                                :initial-index="0"
                                fit="cover"
                            />
                        </div>
                    </el-descriptions-item>
                    <el-descriptions-item label="Заголовок секции">{{ model.breadcrumb.caption }}</el-descriptions-item>
                    <el-descriptions-item label="Доп.описание секции">{{ model.breadcrumb.description }}</el-descriptions-item>
                    <el-descriptions-item label="Font Awesome">{{ model.awesome }}</el-descriptions-item>
                </el-descriptions>
            </div>
            <div class="p-4 col-span-2 flex">
                <DisplayedImagePanel :image="$props.image" :icon="$props.icon" />
            </div>
        </div>
    </el-tab-pane>
</template>
<script lang="ts" setup>
import {defineProps, ref} from 'vue'
import DisplayedImagePanel from '@/Components/Displayed/Image.vue'
import axios from "axios";

const urlPhoto = '/admin/page/gallery/get-photo'
const props = defineProps({
    model: Object,
    image: String,
    icon: String,
    first_text: {
        type: Boolean,
        default: false,
    }
});

const selectedPhoto = ref(null)

setPhoto(props.model.breadcrumb.photo_id)

function setPhoto(val) {
    if (props === null) return;
    axios.post(urlPhoto, {photo_id: val})
        .then(response => {
            console.log(response.data);
            if (response.data === false) {
                selectedPhoto.value = null;
            } else {
                selectedPhoto.value = response.data;
            }
        });
}
</script>

<script lang="ts">

export default {
    name: "Show"
}
</script>

<style scoped>

</style>
