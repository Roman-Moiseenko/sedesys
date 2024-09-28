<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Контакты</h1>
        <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить новый контакт</el-button>

        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="600"
                style="width: 100%; cursor: pointer;"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                v-loading="store.getLoading"
            >
                <el-table-column sortable prop="name" label="Название" width="100"/>
                <el-table-column prop="title" label="Описание"/>
                <el-table-column prop="icon" label="Иконка fontawesome"/>
                <el-table-column label="Цвет" width="80">
                    <template #default="scope">
                        <span class="w-4 h-4 p-5"
                              v-bind:style="{ 'background-color': scope.row.color }"
                        ></span>
                    </template>
                </el-table-column>
                <el-table-column prop="link" label="Ссылка"/>

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
            :current_page="$page.props.contacts.current_page"
            :per_page="$page.props.contacts.per_page"
            :total="$page.props.contacts.total"
        />
    </el-config-provider>
    <DeleteEntityModal name_entity="контакт" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref, defineProps} from "vue";
import {useStore} from "/resources/js/store.js"
import {Head, router} from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'

const props = defineProps({
    contacts: Object,
    title: {
        type: String,
        default: 'Список контактов',
    },
})
const store = useStore();
const $delete_entity = inject("$delete_entity")
const Loading = ref(false)
const tableData = ref([...props.contacts.data])

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
    router.get(route('admin.page.contact.edit', {contact: row.id}))
}
function handleDeleteEntity(row) {
    $delete_entity.show(route('admin.page.contact.destroy', {contact: row.id}));
}
function createButton() {
    router.get(route('admin.page.contact.create'))
}
function routeClick(row) {
    router.get(route('admin.page.contact.show', {contact: row.id}))
}
function handleToggle(index, row) {
    router.visit(route('admin.page.contact.toggle', {contact: row.id}), {
        method: 'post'
    });
}
function handleUp(index, row) {
    router.visit(route('admin.page.contact.up', {contact: row.id}), {
        method: 'post'
    });
}
function handleDown(index, row) {
    router.visit(route('admin.page.contact.down', {contact: row.id}), {
        method: 'post'
    });
}
</script>

