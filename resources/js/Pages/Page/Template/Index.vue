<template>
    <Head><title>{{ title }}</title></Head>

    <h1 class="font-medium text-xl">Шаблоны</h1>
    <div class="flex">
        <el-button type="primary" class="p-4 my-3" @click="dialogFormVisible = true">Создать Шаблон</el-button>
        <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
            <el-select v-model="filter.type" placeholder="Вид шаблона" class="mt-1">
                <el-option v-for="item in $props.types" :key="item.value" :label="item.label" :value="item.value"/>
            </el-select>
        </TableFilter>
    </div>
    <div class="mt-2 p-5 bg-white rounded-md">
        <el-table
            :data="tableData"
            :max-height="600"
            style="width: 100%; cursor: pointer;"
            @row-click="routeClick"
        >
            <el-table-column sortable prop="name" label="Название"/>
            <el-table-column sortable prop="template" label="Шаблон" width="150"/>
            <el-table-column sortable prop="type_name" label="Вид" width="100"/>
            <el-table-column prop="file" label="Путь"/>

            <el-table-column label="Действия" align="right">
                <template #default="scope">
                    <el-button
                        size="small"
                        type="danger"
                        @click.stop="handleDeleteEntity(scope.row)"
                    >
                        Delete
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>
    <DeleteEntityModal name_entity="шаблон" />

    <el-dialog v-model="dialogFormVisible" title="Создать шаблон" width="500">
        <el-form :model="form">
            <el-form-item label="Название шаблона">
                <el-input v-model="form.name" autocomplete="off" placeholder="На русском" />
            </el-form-item>
            <el-form-item label="Шаблон">
                <el-input v-model="form.template" autocomplete="off" placeholder="Имя файла"
                          :formatter="(val) => func.MaskSlug(val)"/>
            </el-form-item>
            <el-form-item label="Тип шаблона">
                <el-select v-model="form.type" placeholder="Выберите тип">
                    <el-option v-for="item in $props.types" :label="item.label" :value="item.value" :key="item.value"/>
                </el-select>
            </el-form-item>
        </el-form>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Отмена</el-button>
                <el-button type="primary" @click="onSubmit">
                    Создать
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue";
import ru from 'element-plus/dist/locale/ru.mjs'
import TableFilter from '@/Components/TableFilter.vue'
import {Head, router} from '@inertiajs/vue3'
import {func} from "/resources/js/func.js"

const props = defineProps({
    templates: Array,
    title: {
        type: String,
        default: 'Список Шаблонов',
    },
    types: Array,
    filters: Array,
})
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const dialogFormVisible = ref(false)
const tableData = ref([...props.templates])
const filter = reactive({
    type: props.filters.type,
})
const form = reactive({
    name: null,
    template: null,
    type: null,
})
function handleDeleteEntity(row) {
    $delete_entity.show(route('admin.page.template.destroy', {type: row.type, template: row.template}));
}
function onSubmit() {
    dialogFormVisible.value = false;
    router.post(route('admin.page.template.store'), form, { preserveState: true });
}
function routeClick(row) {
    router.get(route('admin.page.template.show', {type: row.type, template: row.template}));
}
</script>


