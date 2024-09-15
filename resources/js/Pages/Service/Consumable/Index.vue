<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Расходный материал</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить расходный материал</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.name" placeholder="Name"/>
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
                <el-table-column sortable prop="name" label="Расходник" width="200" />
                <el-table-column prop="price" label="Цена" width="100">
                    <template  #default="scope">
                        {{ func.price(scope.row.price) }}
                    </template>
                </el-table-column>
                <el-table-column prop="count" label="Кол-во" width="100" />
                <el-table-column label="Доступен для услуг" width="160" >
                    <template  #default="scope">
                        <Active :active="scope.row.active"/>
                    </template>
                </el-table-column>
                <el-table-column label="Показывать" width="160" >
                    <template  #default="scope">
                        <Active :active="scope.row.show"/>
                    </template>
                </el-table-column>
                <el-table-column prop="count_services" label="В услугах" width="160" />
                <el-table-column prop="description" label="Описание" show-overflow-tooltip />

                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button v-if="scope.row.active"
                                   size="small"
                                   type="warning"
                                   @click.stop="handleToggle(scope.$index, scope.row)">
                            Draft
                        </el-button>
                        <el-button v-if="!scope.row.active"
                                   size="small"
                                   type="success"
                                   @click.stop="handleToggle(scope.$index, scope.row)">
                            Active
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
            :current_page="$page.props.consumables.current_page"
            :per_page="$page.props.consumables.per_page"
            :total="$page.props.consumables.total"
        />
    </el-config-provider>
    <!-- Dialog Delete -->
    <el-dialog v-model="$data.dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить Расходный материал?
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
    import Active from '/resources/js/Components/Elements/Active.vue'
    import {func} from "/resources/js/func.js"

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
import { router } from '@inertiajs/vue3'

export default {
    props: {
        consumables: Object,
        title: {
            type: String,
            default: 'Список расходных материалов',
        },
        filters: Array,
    },
    data() {
        return {
            tableData: [...this.consumables.data],
            tableHeight: '600',
            Loading: false,
            dialogDelete: false,
            routeDestroy: null,
            /**
             * Данные для формы-фильтр
             */
            filter: {
                name: this.$props.filters.name,
                //
            }
        }
    },
    methods: {
        createButton() {
            router.get('/admin/service/consumable/create')
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
