<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Виджеты</h1>
        <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить виджет</el-button>

        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="600"
                style="width: 100%; cursor: pointer;"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                v-loading="store.getLoading"
            >
                <el-table-column prop="short" label="код" width="120" />
                <el-table-column sortable prop="name" label="Название"  />
                <el-table-column sortable prop="template" label="Шаблон" />
                <el-table-column sortable prop="model" label="Модель"  />
                <!-- Повторить -->
                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button
                            size="small"
                            @click.stop="router.get(scope.row.edit)">
                            Edit
                        </el-button>
                        <el-button
                            size="small"
                            type="danger"
                            @click.stop="handleDeleteEntity(scope.row)">
                            Delete
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <pagination
            :current_page="$page.props.widgets.current_page"
            :per_page="$page.props.widgets.per_page"
            :total="$page.props.widgets.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="виджет" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue";
import ru from 'element-plus/dist/locale/ru.mjs'
import { useStore } from "/resources/js/store.js"
import Pagination from '@/Components/Pagination.vue'
import { Head, router } from '@inertiajs/vue3'


const props = defineProps({
    widgets: Object,
    title: {
        type: String,
        default: 'Список виджетов',
    },
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.widgets.data])

interface IRow {
    active: number
}
const tableRowClassName = ({row, rowIndex}: {row: IRow }) => {
    if (row.active === 0) {
        return 'warning-row'
    }
    return ''
}

function handleDeleteEntity(row) {
    $delete_entity.show(row.destroy);
}
function createButton() {
    router.get('/admin/page/widget/create')
}
function routeClick(row) {
    router.get(row.url)
}
</script>

