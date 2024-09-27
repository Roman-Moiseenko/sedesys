<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Календарь записи</h1>
        <!-- Фильтр -->
        <div class="flex">
            <el-button type="primary" class="p-4 my-3" @click="createButton">Добавить Запись</el-button>
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-input v-model="filter.phone" placeholder="Телефон клиента"/>
                <el-date-picker
                    v-model="filter.day_at"
                    type="date"
                    class="mt-1"
                    placeholder="Выберите дату"
                />
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
                style="width: 100%;"
                :row-class-name="tableRowClassName"
                v-loading="store.getLoading"
            >
                <!-- Повторить поля -->
                <el-table-column sortable prop="day_at" label="Дата" width="120" />
                <el-table-column sortable prop="time_at" label="Время" width="80" />
                <el-table-column sortable prop="service" label="Услуга" />
                <el-table-column sortable prop="employee" label="Персонал" />
                <el-table-column sortable prop="user" label="Клиент" />
                <el-table-column sortable prop="status_text" label="Статус" />
                <el-table-column prop="comment" label="Комментарий"  show-overflow-tooltip/>
                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button
                            v-if="scope.row.today === 0 || scope.row.order_id"
                            size="small"
                            type="warning"
                            :plain="scope.row.order_id"
                            @click.stop="handleOrder(scope.row)"
                            >
                            Order
                        </el-button>
                        <el-button
                            v-if="scope.row.today === -1 && (scope.row.status.new || scope.row.status.confirm)"
                            size="small"
                            type="info" dark
                            @click.stop="handleCancel(scope.row)"
                        >
                            Cancel
                        </el-button>
                        <el-button
                            v-if="scope.row.status.new && scope.row.today > -1"
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
            :current_page="$page.props.calendars.current_page"
            :per_page="$page.props.calendars.per_page"
            :total="$page.props.calendars.total"
        />
    </el-config-provider>

    <DeleteEntityModal name_entity="запись" />

</template>

<script lang="ts" setup>
    import { useStore } from "/resources/js/store.js"
    import {Head, router} from '@inertiajs/vue3'
    import Pagination from '@/Components/Pagination.vue'
    import ru from 'element-plus/dist/locale/ru.mjs'
    import TableFilter from '@/Components/TableFilter.vue'
    import {inject, reactive, ref} from "vue";
    import { func} from '@/func.js'

    const props = defineProps({
        calendars: Object,
        title: {
            type: String,
            default: 'Календарь записи',
        },
        filters: Array,
        services: Array,
        employees: Array,
    })
    const store = useStore();
    const $delete_entity = inject("$delete_entity")
    const Loading = ref(false)
    const tableData = ref([...props.calendars.data])
    const filter = reactive({
        phone: props.filters.phone,
        service: props.filters.service,
        employee: props.filters.employee,
        day_at: props.filters.day_at,
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
        $delete_entity.show(route('admin.calendar.calendar.destroy', {calendar: row.id})).then(() => {

        });
    }
    function handleOrder(row) {
        router.post(route('admin.calendar.calendar.to-order', {calendar: row.id}))
    }
    function handleCancel(row) {
        router.visit(route('admin.calendar.calendar.cancel', {calendar: row.id}), {
            method: "post",
            preserveState: true,
            preserveScroll: true,
        })
    }

    function createButton() {
        router.get(route('admin.calendar.calendar.create'))
    }
</script>

