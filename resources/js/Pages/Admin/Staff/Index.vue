<template>
    <el-config-provider :locale="ru">
    <div>
        <Head title="Dashboard" />
        <h2 class="font-medium text-xl">Сотрудники</h2>
    </div>

    <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить сотрудника</el-button>

    <div class="mt-2 p-5 bg-white rounded-md">
        <el-table
            :data="tableData"
            :height="$data.tableHeight"
            style="width: 100%; cursor: pointer;"
            :row-class-name="tableRowClassName"
            @row-click="routeClick"
            v-loading="$data.Loading"
            v-on:toggle-loading="tLoading"
        >
            <el-table-column sortable prop="name" label="Логин" width="100" />
            <el-table-column prop="phone" label="Телефон" width="120" />
            <el-table-column sortable prop="fullname" label="ФИО" />
            <el-table-column prop="post" label="Должность" />
            <el-table-column sortable prop="role" label="Роль" />
            <el-table-column label="Действия">
                <template #default="scope">
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

</template>

<script lang="ts" setup>

interface Staff {
    role: string
    active: number
}
const tableRowClassName = ({row, rowIndex}: {row: Staff }) => {
    if (row.active === 0) {
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
        staffs: Object
    },
    emits: ['toggle-loading'],
    data() {
        return {
            tableData: [...this.staffs.data],
            TableHeight: '500',
            Loading: false,
        }
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
            router.delete(row.destroy);
        },
        tLoading(val) {
            console.log('toggle-', val);
        }
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
