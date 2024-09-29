<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Платежи</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить платеж</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="filters.count">
                <el-input v-model="filter.user" placeholder="ФИО, Телефон, Email"/>
                <el-date-picker
                    v-model="filter.date_from"
                    type="date"
                    class="mt-1"
                    placeholder="Выберите дату с"
                    value-format="YYYY-MM-DD"
                />
                <el-date-picker
                    v-model="filter.date_to"
                    type="date"
                    class="mt-1"
                    placeholder="Выберите дату по"
                    value-format="YYYY-MM-DD"
                />
                <el-select v-model="filter.method" class="mt-1" placeholder="Способ">
                    <el-option v-for="item in methods" :key="item.value" :value="item.value" :label="item.label" />
                </el-select>
                <el-input v-model="filter.order" class="mt-1" placeholder="Заказ №"/>
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
                <el-table-column sortable prop="created_at" label="Дата" width="180" />
                <el-table-column prop="order" label="Заказ" width="240" />
                <el-table-column label="Клиент" width="260" >
                    <template #default="scope">
                        <div>{{ func.fullName(scope.row.user.fullname)}}</div>
                        <div style="size: 13px; color: var(--el-text-color-secondary);">{{ func.phone(scope.row.user.phone)}}</div>
                    </template>
                </el-table-column>
                <el-table-column label="Платеж" width="100" >
                    <template #default="scope">
                        {{ func.price(scope.row.amount)}}
                    </template>
                </el-table-column>
                <el-table-column prop="method_text" label="Способ" width="120" />
                <el-table-column prop="document" label="Документ" show-overflow-tooltip />
                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button
                            v-if="scope.row.is_edit"
                            size="small"
                            @click.stop="handleEdit(scope.row)">
                            Edit
                        </el-button>
                        <el-button
                            v-if="scope.row.is_edit"
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
            :current_page="$page.props.orderPayments.current_page"
            :per_page="$page.props.orderPayments.per_page"
            :total="$page.props.orderPayments.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="платеж" />
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
    orderPayments: Object,
    title: {
        type: String,
        default: 'Список платежей',
    },
    filters: Array,
    methods: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.orderPayments.data])
const filter = reactive({
    user: props.filters.user,
    order: props.filters.order,
    method: props.filters.method,
    date_from: props.filters.date_from,
    date_to: props.filters.date_to,
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
function handleEdit(row) {
    router.get(route('admin.order.payment.edit', {payment: row.id}))
}
function handleDeleteEntity(row) {
    $delete_entity.show(route('admin.order.payment.destroy', {payment: row.id}));
}
function createButton() {
    router.get(route('admin.order.payment.create'))
}
function routeClick(row) {
    router.get(route('admin.order.payment.show', {payment: row.id}))
}
</script>
