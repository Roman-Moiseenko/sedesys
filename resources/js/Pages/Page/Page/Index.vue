<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Страницы</h1>
        <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить страницу</el-button>

        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="600"
                style="width: 100%; cursor: pointer;"
                row-key="id"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                default-expand-all
            >
                <el-table-column sortable prop="name" label="Название" />
                <el-table-column sortable prop="slug" label="Ссылка"  />
                <el-table-column sortable prop="template" label="Шаблон" />
                <el-table-column sortable prop="published" label="Дата публикации"/>

                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button v-if="scope.row.active"
                                   size="small"
                                   type="warning"
                                   @click.stop="handleToggle(scope.$index, scope.row)">
                            Blocked
                        </el-button>
                        <el-button v-if="!scope.row.active"
                                   size="small"
                                   type="success"
                                   @click.stop="handleToggle(scope.$index, scope.row)">
                            Activated
                        </el-button>
                        <el-button
                            size="small"
                            @click.stop="router.get(scope.row.edit)">
                            Edit
                        </el-button>
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

    </el-config-provider>
    <DeleteEntityModal name_entity="страницу" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue";
import ru from 'element-plus/dist/locale/ru.mjs'
import { useStore } from "/resources/js/store.js"
import {Head, router} from '@inertiajs/vue3'

const props = defineProps({
    pages: Object,
    title: {
        type: String,
        default: 'Список страниц',
    },
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.pages])

interface IRow {
    active: number
}
const tableRowClassName = ({row, rowIndex}: {row: IRow }) => {
    if (row.active === false) {
        return 'warning-row'
    }
    return ''
}
function handleDeleteEntity(row) {
    $delete_entity.show(row.destroy);
}
function createButton() {
    router.get('/admin/page/page/create')
}
function routeClick(row) {
    router.get(row.url)
}
function handleToggle(index, row) {
    router.visit(row.toggle, {
        method:'post'});
}
</script>


