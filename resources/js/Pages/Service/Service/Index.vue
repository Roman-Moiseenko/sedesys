<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Услуги</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить Услугу</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.name" placeholder="Название"/>

                <el-select v-model="filter.classification" placeholder="Классификация" class="mt-1">
                    <el-option v-for="item in $props.classifications" :key="item.value" :label="item.label" :value="item.value"/>
                </el-select>
                <el-select v-model="filter.template" placeholder="Шаблон" class="mt-1">
                    <el-option v-for="item in $props.templates" :key="item.value" :label="item.label" :value="item.value"/>
                </el-select>
                <el-checkbox v-model="filter.draft" label="Скрытые" :checked="filter.draft" class="mt-1"/>

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
                <el-table-column label="IMG" width="100" class-name="img-expend">
                    <template #default="scope">
                        <el-image style="min-width: 50px; min-height: 50px" :src="scope.row.image" fit="fill"/>
                    </template>
                </el-table-column>
                <el-table-column label="ICON" width="100">
                    <template #default="scope">
                        <el-image style="min-width: 50px; min-height: 50px" :src="scope.row.icon" fit="fill"/>
                    </template>
                </el-table-column>
                <el-table-column sortable prop="name" label="Услуга" width="250" show-overflow-tooltip/>
                <el-table-column sortable prop="classification" label="Классификация"  width="250"/>
                <el-table-column prop="price" label="Стоимость" width="100" />
                <el-table-column prop="count_employees" label="Выполняют" width="120" />
                <el-table-column prop="template" label="Шаблон" width="120" />
                <el-table-column label="Расх.материалы" width="160" >
                    <template #default="scope">
                        {{ func.price(scope.row.consumable_amount)}}
                    </template>
                </el-table-column>
                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button v-if="scope.row.active"
                                   size="small"
                                   type="warning"
                                   @click.stop="handleToggle(scope.$index, scope.row)">
                            Hide
                        </el-button>
                        <el-button v-if="!scope.row.active"
                                   size="small"
                                   type="success"
                                   @click.stop="handleToggle(scope.$index, scope.row)">
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
                            @click.stop="handleDeleteEntity(scope.row)"
                        >
                            Delete
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <pagination
            :current_page="$page.props.services.current_page"
            :per_page="$page.props.services.per_page"
            :total="$page.props.services.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="услугу" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue"
import { useStore } from "/resources/js/store.js"
import {Head, Link, router} from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import TableFilter from '@/Components/TableFilter.vue'
import { func} from '/resources/js/func.js'

const props = defineProps({
    services: Object,
    title: {
        type: String,
        default: 'Список услуг',
    },
    filters: Array,
    templates: Array,
    classifications: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.services.data])
const filter = reactive({
    name: props.filters.name,
    template: props.filters.template,
    classification: props.filters.classification,
    draft: props.filters.draft,
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
    router.get(route('admin.service.service.edit', {service: row.id}))
}
function handleDeleteEntity(row) {
    $delete_entity.show(route('admin.service.service.destroy', {service: row.id}));
}
function createButton() {
    router.get(route('admin.service.service.create'))
}
function routeClick(row) {
    router.get(route('admin.service.service.show', {service: row.id}))
}
function handleToggle(index, row) {
    router.visit(route('admin.service.service.toggle', {service: row.id}), {
        method: 'post'
    });
}
</script>


