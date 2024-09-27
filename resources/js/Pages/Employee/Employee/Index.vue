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
                :max-height="600"
                style="width: 100%; cursor: pointer;"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                v-loading="store.getLoading"
            >
                <el-table-column label="Photo" width="100">
                    <template #default="scope">
                        <el-image style="min-width: 50px; min-height: 50px" :src="scope.row.photo" fit="fill"/>
                    </template>
                </el-table-column>
                <el-table-column prop="phone" label="Телефон" width="120"/>
                <el-table-column sortable prop="fullname" label="ФИО"/>
                <el-table-column sortable prop="address" label="Адрес"/>
                <el-table-column sortable prop="address" label="Стаж">
                    <template #default="scope">
                        {{ func.experience(scope.row.experience_year)}}
                    </template>
                </el-table-column>
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
                            @click.stop="handleEdit(scope.row)">
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
            :current_page="$page.props.employees.current_page"
            :per_page="$page.props.employees.per_page"
            :total="$page.props.employees.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="персонал" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue";
import {Head, router} from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import {useStore} from "/resources/js/store.js"
import TableFilter from '@/Components/TableFilter.vue'
import { func } from '@/func.js'
import ru from 'element-plus/dist/locale/ru.mjs'

const props = defineProps({
    employees: Object,
    title: {
        type: String,
        default: 'Список персонала',
    },
    filters: Array,
    specializations: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.employees.data])
const filter = reactive({
    user: props.filters.user,
    draft: props.filters.draft,
    specialization: props.filters.specialization
})

interface IRow {
    active: number
}
const tableRowClassName = ({row, rowIndex}: { row: IRow }) => {
    if (row.active === 0) {
        return 'warning-row'
    }
    return ''
}
function handleEdit(row) {
    router.get(route('admin.employee.employee.edit', {employee: row.id}))
}
function handleDeleteEntity(row) {
    $delete_entity.show(route('admin.employee.employee.destroy', {employee: row.id}));
}
function createButton() {
    router.get(route('admin.employee.employee.create'))
}
function routeClick(row) {
    router.get(route('admin.employee.employee.show', {employee: row.id}))
}
function handleToggle(index, row) {
    router.visit(route('admin.employee.employee.toggle', {employee: row.id}), {
        method: 'post'
    });
}
</script>


