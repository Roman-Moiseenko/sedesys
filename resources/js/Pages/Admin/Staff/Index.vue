<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">

        <h1 class="font-medium text-xl">Сотрудники компании</h1>
        <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить сотрудника</el-button>

        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="$data.tableHeight"
                style="width: 100%; cursor: pointer;"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                v-loading="store.getLoading"
            >
                <el-table-column sortable prop="name" label="Логин" width="100" />
                <el-table-column prop="phone" label="Телефон" width="120" />
                <el-table-column sortable prop="fullname" label="ФИО" />
                <el-table-column prop="post" label="Должность" />
                <el-table-column sortable prop="role" label="Роль" />
                <el-table-column label="Действия">
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
            :current_page="$page.props.staffs.current_page"
            :per_page="$page.props.staffs.per_page"
            :total="$page.props.staffs.total"
        />
    </el-config-provider>

    <!-- Dialog Delete -->
    <el-dialog v-model="$data.dialogDelete" title="Удалить запись" width="400" center>

        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить сотрудника?
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

interface Staff {
    role: string
    active: number
}
const tableRowClassName = ({row, rowIndex}: {row: Staff }) => {
    if (row.active === 0) {
        return 'warning-row'
    }
    return ''
};
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
        staffs: Object,
        title: {
            type: String,
            default: 'Список сотрудников',
        }
    },
    emits: ['toggle-loading'],
    data() {
        return {
            tableData: [...this.staffs.data],
            tableHeight: '600',
            Loading: false,
            dialogDelete: false,
            routeDestroy: null,
        }
    },
    mounted() {
    },
    methods: {
        createButton() {
            router.get('/admin/staff/create')
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
            //router.delete(row.destroy);
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
                method:'post'});
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
