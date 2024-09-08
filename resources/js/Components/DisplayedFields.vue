<template>
    <h2 v-if="$props.label">{{ $props.label}}</h2>
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
    <el-divider/>
    <el-form-item label="Font Awesome" class="mt-2">
        <el-input v-model="$props.displayed.awesome"
                  placeholder="fa-light fa-car" maxlength="50" show-word-limit/>
        <div v-if="errors['displayed.awesome']" class="text-red-700">{{ errors['displayed.awesome'] }}</div>
    </el-form-item>
    <el-form-item label="Шаблон">
        <el-select v-model="$props.displayed.template" placeholder="Select">
            <el-option :key="null" label="" :value="null"/>
            <el-option v-for="item in templates" :key="item.value" :label="item.label" :value="item.value"/>
        </el-select>
        <div v-if="errors['displayed.template']" class="text-red-700">{{ errors['displayed.template'] }}</div>
    </el-form-item>
</template>

<script lang="ts" setup>
import { defineEmits } from 'vue'
import ImagesFromGallery from '@/Components/ImagesFromGallery.vue'

const emitAwesome = defineEmits(['update:awesome'])
const props = defineProps({
    errors: Object,
    displayed: Object,
    label: {
        type: String,
        default: null,
    },
    templates: Array,
});


</script>

<script lang="ts">
export default {
    data() {
        return {
            displayed: this.$props.displayed,
        }
    },
    methods: {
        onUpdateParent(val) {
            this.$data.displayed.breadcrumb.photo_id = val.photo_id
        },
    },
}

</script>

<style scoped>

</style>
