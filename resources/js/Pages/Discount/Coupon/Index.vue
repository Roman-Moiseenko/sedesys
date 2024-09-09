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
                :max-height="$data.tableHeight"
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
                            @click.stop="handleDelete(scope.$index, scope.row)"
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
    <!-- Dialog Delete -->
    <el-dialog v-model="$data.dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить coupon?
        </div>
        <div class="text-red-600 text-md mt-2">
            Восстановить данные будет невозможно!
        </div>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="$data.dialogDelete = false">Отмена</el-button>
                <el-button type="danger" @click="removeItem($data.routeDestroy)">
                    Удалить
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
    import { useStore } from "/resources/js/store.js"
    import { Head, Link } from '@inertiajs/vue3'
    import Pagination from '@/Components/Pagination.vue'
    import ru from 'element-plus/dist/locale/ru.mjs'
    import TableFilter from '@/Components/TableFilter.vue'

    const store = useStore();

    interface IRow {
        active: number,

    }
    const tableRowClassName = ({row, rowIndex}: {row: IRow }) => {
        if (row.active === false) {
            return 'warning-row'
        }
        return ''
    }
</script>

<script lang="ts">
import Layout from '@/Components/Layout.vue'
import { router } from '@inertiajs/vue3'

export default {

    layout: Layout,
    props: {
        coupons: Object,
        title: {
            type: String,
            default: 'Список скидочных купонов',
        },
        filters: Array,
        statuses: Array,
    },
    data() {
        return {
            tableData: [...this.coupons.data],
            tableHeight: '600',
            Loading: false,
            dialogDelete: false,
            routeDestroy: null,
            /**
             * Данные для формы-фильтр
             */
            filter: {
                status: this.$props.filters.status,
                //
            }
        }
    },
    methods: {
        createButton() {
            router.get('/admin/discount/coupon/create')
        },
        routeClick(row) {
            router.get(row.url)
        },
        handleEdit(index, row) {
            router.get(row.edit);
        },

        handleDelete(index, row) {
            this.$data.dialogDelete = true;
            this.$data.routeDestroy = row.destroy;
        },
        removeItem(_route) {
            if (_route !== null) {
                router.visit(_route, {
                    method: 'delete'
                });
                this.$data.dialogDelete = false;
                this.$data.routeDestroy = null;
            }
        },
    }
}
</script>

<style >
    .el-table tr.warning-row {
        --el-table-tr-bg-color: var(--el-color-warning-light-7);
    }
    .el-table .success-row {
        --el-table-tr-bg-color: var(--el-color-success-light-9);
    }
</style>
