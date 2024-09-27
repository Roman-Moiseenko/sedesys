<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Правила формирования календаря</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить Правило</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.name" placeholder="Название"/>
                <el-select v-model="filter.regularity" class="mt-1" placeholder="Периодичность">
                    <el-option v-for="item in regularities" :value="item.value" :key="item.value" :label="item.label" />
                </el-select>
                <el-select v-model="filter.service" class="mt-1" placeholder="Услуга">
                    <el-option v-for="item in services" :value="item.id" :key="item.id" :label="item.name" />
                </el-select>
                <el-select v-model="filter.employee" class="mt-1" placeholder="Персонал">
                    <el-option v-for="item in employees" :value="item.id" :key="item.id" :label="func.fullName(item.fullname)" />
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
                <el-table-column sortable prop="name" label="Название" width="240" />
                <el-table-column sortable prop="regularity" label="Периодичность" width="160" />
                <el-table-column label="Услуги">
                    <template #default="scope">
                        <el-tag type="" v-for="item in scope.row.services" class="mr-1">{{item.name}}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column label="Персонал">
                    <template #default="scope">
                        <el-tag type="success" v-for="item in scope.row.employees" class="mr-1">{{item.name}}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column prop="max" label="Максимум одновременно" width="160" />
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
            :current_page="$page.props.rules.current_page"
            :per_page="$page.props.rules.per_page"
            :total="$page.props.rules.total"
        />
    </el-config-provider>

    <DeleteEntityModal name_entity="правило" />
</template>

<script lang="ts" setup>
    import { useStore } from "/resources/js/store.js"
    import {Head, Link, router} from '@inertiajs/vue3'
    import Pagination from '@/Components/Pagination.vue'
    import ru from 'element-plus/dist/locale/ru.mjs'
    import TableFilter from '@/Components/TableFilter.vue'
    import {func} from '/resources/js/func.js'
    import {inject, reactive, ref} from "vue";

    const props = defineProps({
        rules: Object,
        title: {
            type: String,
            default: 'Список правил',
        },
        filters: Array,
        regularities: Array,
        employees: Array,
        services: Array,
    })
    const store = useStore();
    const $delete_entity = inject("$delete_entity")
    const Loading = ref(false)
    const tableData = ref([...props.rules.data])
    const filter = reactive({
        name: props.filters.name,
        regularity: props.filters.regularity,
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
        router.get(route('admin.calendar.rule.edit', {rule: row.id}))
    }
    function handleDeleteEntity(row) {
        $delete_entity.show(route('admin.calendar.rule.destroy', {rule: row.id})).then(() => {

        });
    }
    function createButton() {
        router.get(route('admin.calendar.rule.create'))
    }
    function routeClick(row) {
        router.get(route('admin.calendar.rule.show', {rule: row.id}))
    }
    function handleToggle(index, row) {
        router.visit(route('admin.calendar.rule.toggle', {rule: row.id}), {
            method: 'post'
        });
    }
</script>


