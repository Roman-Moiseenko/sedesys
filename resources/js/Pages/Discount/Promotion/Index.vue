<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Акции</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить Акцию</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.name" placeholder="Name"/>
                <el-select v-model="filter.status" placeholder="Статус" class="mt-1">
                    <el-option v-for="item in statuses" :key="item.value" :label="item.label" :value="item.value"/>
                </el-select>
                <el-select v-model="filter.service" placeholder="Услуга" class="mt-1">
                    <el-option v-for="item in services" :key="item.value" :label="item.label" :value="item.value"/>
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
                <el-table-column sortable prop="name" label="Название" width="160" show-overflow-tooltip/>
                <el-table-column prop="discount" label="Скидка %" width="160" show-overflow-tooltip/>
                <el-table-column label="Расписание" width="300" show-overflow-tooltip>
                    <template #default="scope">
                        <span v-if="scope.row.start_at">
                            С {{ scope.row.start_at }} по {{ scope.row.finish_at }}
                        </span>
                        <span v-else>
                            Вручную
                        </span>
                    </template>
                </el-table-column>
                <el-table-column prop="status" label="Статус" width="120"/>
                <el-table-column prop="items" label="Кол-во" width="80" />
                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <span v-if="scope.row.current">
                            <el-button size="small" type="danger" @click.stop="handleFinish(scope.$index, scope.row)">
                                Stop
                            </el-button>
                        </span>
                        <span v-else>
                            <span v-if="scope.row.active">
                                <el-button size="small" type="warning" @click.stop="handleToggle(scope.row)">
                                    Hide
                                </el-button>
                                <el-button size="small" type="primary" @click.stop="handleStart(scope.$index, scope.row)">
                                    Start
                                </el-button>
                            </span>
                            <span v-if="!scope.row.active">
                                <el-button size="small" type="success" @click.stop="handleToggle(scope.row)">
                                    Show
                                </el-button>
                            </span>
                            <el-button size="small"
                                       @click.stop="router.get(scope.row.edit)" class="ml-3">
                                Edit
                            </el-button>
                            <el-button size="small" type="danger"
                                       @click.stop="handleDeleteEntity(scope.row)">
                                Delete
                            </el-button>
                        </span>

                    </template>
                </el-table-column>
            </el-table>
        </div>

        <pagination
            :current_page="$page.props.promotions.current_page"
            :per_page="$page.props.promotions.per_page"
            :total="$page.props.promotions.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="акцию" />
</template>

<script lang="ts" setup>
import {useStore} from "/resources/js/store.js"
import {Head, router} from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import TableFilter from '@/Components/TableFilter.vue'
import { func } from '@/func.js'
import {inject, reactive, ref} from "vue";

const props = defineProps({
    promotions: Object,
    title: {
        type: String,
        default: 'Список акций',
    },
    filters: Array,
    statuses: Array,
    services: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.promotions.data])
const filter = reactive({
    name: props.filters.name,
    status: props.filters.status,
    service: props.filters.service,
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
    router.get('/admin/discount/promotion/create')
}
function routeClick(row) {
    router.get(row.url)
}
function handleStart(index, row) {
    router.visit(row.start, {
        method: 'post'
    });
}
function handleFinish(index, row) {
    router.visit(row.finish, {
        method: 'post'
    });
}
function handleToggle(row) {
    router.visit(row.toggle, {
        method: 'post'
    });
}


</script>




