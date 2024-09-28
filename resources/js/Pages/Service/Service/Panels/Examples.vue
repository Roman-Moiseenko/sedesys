<template>
    <el-tab-pane>
        <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><Help/></el-icon>
                      <span> Примеры работы</span>
                    </span>
        </template>
        <div class="mb-5">
            <el-table :data="examples"
                      style="width: 100%; cursor: pointer;"
                      @row-click="rowClick"
            >
                <el-table-column label="Дата" prop="date"  width="120" />
                <el-table-column label="Заголовок" prop="title" width="250"/>

                <el-table-column label="Исполнители" width="250">
                    <template #default="scope">
                        <el-tag class="mr-1" v-for="item in scope.row.employees">
                            {{ func.fullName(item.fullname) }}
                        </el-tag>
                    </template>
                </el-table-column>

                <el-table-column label="Стоимость" prop="cost"  width="120" />
                <el-table-column label="Изображения" prop="gallery_count"  width="120" />
                <el-table-column label="Описание" prop="description" show-overflow-tooltip/>
                <el-table-column label="Действия" width="250">
                    <template #default="scope">
                        <el-button v-if="scope.row.active"
                                   size="small"
                                   type="warning"
                                   @click.stop="handleToggle(scope.row)">
                            Hide
                        </el-button>
                        <el-button v-if="!scope.row.active"
                                   size="small"
                                   type="success"
                                   @click.stop="handleToggle(scope.row)">
                            Show
                        </el-button>
                        <el-button
                            size="small"
                            @click.stop="handleEdit(scope.row)">
                            Edit
                        </el-button>
                    </template>
                </el-table-column>

            </el-table>
        </div>
        <el-button @click="handleCreate()">Новый пример</el-button>
    </el-tab-pane>
</template>

<script lang="ts" setup>
import {reactive, ref} from "vue";
import {func} from '@/func.js'
import {router} from "@inertiajs/vue3";

const props = defineProps({
    examples: Array,
    service_id: Number,
})
function handleCreate() {
    router.get(route('admin.service.example.create', {service_id: props.service_id}))
}
function rowClick(row) {
    router.get(route('admin.service.example.show', {example: row.id}))
}
function handleEdit(row) {
    router.get(route('admin.service.example.edit', {example: row.id}))
}
function handleToggle(row) {
    router.post(route('admin.service.example.toggle', {example: row.id}))
}
</script>

<style scoped>

</style>
