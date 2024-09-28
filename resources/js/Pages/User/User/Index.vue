<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Клиенты</h1>
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить Клиента</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.user" placeholder="Имя, Телефон, Email"/>
                <el-input v-model="filter.address" placeholder="Адрес" class="mt-1"/>
                <el-checkbox v-model="filter.draft" label="Не активированные" :checked="filter.draft"/>
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
                <el-table-column label="IMG" width="70">
                    <template #default="scope">
                        <el-image style="width: 40px; height: 40px" :src="scope.row.avatar" fit="fill" />
                    </template>
                </el-table-column>
                <el-table-column sortable prop="phone" label="Телефон" width="140"/>
                <el-table-column sortable prop="fullname" label="ФИО">
                    <template #default="scope">
                        {{ func.fullName(scope.row.fullname)}}
                    </template>
                </el-table-column>
                <el-table-column sortable prop="email" label="Email"/>
                <el-table-column sortable prop="address" label="Адрес"/>
                <el-table-column label="OAuth" width="100">
                    <template #default="scope">
                        <span v-for="item in scope.row.oauths">{{ item }} </span>
                    </template>
                </el-table-column>

                <el-table-column label="Действия" align="right">
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
            :current_page="$page.props.users.current_page"
            :per_page="$page.props.users.per_page"
            :total="$page.props.users.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="клиента" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue";
import {useStore} from "/resources/js/store.js"
import TableFilter from '@/Components/TableFilter.vue'
import { func } from '/resources/js/func.js'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import {Head, router} from '@inertiajs/vue3'

const props = defineProps({
    users: Object,
    title: {
        type: String,
        default: 'Список клиентов',
    },
    filters: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.users.data])
const filter = reactive({
    user: props.filters.user,
    address: props.filters.address,
    draft: props.filters.draft,
})

interface IRow {
    active: boolean
}
const tableRowClassName = ({row, rowIndex}: { row: IRow }) => {
    if (row.active === false) {
        return 'warning-row'
    }
    return ''
}
function handleEdit(row) {
    router.get(route('admin.user.user.edit', {user: row.id}))
}
function handleDeleteEntity(row) {
    $delete_entity.show(route('admin.user.user.destroy', {user: row.id}));
}
function createButton() {
    router.get(route('admin.user.user.create'))
}
function routeClick(row) {
    router.get(route('admin.user.user.show', {user: row.id}))
}
function handleActivated(index, row) {
    router.visit(route('admin.user.user.verify', {user: row.id}), {
        method: 'post'
    });
}
</script>

