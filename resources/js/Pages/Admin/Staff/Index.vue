<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">

        <h1 class="font-medium text-xl">Сотрудники компании</h1>
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить сотрудника</el-button>

            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.user" placeholder="Имя, Телефон, Email"/>
                <el-select v-model="filter.role" placeholder="Роль" class="mt-1">
                    <el-option v-for="item in roles" :key="item.value" :label="item.label" :value="item.value"/>
                </el-select>
                <el-checkbox v-model="filter.draft" label="Заблокированные" :checked="filter.draft"/>

            </TableFilter>
        </div>
        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="600"
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
                            @click.stop="router.get(scope.row.edit)">
                            Edit
                        </el-button>
                        <el-button
                            size="small"
                            type="danger"
                            @click.stop="handleDeleteEntity(scope.row)"
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

    <DeleteEntityModal name_entity="сотрудника" />
</template>

<script lang="ts" setup>
import { Head, router } from '@inertiajs/vue3'
import { useStore } from "/resources/js/store.js"
import TableFilter from '@/Components/TableFilter.vue'
import {inject, reactive, ref} from "vue";
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'

const props = defineProps({
    staffs: Object,
    title: {
        type: String,
        default: 'Список сотрудников',
    },
    filters: Array,
    roles: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.staffs.data])
const filter = reactive({
    user: props.filters.user,
    role: props.filters.role,
    draft: props.filters.draft,
})

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

function handleDeleteEntity(row) {
    $delete_entity.show(row.destroy)
}
function createButton() {
    router.get('/admin/staff/create')
}
function routeClick(row) {
    router.get(row.url)
}
function handleToggle(index, row) {
    router.visit(row.toggle, {
        method:'post'});
}
</script>


