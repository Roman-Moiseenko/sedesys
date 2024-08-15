<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Уведомления Системы</h1>
        <div class="flex">
            <el-button v-if="chief" type="primary" class="p-4 my-3" @click="createButton">Создать уведомление</el-button>

            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">

                <el-select v-model="filter.event" placeholder="Событие">
                    <el-option v-for="item in events" :key="item.value" :label="item.label" :value="item.value"/>
                </el-select>
                <el-checkbox v-model="filter.read" label="Не прочитанные" :checked="filter.read"/>
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
                <el-table-column sortable prop="event" label="Событие" width="200" />
                <el-table-column prop="message" label="Сообщение" />
                <el-table-column sortable prop="created_at" label="Создано" width="200" />
                <el-table-column sortable prop="read_at" label="Прочитано" width="200" />
                <!-- Повторить -->
                <el-table-column label="Действия">
                    <template #default="scope">
                        <el-button v-if="scope.read_at === null"
                            size="small"
                            @click.stop="handleRead(scope.$index, scope.row)">
                            Read
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <pagination
            :current_page="$page.props.notifications.current_page"
            :per_page="$page.props.notifications.per_page"
            :total="$page.props.notifications.total"
        />
    </el-config-provider>
    <!-- Dialog Delete -->
    <el-dialog v-model="$data.dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить notification?
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
        /**
         * Статусы
        */
        active: number,
        read_at: String,
    }
    const tableRowClassName = ({row, rowIndex}: {row: IRow }) => {
        if (row.read_at === null) {
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
        notifications: Object,
        chief: {
            type: Boolean,
            default: false,
        },
        title: {
            type: String,
            default: 'Уведомления',
        },
        filters: Array,
        events: Array,
    },
    data() {
        return {
            tableData: [...this.notifications.data],
            tableHeight: '600',
            Loading: false,
            dialogDelete: false,
            routeDestroy: null,
            /**
             * Данные для формы-фильтр
             */
            filter: {
                event: this.$props.filters.event,
                read: this.$props.filters.read,
            },
        }
    },
    methods: {
        createButton() {
            router.get('/admin/notification/notification/create')
        },
        routeClick(row) {
            router.get(row.route)
        },
        handleRead(index, row) {
            router.visit(row.read, {
                method: 'post',
            });
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
