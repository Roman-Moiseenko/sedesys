<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Архив заявок</h1>
        <!-- Фильтр -->
        <div class="flex">
            <TableFilter :filter="filter" class="ml-auto" :count="$props.filters.count">
                <el-select v-model="filter.template" placeholder="Шаблон заявки">
                    <el-option v-for="item in templates" :value="item.id" :key="item.id" :label="item.name"/>
                </el-select>
                <el-select v-model="filter.staff" placeholder="Менеджер" class="mt-1">
                    <el-option v-for="item in staffs" :value="item.id" :key="item.id" :label="item.name"/>
                </el-select>
            </TableFilter>
        </div>
        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="[...feedback.data]"
                :max-height="600"
                style="width: 100%; cursor: pointer;"
                :row-class-name="tableRowClassName"
                @row-click="routeClick"
                v-loading="store.getLoading"
            >
                <el-table-column prop="created_at" label="Дата" width="160" />
                <el-table-column prop="user" label="Клиент" width="120" />
                <el-table-column prop="email" label="Почта" width="120" />
                <el-table-column prop="phone" label="Телефон" width="120" />
                <el-table-column prop="message" label="Сообщение" width="220" show-overflow-tooltip/>
                <el-table-column label="Данные" >
                    <template #default="scope">
                        <el-tag v-for="(item, index) in scope.row.data" type="warning">{{ index + ': ' + item }}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column prop="phone" label="Статус" >
                    <template #default="scope"><el-tag type="info">{{ scope.row.status_html }}</el-tag></template>
                </el-table-column>

                <el-table-column prop="staff" label="Ответственный" />

                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button
                            size="small"
                            @click.stop="handleArchive(scope.row)">
                            Из архива
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <pagination
            :current_page="$page.props.feedback.current_page"
            :per_page="$page.props.feedback.per_page"
            :total="$page.props.feedback.total"
        />
    </el-config-provider>


</template>

<script lang="ts" setup>
import { ref, reactive } from 'vue'
import { useStore } from "/resources/js/store.js"
import { Head, router } from '@inertiajs/vue3'
import Pagination from '@/Components/Pagination.vue'
import ru from 'element-plus/dist/locale/ru.mjs'
import TableFilter from '@/Components/TableFilter.vue'
import {func} from "/resources/js/func.js"

const store = useStore()
const props = defineProps({
    feedback: Object,
    title: {
        type: String,
        default: 'Список заявок в архиве',
    },
    filters: Array,
    templates: Array,
    staffs: Array,
})
const Loading = ref(false)
const filter = reactive({
    template: props.filters.template,
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
function handleArchive(row) {
    router.visit(route('admin.feedback.feedback.from-archive', {feedback: row.id}), {
        method: "post"
    })
}
function routeClick(row) {
    router.get(route('admin.feedback.feedback.show', {feedback: row.id}))
}
</script>


