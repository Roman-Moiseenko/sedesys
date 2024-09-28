<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Примеры работ</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить пример</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.title" placeholder="Заголовок"/>
                <el-select v-model="filter.service" class="mt-1" placeholder="Услуга">
                    <el-option v-for="item in services" :value="item.value" :key="item.value" :label="item.label" />
                </el-select>
                <el-select v-model="filter.employee" class="mt-1" placeholder="Персонал">
                    <el-option v-for="item in employees" :value="item.value" :key="item.value" :label="item.label" />
                </el-select>
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
                <!-- Повторить поля -->
                <el-table-column sortable prop="date" label="Дата исполнения" width="180" />
                <el-table-column prop="title" label="Заголовок" width="200" />
                <el-table-column sortable prop="service" label="Услуга" width="160" />
                <el-table-column prop="cost" label="Стоимость" width="120" />
                <el-table-column label="Исполнители">
                    <template #default="scope">
                        <el-tag type="success" v-for="item in scope.row.employees" class="mr-1">
                            {{ func.fullName(item.fullname) }}
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column prop="gallery_count" label="Изображения" />
                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button v-if="scope.row.active"
                                   size="small"
                                   type="warning"
                                   @click.stop="handleToggle(scope.row)">
                            Hide
                        </el-button>
                        <el-button v-if="!scope.row.active"
                                   size="small"
                                   type="success"
                                   @click.stop="handleToggle(scope.row)">
                            Show
                        </el-button>
                        <el-button
                            size="small"
                            @click.stop="handleEdit(scope.row)">
                            Edit
                        </el-button>
                        <el-button
                            size="small"
                            type="danger"
                            @click.stop="handleDeleteEntity(scope.row)">
                            Delete
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <pagination
            :current_page="$page.props.examples.current_page"
            :per_page="$page.props.examples.per_page"
            :total="$page.props.examples.total"
        />
    </el-config-provider>

    <DeleteEntityModal name_entity="пример" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue";
import ru from 'element-plus/dist/locale/ru.mjs'
import {func} from '@/func.js'
import { useStore } from "/resources/js/store.js"
import { Head, router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import TableFilter from '@/Components/TableFilter.vue'

const props = defineProps({
        examples: Object,
        title: {
            type: String,
            default: 'Список всех работ',
        },
        filters: Array,
        services: Array,
        employees: Array,
    })
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.examples.data])
const filter = reactive({
    title: props.filters.title,
    service: props.filters.service,
    employee: props.filters.employee,
})

interface IRow {
    active: number
}
const tableRowClassName = ({row, rowIndex}: {row: IRow }) => {
    if (row.active === false) {
        return 'warning-row'
    }
    return ''
}
function handleEdit(row) {
    router.get(route('admin.service.example.edit', {example: row.id}))
}
function handleDeleteEntity(row) {
    $delete_entity.show(route('admin.service.example.destroy', {example: row.id}));
}
function createButton() {
    router.get(route('admin.service.example.create'))
}
function routeClick(row) {
    router.get(route('admin.service.example.show', {example: row.id}))
}
function handleToggle(row) {
    router.visit(route('admin.service.example.toggle', {example: row.id}), {
        method: 'post'
    });
}
</script>



