<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Обслуживающий персонал</h1>
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить Персонал</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.user" placeholder="Имя, Телефон, Email"/>
                <el-select v-model="filter.specialization" placeholder="Специализация" class="mt-1">
                    <el-option v-for="item in $props.specializations" :key="item.value" :label="item.label" :value="item.value"/>
                </el-select>
                <el-checkbox v-model="filter.draft" label="Заблокированные" :checked="filter.draft"/>
            </TableFilter>
        </div>

        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="$data.tableHeight"
                style="width: 100%; cursor: pointer;"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                v-loading="store.getLoading"
            >
                <el-table-column prop="phone" label="Телефон" width="120"/>
                <el-table-column sortable prop="fullname" label="ФИО"/>
                <el-table-column sortable prop="address" label="Адрес"/>

                <!-- Повторить -->
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
                            @click.stop="handleEdit(scope.$index, scope.row)">
                            Edit
                        </el-button>
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
            :current_page="$page.props.employees.current_page"
            :per_page="$page.props.employees.per_page"
            :total="$page.props.employees.total"
        />
    </el-config-provider>
    <!-- Dialog Delete -->
    <el-dialog v-model="$data.dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить персонал?
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
import {useStore} from "/resources/js/store.js"
import TableFilter from '@/Components/TableFilter.vue'

const store = useStore();

interface IRow {
    /**
     * Статусы
     */
    active: number
}

const tableRowClassName = ({row, rowIndex}: { row: IRow }) => {
    if (row.active === 0) {
        return 'warning-row'
    }
    return ''
}
</script>

<script lang="ts">
import {Head, Link} from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'
import {router} from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'


export default {
    components: {
        Head,
        Pagination
    },
    layout: Layout,
    props: {
        employees: Object,
        title: {
            type: String,
            default: 'Список персонала',
        },
        filters: Array,
        specializations: Array,
    },
    data() {
        return {
            tableData: [...this.employees.data],
            tableHeight: '600',
            Loading: false,
            dialogDelete: false,
            routeDestroy: null,
            /**
             * Данные для формы-фильтр
             */
            filter: {
                user: this.$props.filters.user,
                draft: this.$props.filters.draft,
                specialization: this.$props.filters.specialization
            },
        }
    },
    methods: {
        createButton() {
            router.get('/admin/employee/employee/create')
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

        handleToggle(index, row) {
            router.visit(row.toggle, {
                method: 'post'
            });
        },
    }
}
</script>

<style>
.el-table tr.warning-row {
    --el-table-tr-bg-color: var(--el-color-warning-light-7);
}

.el-table .success-row {
    --el-table-tr-bg-color: var(--el-color-success-light-9);
}
</style>
