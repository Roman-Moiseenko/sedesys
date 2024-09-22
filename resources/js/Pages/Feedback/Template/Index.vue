<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Шаблоны обратной связи</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить шаблон</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.name" placeholder="Название"/>
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
                <el-table-column sortable prop="name" label="Шаблон" />
                <el-table-column label="Подключение" >
                    <template #default="scope">
                        {{ '<div class="feedback" data-id="'+ scope.row.id +'"></div>' }}

                    </template>
                </el-table-column>
                <el-table-column label="Цвет" width="80">
                    <template #default="scope">
                        <span class="w-4 h-4 p-5"
                              v-bind:style="{ 'background-color': scope.row.color }"
                        ></span>
                    </template>
                </el-table-column>
                <el-table-column prop="active" label="Принимать заявки" >
                    <template #default="scope">
                        <Active :active="scope.row.active" />
                    </template>
                </el-table-column>
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
            :current_page="$page.props.templates.current_page"
            :per_page="$page.props.templates.per_page"
            :total="$page.props.templates.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="шаблон" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue";
import { useStore } from "/resources/js/store.js"
import { Head, Link, router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import TableFilter from '@/Components/TableFilter.vue'
import {func} from "/resources/js/func.js"
import Active from "/resources/js/Components/Elements/Active.vue"

const props = defineProps({
    templates: Object,
    title: {
        type: String,
        default: 'Список Форм заявок',
    },
    filters: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.templates.data])
const filter = reactive({
    name: props.filters.name,
    active: props.filters.active,
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
function handleDeleteEntity(row) {
    $delete_entity.show(row.destroy);
}
function createButton() {
    router.get('/admin/feedback/template/create')
}
function routeClick(row) {
    router.get(row.url)
}
function handleToggle(index, row) {
    router.visit(row.toggle, {
        method: 'post'
    });
}
</script>

