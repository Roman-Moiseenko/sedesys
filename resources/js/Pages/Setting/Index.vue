<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Настройки</h1>

        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="600"
                style="width: 100%; cursor: pointer;"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                v-loading="store.getLoading"
            >
                <el-table-column sortable prop="name" label="Название" width="240"/>
                <el-table-column sortable prop="slug" label="Ссылка" width="240"/>
                <el-table-column prop="description" label="Описание" />
            </el-table>
        </div>

        <pagination
            :current_page="$page.props.settings.current_page"
            :per_page="$page.props.settings.per_page"
            :total="$page.props.settings.total"
        />
    </el-config-provider>

</template>

<script lang="ts" setup>
import { Head, router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import { useStore } from "/resources/js/store.js"
import {defineProps, ref} from "vue/dist/vue";

const props = defineProps({
    settings: Object,
    title: {
        type: String,
        default: 'Список Классов настроек',
    }
})
const store = useStore();
const Loading = ref(false)
const tableData = ref([...props.settings.data])
interface IRow {
    active: number
}
const tableRowClassName = ({row, rowIndex}: {row: IRow }) => {
    if (row.active === false) {
        return 'warning-row'
    }
    return ''
}
function routeClick(row) {
    router.get(row.url)
}
</script>


