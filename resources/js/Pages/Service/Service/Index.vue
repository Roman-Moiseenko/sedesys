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
                :max-height="$data.tableHeight"
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
                <el-table-column label="Расх.материалы (₽)" width="160" />
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
                            @click.stop="handleEdit(scope.$index, scope.row)">
                            Edit
                        </el-button>
                        <el-button
                            size="small"
                            type="danger"
                            @click.stop="handleDelete(scope.$index, scope.row)"
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
    <!-- Dialog Delete -->
    <el-dialog v-model="$data.dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить service?
        </div>
        <div class="text-red-600 text-md mt-2">
            Восстановить данные будет невозможно!
        </div>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="$data.dialogDelete = false">Отмена</el-button>
                <el-button type="danger" @click="removeItem($data.routeDestroy)">
                    Удалить
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
    import { useStore } from "/resources/js/store.js"
    import { Head, Link } from '@inertiajs/vue3'
    import Pagination from '@/Components/Pagination.vue'
    import ru from 'element-plus/dist/locale/ru.mjs'
    import TableFilter from '@/Components/TableFilter.vue'

    const store = useStore();

    interface IRow {
        active: number
    }
    const tableRowClassName = ({row, rowIndex}: {row: IRow }) => {
        if (row.active === false) {
            return 'warning-row'
        }
        return ''
    }
</script>

<script lang="ts">
import Layout from '@/Components/Layout.vue'
import { router } from '@inertiajs/vue3'

export default {

    layout: Layout,
    props: {
        services: Object,
        title: {
            type: String,
            default: 'Список услуг',
        },
        filters: Array,
        templates: Array,
        classifications: Array,
    },
    data() {
        return {
            tableData: [...this.services.data],
            tableHeight: '600',
            Loading: false,
            dialogDelete: false,
            routeDestroy: null,

            filter: {
                name: this.$props.filters.name,
                template: this.$props.filters.template,
                classification: this.$props.filters.classification,
                draft: this.$props.filters.draft,
                //
            }
        }
    },
    methods: {
        createButton() {
            router.get('/admin/service/service/create')
        },
        routeClick(row) {
            router.get(row.url)
        },
        handleEdit(index, row) {
            router.get(row.edit);
        },

        handleDelete(index, row) {
            this.$data.dialogDelete = true;
            this.$data.routeDestroy = row.destroy;
        },
        removeItem(_route) {
            if (_route !== null) {
                router.visit(_route, {
                    method: 'delete'
                });
                this.$data.dialogDelete = false;
                this.$data.routeDestroy = null;
            }
        },
        handleToggle(index, row) {
            router.visit(row.toggle, {
                method: 'post'
            });
        },
    }
}
</script>

<style >
    .el-table tr.warning-row {
        --el-table-tr-bg-color: var(--el-color-warning-light-7);
    }
    .el-table .success-row {
        --el-table-tr-bg-color: var(--el-color-success-light-9);
    }
</style>
