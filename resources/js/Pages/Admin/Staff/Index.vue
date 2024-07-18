<template>
    <div>
        <Head title="Dashboard" />
        <h2 class="font-medium text-xl">Сотрудники</h2>
    </div>

    <div class="mt-2 p-5 bg-white rounded-md">
        <el-table
            :data="tableData"
            style="width: 100%; cursor: pointer;"
            :row-class-name="tableRowClassName"
            @row-click="routeClick"
        >
            <el-table-column sortable prop="name" label="Логин" width="100" />
            <el-table-column prop="phone" label="Телефон" width="120" />
            <el-table-column sortable prop="fullname" label="ФИО" />
            <el-table-column prop="post" label="Должность" />
            <el-table-column sortable prop="role" label="Роль" />
            <el-table-column label="Действия">
                <template #default="scope">
                    <el-button size="small" @click.stop="handleEdit(scope.$index, scope.row)">
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

export default {
    components: {
        Head,
    },
    layout: Layout,
    props: {
        staffs: Object
    },
    data() {
        return {
            tableData: [...this.staffs.data]
        }
    },
    methods: {
        routeClick(row) {
            router.get(row.url)
        },
        handleEdit(index, row) {
            router.get(row.edit);
        },
        handleDelete(index, row) {
            router.delete(row.destroy);
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
