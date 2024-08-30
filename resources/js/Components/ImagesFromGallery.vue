<template>

    <div class="flex">
        <el-form-item label="Фон">
            <el-input-number :controls="false" v-model="$props.photo_id" placeholder="id картинки из Галереи"
                             :disabled="true" style="width: 60px; display: none"/>
            <el-button round @click="getGallery">Выбрать</el-button>
            <div class="" style="width: 32px; height: 32px; min-height: 32px">
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
        </el-form-item>
    </div>

    <el-dialog
        v-model="dialogVisible"
        title="Галерея загруженных фотографий"
        width="90%"
    >
        <el-tabs type="border-card" class="" v-model="editableTabsValue">
            <el-tab-pane
                v-for="item in galleries"
                :key="item.id"
                :label="item.name"
                :name="item.id"
            >
                <el-radio-group v-model="select.id">
                    <el-radio-button v-for="image in item.images" :key="image.id" :value="image.id">
                        <img :src="image.src"/>
                    </el-radio-button>
                </el-radio-group>
            </el-tab-pane>
        </el-tabs>
        <el-button @click="selectPhoto" type="primary" class="mt-3">Выбрать</el-button>
    </el-dialog>
</template>

<script lang="ts" setup>
import {defineProps, reactive, ref} from 'vue'
import axios from 'axios'

const dialogVisible = ref(false)
const editableTabsValue = ref(1)
const selectedPhoto = ref(null)
const urlGallery = '/admin/page/gallery/get-tree'
const urlPhoto = '/admin/page/gallery/get-photo'
const props = defineProps({
    error: String,
    photo_id: Number,
    image: String,

});
const select = reactive({
    id: props.photo_id,
});
const galleries = ref([]);
const emit = defineEmits(['updatePhotoId']);
const selectPhoto = function () {
    emit('updatePhotoId', {
        photo_id: select.id,
    });
    setPhoto(select.id);
    dialogVisible.value = false;
}

setPhoto(props.photo_id)

function getGallery() {
    axios.post(urlGallery)
        .then(response => {
            galleries.value = response.data;
            dialogVisible.value = true;
        });
}

function setPhoto(val) {
    if (props === null) return;
    axios.post(urlPhoto, {photo_id: val})
        .then(response => {
            selectedPhoto.value = response.data;
        });
}
</script>

<style scoped>

</style>
