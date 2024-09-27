<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Скидочные купоны</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Создать купоны</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">

                <el-select v-model="filter.status" placeholder="Статус">
                    <el-option v-for="item in statuses" :value="item.value" :key="item.value" :label="item.label"/>
                </el-select>
            </TableFilter>
        </div>
        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="600"
                style="width: 100%;"
                :row-class-name="tableRowClassName"
                v-loading="store.getLoading"
            >
                <!-- Повторить поля -->
                <el-table-column prop="created_at" label="Дата" width="160" />
                <el-table-column prop="user" label="Клиент" />
                <el-table-column prop="bonus" label="Сумма скидки" width="120" />
                <el-table-column prop="finished_at" label="Срок действия" width="160" />
                <el-table-column prop="min" label="Мин.сумма заказа" width="100" />
                <el-table-column prop="status" label="Статус" width="120" />

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
            :current_page="$page.props.coupons.current_page"
            :per_page="$page.props.coupons.per_page"
            :total="$page.props.coupons.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="купон" />

</template>

<script lang="ts" setup>
import { useStore } from "/resources/js/store.js"
import { Head, router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import TableFilter from '@/Components/TableFilter.vue'
import {inject, reactive, ref} from "vue";

const props = defineProps({
    coupons: Object,
    title: {
        type: String,
        default: 'Список скидочных купонов',
    },
    filters: Array,
    statuses: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.coupons.data])
const filter = reactive({
    status: props.filters.status
})

interface IRow {
    active: number,

}
const tableRowClassName = ({row, rowIndex}: {row: IRow }) => {
    if (row.active === false) {
        return 'warning-row'
    }
    return ''
}

function createButton() {
    router.get(route('admin.discount.coupon.create'))
}
function routeClick(row) {
    router.get(route('admin.discount.coupon.show', {coupon: row.id}))
}
function handleDeleteEntity(row) {
    $delete_entity.show(route('admin.discount.coupon.destroy', {coupon: row.id}));
}
</script>

