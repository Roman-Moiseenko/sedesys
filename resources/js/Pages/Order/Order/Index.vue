<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Заказы</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Новый Заказ</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.name" placeholder="Name"/>
            </TableFilter>
        </div>
        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="600"
                style="width: 100%; cursor: pointer;"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                v-loading="store.getLoading"
            >
                <!-- Повторить поля -->
                <el-table-column sortable prop="created_at" label="Дата" width="160" />
                <el-table-column prop="number" label="№" width="100" />
                <el-table-column prop="user" label="Клиент" width="180" />
                <el-table-column prop="status.text" label="Статус" width="180" />
                <el-table-column prop="amount" label="Сумма" width="120" >
                    <template #default="scope">
                        {{ func.price(scope.row.amount)}}
                    </template>
                </el-table-column>
                <el-table-column sortable prop="comment" label="Комментарий"/>

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

        <pagination
            :current_page="$page.props.orders.current_page"
            :per_page="$page.props.orders.per_page"
            :total="$page.props.orders.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="заказ" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue";
import { useStore } from "/resources/js/store.js"
import { Head, Link, router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import TableFilter from '@/Components/TableFilter.vue'
import {func} from "/resources/js/func.js"

const props = defineProps({
    orders: Object,
    title: {
        type: String,
        default: 'Список Заказов',
    },
    filters: Array,
    create: String,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.orders.data])
const filter = reactive({
    name: props.filters.name,
    //TODO Поиск по клиенту, менеджеру, статусу, дате от-до
})


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
    router.post(props.create)
}
function routeClick(row) {
    router.get(row.url)
}
</script>
