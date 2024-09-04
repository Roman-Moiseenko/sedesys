<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Правила формирования календаря</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить Правило</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.name" placeholder="Название"/>
                <el-select v-model="filter.regularity" class="mt-1" placeholder="Периодичность">
                    <el-option v-for="item in regularities" :value="item.value" :key="item.value" :label="item.label" />
                </el-select>
                <el-select v-model="filter.service" class="mt-1" placeholder="Услуга">
                    <el-option v-for="item in services" :value="item.id" :key="item.id" :label="item.name" />
                </el-select>
                <el-select v-model="filter.employee" class="mt-1" placeholder="Персонал">
                    <el-option v-for="item in employees" :value="item.id" :key="item.id" :label="func.fullName(item.fullname)" />
                </el-select>
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
                <!-- Повторить поля -->
                <el-table-column sortable prop="name" label="Название" width="240" />
                <el-table-column sortable prop="regularity" label="Периодичность" width="160" />
                <el-table-column label="Услуги">
                    <template #default="scope">
                        <el-tag type="" v-for="item in scope.row.services" class="mr-1">{{item.name}}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column label="Персонал">
                    <template #default="scope">
                        <el-tag type="success" v-for="item in scope.row.employees" class="mr-1">{{item.name}}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column prop="max" label="Максимум одновременно" width="160" />
                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button v-if="scope.row.active"
                                   size="small"
                                   type="warning"
                                   @click.stop="handleToggle(scope.$index, scope.row)">
                            Hide
                        </el-button>
                        <el-button v-if="!scope.row.active"
                                   size="small"
                                   type="success"
                                   @click.stop="handleToggle(scope.$index, scope.row)">
                            Show
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
            :current_page="$page.props.rules.current_page"
            :per_page="$page.props.rules.per_page"
            :total="$page.props.rules.total"
        />
    </el-config-provider>
    <!-- Dialog Delete -->
    <el-dialog v-model="$data.dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить правило?
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
    import {func} from '/resources/js/func.js'

    const store = useStore();

    interface IRow {
        /**
         * Статусы
        */
        active: number
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
        rules: Object,
        title: {
            type: String,
            default: 'Список правил',
        },
        filters: Array,
        regularities: Array,
        employees: Array,
        services: Array,
    },
    data() {
        return {
            tableData: [...this.rules.data],
            tableHeight: '600',
            Loading: false,
            dialogDelete: false,
            routeDestroy: null,
            /**
             * Данные для формы-фильтр
             */
            filter: {
                name: this.$props.filters.name,
                regularity: this.$props.filters.regularity,
                service: this.$props.filters.service,
                employee: this.$props.filters.employee,
            }
        }
    },
    methods: {
        createButton() {
            router.get('/admin/calendar/rule/create')
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

<style >
    .el-table tr.warning-row {
        --el-table-tr-bg-color: var(--el-color-warning-light-7);
    }
    .el-table .success-row {
        --el-table-tr-bg-color: var(--el-color-success-light-9);
    }
</style>
