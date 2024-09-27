<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Специальности персонала</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить специализацию</el-button>
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
                <el-table-column type="expand">
                    <template #default="props">
                        <h3 class="font-medium text-lg">Специалисты:</h3>
                        <el-table :data="props.row.employees" @row-click="routeClickEmployee">
                            <el-table-column  label="" width="100"/>
                            <el-table-column prop="fullname" label="ФИО"  width="250"/>
                            <el-table-column prop="phone" label="Телефон" width="160" />
                            <el-table-column label="Действия">
                                <template #default="scope">
                                    <el-button
                                        size="small"
                                        type="warning"
                                        @click.stop="handleDetach(props.row, scope.row)">
                                        Detach
                                    </el-button>
                                </template>
                            </el-table-column>

                        </el-table>
                    </template>
                </el-table-column>

                <el-table-column label="IMG" width="100">
                    <template #default="scope">
                        <el-image style="min-width: 50px; min-height: 50px" :src="scope.row.image" fit="fill"/>
                    </template>
                </el-table-column>
                <el-table-column label="ICON" width="100">
                    <template #default="scope">
                        <el-image style="min-width: 50px; min-height: 50px" :src="scope.row.icon" fit="fill"/>
                    </template>
                </el-table-column>
                <el-table-column sortable prop="name" label="Название" width="160"/>
                <el-table-column prop="slug" label="Ссылка" width="160"/>
                <el-table-column prop="count_employees" label="Специалистов" width="120"/>
                <el-table-column label="Описание" show-overflow-tooltip width="250">
                    <template #default="scope">
                        <div class=""><span class="font-medium">H1: </span><span>{{ scope.row.meta.h1 }}</span></div>
                        <div class=""><span class="font-medium">Meta-Title: </span><span>{{ scope.row.meta.title }}</span></div>
                        <div class=""><span class="font-medium">Met-Description: </span><span>{{ scope.row.meta.description }}</span></div>
                    </template>
                </el-table-column>

                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button
                            size="small"
                            type="primary"
                            @click.stop="handleUp(scope.$index, scope.row)">
                            <el-icon>
                                <Top/>
                            </el-icon>
                        </el-button>
                        <el-button
                            size="small"
                            type="primary"
                            @click.stop="handleDown(scope.$index, scope.row)">
                            <el-icon>
                                <Bottom/>
                            </el-icon>
                        </el-button>
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
            :current_page="$page.props.specializations.current_page"
            :per_page="$page.props.specializations.per_page"
            :total="$page.props.specializations.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="специализацию" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue";
import {func} from '@/func.js'
import {useStore} from "/resources/js/store.js"
import {Head, router} from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import TableFilter from '@/Components/TableFilter.vue'
import {defaultsDeep} from "lodash";

const props = defineProps({
    specializations: Object,
    title: {
        type: String,
        default: 'Список специальностей',
    },
    filters: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.specializations.data])
const filter = reactive({
    name: props.filters.name,
})

interface IRow {
    active: number
}
const tableRowClassName = ({row, rowIndex}: { row: IRow }) => {
    if (row.active === false) {
        return 'warning-row'
    }
    return ''
}
function handleEdit(row) {
    router.get(route('admin.employee.specialization.edit', {specialization: row.id}))
}
function handleDeleteEntity(row) {
    $delete_entity.show(route('admin.employee.specialization.destroy', {specialization: row.id}));
}
function createButton() {
    router.get(route('admin.employee.specialization.create'))
}
function routeClick(row) {
    router.get(route('admin.employee.specialization.show', {specialization: row.id}))
}
function  handleToggle(index, row) {
    router.visit(route('admin.employee.specialization.toggle', {specialization: row.id}), {
        method: 'post'
    });
}
function handleUp(index, row) {
    router.visit(route('admin.employee.specialization.up', {specialization: row.id}), {
        method: 'post'
    });
}
function handleDown(index, row) {
    router.visit(route('admin.employee.specialization.down', {specialization: row.id}), {
        method: 'post'
    });
}
function handleDetach(main_row, row) {
    router.visit(route('admin.employee.specialization.detach', {specialization: main_row.id}), {
        method: "post",
        data: {employee_id: row.id}
    });

}
function routeClickEmployee(row) {
    router.get(route('admin.employee.employee.show', {employee: row.id}))
}
</script>



