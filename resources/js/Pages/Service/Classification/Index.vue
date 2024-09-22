<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Классификация услуг</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить новую</el-button>
        </div>
        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="600"
                row-key="id"
                style="width: 100%; cursor: pointer; margin-bottom: 20px;"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                default-expand-all
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
                <el-table-column sortable prop="name" label="Название" width="200" />
                <el-table-column prop="slug" label="Ссылка" width="160"/>
                <el-table-column prop="services" label="Услуги" width="120"/>
                <el-table-column prop="description" label="Описание">
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

    </el-config-provider>
    <DeleteEntityModal name_entity="классификацию" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue";
import { useStore } from "/resources/js/store.js"
import {Head, Link, router} from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import TableFilter from '@/Components/TableFilter.vue'

const props = defineProps({
    classifications: Object,
    title: {
        type: String,
        default: 'Список всех классификаций',
    },
    filters: Array,
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.classifications.data])

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
    router.get('/admin/service/classification/create')
}
function routeClick(row) {
    router.get(row.url)
}
function handleUp(index, row) {
    router.visit(row.up, {
        method: 'post'
    });
}
function handleDown(index, row) {
    router.visit(row.down, {
        method: 'post'
    });
}
function handleToggle(index, row) {
    router.visit(row.toggle, {
        method: 'post'
    });
}

</script>

