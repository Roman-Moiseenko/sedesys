<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">User</h1>
        <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить User</el-button>

        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :height="tableHeight"
                style="width: 100%; cursor: pointer;"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                v-loading="store.getLoading"
            >
                <el-table-column sortable prop="phone" label="Телефон" width="140" />
                <el-table-column sortable prop="fullname" label="ФИО" />
                <el-table-column sortable prop="email" label="Email" />
                <el-table-column sortable prop="address" label="Адрес" />

                <!-- Повторить -->
                <el-table-column label="Действия">
                    <template #default="scope">
                        <el-button
                            v-if="!scope.row.active"
                            size="small"
                            type="success"
                            @click.stop="handleActivated(scope.$index, scope.row)">
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
            :current_page="$page.props.users.current_page"
            :per_page="$page.props.users.per_page"
            :total="$page.props.users.total"
        />
    </el-config-provider>
    <!-- Dialog Delete -->
    <el-dialog v-model="$data.dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить Клиента?
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
    const store = useStore();

    interface IRow {
        /**
         * Статусы
        */
        active: boolean
    }
    const tableRowClassName = ({row, rowIndex}: {row: IRow }) => {
        if (row.active === false) {
            return 'warning-row'
        }
        return ''
    }
</script>

<script lang="ts">
    import { Head, Link } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'
    import { router } from '@inertiajs/vue3'
    import Pagination from '@/Components/Pagination.vue'
    import ru from 'element-plus/dist/locale/ru.mjs'

export default {
    components: {
        Head,
        Pagination
    },
    layout: Layout,
    props: {
        users: Object,
        title: {
            type: String,
            default: 'Список клиентов',
        }
    },
    data() {
        return {
            tableData: [...this.users.data],
            TableHeight: '500',
            Loading: false,
            dialogDelete: false,
            routeDestroy: null,
        }
    },
    methods: {
        createButton() {
            router.get('/admin/user/user/create')
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
        handleActivated(index, row) {
            router.visit(row.verify, {
                method: 'post'
            });
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
