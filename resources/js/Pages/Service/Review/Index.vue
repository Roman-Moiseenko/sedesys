<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Отзывы</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить отзыв</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-rate v-model="filter.rating" placeholder="Рейтинг"/>
                <el-select v-model="filter.service_id" placeholder="Услуга" class="mt-1">
                    <el-option v-for="item in services" :value="item.value" :key="item.value" :label="item.label"/>
                </el-select>
                <el-select v-model="filter.employee_id" placeholder="Персонал" class="mt-1">
                    <el-option v-for="item in employees" :value="item.value" :key="item.value" :label="item.label"/>
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
                <el-table-column prop="created_at" label="Дата" width="120"/>
                <el-table-column prop="from" label="Клиент" width="160"/>
                <el-table-column prop="rating" label="Рейтинг" width="80"/>

                <el-table-column prop="service" label="Услуга"/>
                <el-table-column prop="employee" label="Персонал"/>

                <el-table-column prop="text" label="Отзыв" width="260" show-overflow-tooltip/>
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
                            v-if="scope.row.is_edit"
                            size="small"
                            @click.stop="router.get(scope.row.edit)">
                            Edit
                        </el-button>
                        <el-button
                            v-if="scope.row.is_edit"
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
            :current_page="$page.props.reviews.current_page"
            :per_page="$page.props.reviews.per_page"
            :total="$page.props.reviews.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="отзыв" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue"
import {useStore} from "/resources/js/store.js"
import {Head, Link, router} from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import TableFilter from '@/Components/TableFilter.vue'

const props = defineProps({
    reviews: Object,
    title: {
        type: String,
        default: 'Список отзывов на услуги',
    },
    filters: Array,
    services: Array,
    employees: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.reviews.data])
const filter = reactive({
    rating: props.filters.rating,
    service_id: props.filters.service_id,
    employee_id: props.filters.employee_id,
})

interface IRow {
    /**
     * Статусы
     */
    active: number
}
const tableRowClassName = ({row, rowIndex}: { row: IRow }) => {
    if (row.active === false) {
        return 'warning-row'
    }
    return ''
}

function handleDeleteEntity(row) {
    $delete_entity.show(row.destroy);
}
function createButton() {
    router.get('/admin/service/review/create')
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

