<template>
    <el-descriptions :column="2" border title="Данные для публикуемой страницы" class="mt-3">
    <el-descriptions-item label="Страница (H1)">{{ displayed.meta.h1 }}</el-descriptions-item>
    <el-descriptions-item label="Заголовок (meta)">{{ displayed.meta.title }}</el-descriptions-item>
    <el-descriptions-item label="Описание (meta)">{{ displayed.meta.description }}</el-descriptions-item>
    <el-descriptions-item label="Фон для секции">{{ displayed.breadcrumb.photo_id }}</el-descriptions-item>
    <el-descriptions-item label="Заголовок секции">{{ displayed.breadcrumb.caption }}</el-descriptions-item>
    <el-descriptions-item label="Доп.описание секции">{{ displayed.breadcrumb.description }}</el-descriptions-item>
    <el-descriptions-item label="Font Awesome">{{ displayed.awesome }}</el-descriptions-item>
    </el-descriptions>
</template>

<script lang="ts" setup>
import { defineProps } from 'vue'
const props = defineProps({
    displayed: Object,
});
</script>

