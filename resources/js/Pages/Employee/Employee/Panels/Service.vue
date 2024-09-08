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
                :data="services_data.services"
                style="width: 100%; cursor: pointer;"
                @row-click="routeClick"
            >
                <!-- Повторить поля -->
                <el-table-column sortable prop="name" label="Услуга" width="250" show-overflow-tooltip/>
                <el-table-column sortable prop="classification" label="Классификация"  width="250"/>
                <el-table-column prop="price" label="Базовая стоимость" width="100" />
                <el-table-column prop="extra_cost" label="Доп. наценка" width="100" >
                    <template #default="scope">
                        {{ func.price(scope.row.extra_cost) }}
                    </template>
                </el-table-column>
                <el-table-column label="Расх.материалы (₽)" width="160" />
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
                <el-form-item label="Персонал">
                    <el-select v-model="formService.service_id">
                        <el-option v-for="item in services_data.out_services" :value="item.id" :key="item.id"
                                   :label="item.name"/>
                    </el-select>
                </el-form-item>
                <el-form-item label="Дополнительная наценка" class="mb-3">
                    <el-input v-model="formService.extra_cost" @input="handleExtraCost" placeholder=""
                              class="mb-3">
                        <template #append>₽</template>
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
import {router} from "@inertiajs/vue3";
import {func} from '@/func.js'

const dialogService = ref(false)
const dialogSave = ref(false)

const props = defineProps({
    services_data: Object,

})
const formService = reactive({
    service_id: null,
    extra_cost: null
});
function handleExtraCost(val) {
    formService.extra_cost = func.MaskInteger(val);
}
function detachService(row) {
    router.post(props.services_data.detach, {
        service_id: row.id
    });
}
function attachService() {
    if (formService.service_id === null) return;
    router.post(props.services_data.attach, formService);
    dialogService.value = false;
}

</script>
<script lang="ts">
import {router} from "@inertiajs/vue3";

export default {
    methods: {
        routeClick(row) {
            router.get(row.url)
        },
    },
}
</script>

<style scoped>

</style>
