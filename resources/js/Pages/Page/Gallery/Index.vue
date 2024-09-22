<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Галерея</h1>
        <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить Галерею</el-button>

        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="$data.tableHeight"
                style="width: 100%; cursor: pointer;"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                v-loading="store.getLoading"
            >
                <el-table-column sortable prop="name" label="Название" width="240" />
                <el-table-column prop="slug" label="Ссылка" width="240"/>
                <el-table-column prop="count" label="Изображений" align="center" width="150"/>
                <el-table-column prop="description" label="Описание" />
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
                            @click.stop="handleDeleteEntity(scope.row)"
                        >
                            Delete
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <pagination
            :current_page="$page.props.galleries.current_page"
            :per_page="$page.props.galleries.per_page"
            :total="$page.props.galleries.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="галерею" />

</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue"
import { Head, router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import { useStore } from "/resources/js/store.js"

const props = defineProps({
    galleries: Object,
    title: {
        type: String,
        default: 'Список галерей',
    },
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.galleries.data])

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
    router.get('/admin/page/gallery/create')
}
function routeClick(row) {
    router.get(row.url)
}
</script>
