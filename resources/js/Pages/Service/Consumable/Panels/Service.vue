<template>
    <el-tab-pane>
        <template #label>
            <span class="custom-tabs-label">
                <el-icon><SuitcaseLine /></el-icon>
                <span> Услуги</span>
            </span>
        </template>
        <div class="mb-5">
            <el-table
                :data="services"
                style="width: 100%; cursor: pointer;"
                @row-click="routeClick"
            >
                <!-- Повторить поля -->
                <el-table-column sortable prop="name" label="Услуга" width="250" show-overflow-tooltip/>
                <el-table-column sortable prop="classification" label="Классификация"  width="250"/>
                <el-table-column prop="count" label="Кол-во" width="100" />
                <el-table-column prop="price" label="Базовая стоимость услуги" width="100" >
                    <template #default="scope">
                        {{ func.price(scope.row.price)}}
                    </template>
                </el-table-column>
                <el-table-column label="Расх.материалы" >
                    <template #default="scope">
                        <el-tag v-for="item in scope.row.consumables">{{ item }}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button
                            size="small"
                            type="danger"
                            @click.stop="detachService(scope.row)"
                        >
                            Detach
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <el-button type="success" plain @click="dialogService = true">
            <el-icon><SuitcaseLine /></el-icon>&nbsp;Добавить Услугу
        </el-button>
        <!--Dialog-->
        <el-dialog v-model="dialogService" width="400" class="p-4" center>
            <el-form :model="formService" class="mt-3">
                <el-form-item label="Услуга">
                    <el-select v-model="formService.service_id">
                        <el-option v-for="item in out_services" :value="item.id" :key="item.id"
                                   :label="item.name"/>
                    </el-select>
                </el-form-item>
                <el-form-item label="Кол-во материала на 1 услугу" class="mb-3">
                    <el-input v-model="formService.count" :formatter="(value) => func.MaskInteger(value)" placeholder=""
                              class="mb-3">
                        <template #append>шт</template>
                    </el-input>
                </el-form-item>
                <el-button type="info" plain @click="dialogService = false">
                    Отмена
                </el-button>
                <el-button type="primary" @click="attachService">Сохранить</el-button>
                <span v-if="dialogSave" class="text-lime-500 text-sm ml-3">Сохранено</span>
            </el-form>
        </el-dialog>

    </el-tab-pane>
</template>

<script lang="ts" setup>
import {defineProps, reactive, ref} from "vue";
import {func} from '/resources/js/func.js'
import {router} from "@inertiajs/vue3";

const dialogService = ref(false)
const dialogSave = ref(false)
const props = defineProps({
    services: Array,
    consumable_id: Number,
    out_services: Array,
})
const formService = reactive({
    service_id: null,
    count: null
});

function detachService(row) {
    router.post(route('admin.service.consumable.detach', {consumable: props.consumable_id}), {
        service_id: row.id
    });
}
function attachService() {
    if (formService.service_id === null) return;
    router.post(route('admin.service.consumable.attach', {consumable: props.consumable_id}), formService);
    dialogService.value = false;
}
function routeClick(row) {
    router.get(route('admin.service.service.show', {service: row.id}))
}

</script>

<style scoped>

</style>
