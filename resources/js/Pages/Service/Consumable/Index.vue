<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Расходный материал</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить расходный материал</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.name" placeholder="Name"/>
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
                <el-table-column sortable prop="name" label="Расходник" width="200" />
                <el-table-column prop="price" label="Цена" width="100">
                    <template  #default="scope">
                        {{ func.price(scope.row.price) }}
                    </template>
                </el-table-column>
                <el-table-column prop="count" label="Кол-во" width="100" />
                <el-table-column label="Доступен для услуг" width="160" >
                    <template  #default="scope">
                        <Active :active="scope.row.active"/>
                    </template>
                </el-table-column>
                <el-table-column label="Показывать" width="160" >
                    <template  #default="scope">
                        <Active :active="scope.row.show"/>
                    </template>
                </el-table-column>
                <el-table-column prop="count_services" label="В услугах" width="160" />
                <el-table-column prop="description" label="Описание" show-overflow-tooltip />

                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button v-if="scope.row.active"
                                   size="small"
                                   type="warning"
                                   @click.stop="handleToggle(scope.$index, scope.row)">
                            Draft
                        </el-button>
                        <el-button v-if="!scope.row.active"
                                   size="small"
                                   type="success"
                                   @click.stop="handleToggle(scope.$index, scope.row)">
                            Active
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
            :current_page="$page.props.consumables.current_page"
            :per_page="$page.props.consumables.per_page"
            :total="$page.props.consumables.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="Расходный материал" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue"
import { useStore } from "/resources/js/store.js"
import {Head, Link, router} from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import TableFilter from '@/Components/TableFilter.vue'
import Active from '/resources/js/Components/Elements/Active.vue'
import {func} from "/resources/js/func.js"

const props = defineProps({
    consumables: Object,
    title: {
        type: String,
        default: 'Список расходных материалов',
    },
    filters: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.consumables.data])
const filter = reactive({
    name: props.filters.name,
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
    router.get(route('admin.service.consumable.edit', {consumable: row.id}))
}
function handleDeleteEntity(row) {
    $delete_entity.show(route('admin.service.consumable.destroy', {consumable: row.id}));
}
function createButton() {
    router.get(route('admin.service.consumable.create'))
}
function routeClick(row) {
    router.get(route('admin.service.consumable.show', {consumable: row.id}))
}
function handleToggle(index, row) {
    router.visit(route('admin.service.consumable.toggle', {consumable: row.id}), {
        method: 'post'
    });
}
</script>


