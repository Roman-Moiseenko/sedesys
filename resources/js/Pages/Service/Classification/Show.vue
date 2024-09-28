<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ classification.name }}  </h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-tabs type="border-card" class="mb-4">
            <el-tab-pane>
                <template #label>
                    <span class="custom-tabs-label">
                        <el-icon><SuitcaseLine /></el-icon>
                        <span> Услуги</span>
                    </span>
                </template>
                <div class="mt-3 p-3 bg-white rounded-lg">
                    <h2 class="font-medium text-lg mb-3">Услуги:</h2>
                    <el-table
                        :data="services"
                        row-key="id"
                        :row-class-name="tableRowClassName"
                        style="width: 100%; cursor: pointer; margin-bottom: 20px;"
                        @row-click="routeClick"
                        default-expand-all
                    >
                        <el-table-column sortable prop="name" label="Название" width="200" />
                        <el-table-column sortable prop="price" label="Цена" width="200" />
                        <el-table-column sortable prop="duration" label="Длительность" width="200" />
                        <el-table-column label="Действия" >
                            <template #default="scope">
                                <el-button v-if="scope.row.active"
                                           size="small"
                                           type="warning"
                                           @click.stop="handleToggleRow(scope.$index, scope.row)">
                                    Hide
                                </el-button>
                                <el-button v-if="!scope.row.active"
                                           size="small"
                                           type="success"
                                           @click.stop="handleToggleRow(scope.$index, scope.row)">
                                    Show
                                </el-button>
                                <el-button
                                    size="small"
                                    @click.stop="handleEditRow(scope.row)">
                                    Edit
                                </el-button>
                            </template>
                        </el-table-column>
                    </el-table>
                </div>
            </el-tab-pane>

            <DisplayedShowPanel
                :model="classification"
                :image="image"
                :icon="icon"
            />
        </el-tabs>

        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="handleEdit">Редактировать</el-button>
            <el-button v-if="!classification.active" type="success" @click="handleToggle">Показывать</el-button>
            <el-button v-if="classification.active" type="warning" @click="handleToggle">Скрыть из показа</el-button>
        </div>
    </div>


</template>

<script lang="ts" setup>
import {Head, Link, router} from '@inertiajs/vue3'
import DisplayedShowPanel from '@/Components/Displayed/Show.vue'

interface IRow {
    active: number
}
const tableRowClassName = ({row, rowIndex}: {row: IRow }) => {
    if (row.active === false) {
        return 'warning-row'
    }
    return ''
}
const props = defineProps({
    classification: Object,
    title: {
        type: String,
        default: 'Карточка категории услуг',
    },
    image: String,
    icon: String,
    services: Array,
});

function handleEdit() {
    router.post(route('admin.service.classification.edit', {classification: props.classification.id}));
}
function handleToggle() {
    router.post(route('admin.service.classification.toggle', {classification: props.classification.id}));
}
function handleToggleRow(index, row) {
    router.visit(route('admin.service.service.toggle', {service: row.id}), {
        method: 'post'
    });
}
function handleEditRow(row) {
    router.get(route('admin.service.service.edit', {service: row.id}));
}
</script>

