<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Календарь записи</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить Запись</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.phone" placeholder="Телефон клиента"/>
                <el-date-picker
                    v-model="filter.day_at"
                    type="date"
                    class="mt-1"
                    placeholder="Выберите дату"
                />
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
                <el-table-column sortable prop="day_at" label="Дата" width="120" />
                <el-table-column sortable prop="time_at" label="Время" width="80" />
                <el-table-column sortable prop="service" label="Услуга" />
                <el-table-column sortable prop="employee" label="Персонал" />
                <el-table-column sortable prop="user" label="Клиент" />
                <el-table-column prop="comment" label="Комментарий"  show-overflow-tooltip/>
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
            :current_page="$page.props.calendars.current_page"
            :per_page="$page.props.calendars.per_page"
            :total="$page.props.calendars.total"
        />
    </el-config-provider>
    <!-- Dialog Delete -->
    <el-dialog v-model="$data.dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить calendar?
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
import { func} from '@/func.js'
export default {
    props: {
        calendars: Object,
        title: {
            type: String,
            default: 'Календарь записи',
        },
        filters: Array,
        services: Array,
        employees: Array,
    },
    data() {
        return {
            tableData: [...this.calendars.data],
            tableHeight: '600',
            Loading: false,
            dialogDelete: false,
            routeDestroy: null,
            /**
             * Данные для формы-фильтр
             */
            filter: {
                phone: this.$props.filters.phone,
                service: this.$props.filters.service,
                employee: this.$props.filters.employee,
                day_at: this.$props.filters.day_at,

            }
        }
    },
    methods: {
        createButton() {
            router.get('/admin/calendar/calendar/create')
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
