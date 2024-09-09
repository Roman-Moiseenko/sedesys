<template>
    <h2 v-if="$props.label">{{ $props.label}}</h2>
    <h3>Мета данные</h3>
    <el-form-item label="H1">
        <el-input
            v-model="$props.meta.h1"
            placeholder="H1 для вывода на странице" maxlength="160" show-word-limit/>
        <div v-if="errors['meta.h1']" class="text-red-700">{{ errors['meta.h1'] }}</div>
    </el-form-item>
    <el-form-item label="Заголовок">
        <el-input v-model="$props.meta.title" placeholder="Meta-Title" maxlength="200" show-word-limit/>
        <div v-if="errors['meta.title']" class="text-red-700">{{ errors['meta.title'] }}</div>
    </el-form-item>
    <el-form-item label="Описание">
        <el-input v-model="$props.meta.description" placeholder="Meta-Description" :rows="3" type="textarea" maxlength="250"
                  show-word-limit/>
        <div v-if="errors['meta.description']" class="text-red-700">{{ errors['meta.description'] }}</div>
    </el-form-item>

    <h3>Секция хлебных крошек</h3>
    <ImagesFromGallery
        v-model:photo_id="$props.breadcrumb.photo_id"
        :error="errors['breadcrumb.photo_id']"
        @updatePhotoId="onUpdateParent"
    />
    <el-form-item label="Заголовок">
        <el-input v-model="$props.breadcrumb.caption" placeholder="Оставьте пустым, если совпадает с H1" maxlength="200"
                  show-word-limit/>
        <div v-if="errors['breadcrumb.caption']" class="text-red-700">{{ errors['breadcrumb.caption'] }}</div>
    </el-form-item>
    <el-form-item label="Текст">
        <el-input v-model="$props.breadcrumb.description" placeholder="Если предусмотренно макетом" :rows="2" type="textarea"
                  maxlength="250" show-word-limit/>
        <div v-if="errors['breadcrumb.description']" class="text-red-700">{{ errors['breadcrumb.description'] }}</div>
    </el-form-item>
    <el-divider/>
</template>

<script lang="ts" setup>
import { defineEmits } from 'vue'
import ImagesFromGallery from '@/Components/ImagesFromGallery.vue'

const emitAwesome = defineEmits(['update:awesome'])
const props = defineProps({
    errors: Object,
    meta: Object,
    breadcrumb: Object,
    label: {
        type: String,
        default: null,
    },
});
</script>

<script lang="ts">
export default {
    data() {
        return {
            meta: this.$props.meta,
            breadcrumb: this.$props.breadcrumb,
        }
    },
    methods: {
        onUpdateParent(val) {
            this.$data.breadcrumb.photo_id = val.photo_id
        },
    },
}

</script>

<style scoped>

</style>
