<template>
    <el-tab-pane>
        <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><TakeawayBox/></el-icon>
                      <span> Расходники</span>
                    </span>
        </template>
        <div class="mb-5">
            <el-table :data="consumables"
                      style="width: 100%;"
                      @row-click="rowClick"
            >
                <el-table-column label="Расходный материал" prop="name" width="250" />

                <el-table-column label="Стоимость за шт." width="250">
                    <template #default="scope">
                        {{ func.price(scope.row.price) }}
                    </template>
                </el-table-column>
                <el-table-column label="Кол-во за 1 услугу" width="250">
                    <template #default="scope">
                        {{ scope.row.pivot.count }}
                    </template>
                </el-table-column>

                <el-table-column label="Действия" width="250">
                    <template #default="scope">
                        <el-button type="warning" @click.stop="detachConsumable(scope.row.id)">Detach</el-button>
                    </template>
                </el-table-column>

            </el-table>
        </div>
        <el-button type="success" plain @click="dialogConsumable = true">
            <el-icon>
                <TakeawayBox/>
            </el-icon>&nbsp;
            Добавить материал
        </el-button>
        <!--Dialog-->
        <el-dialog v-model="dialogConsumable" width="400" class="p-4" center>
            <el-form :model="formConsumable" class="mt-3">
                <el-form-item label="Материал">
                    <el-select v-model="formConsumable.consumable_id">
                        <el-option v-for="item in out_consumables" :value="item.id" :key="item.id"
                                   :label="item.name"/>
                    </el-select>
                </el-form-item>
                <el-form-item label="Кол-во в услуге" class="mb-3">
                    <el-input v-model="formConsumable.count" :formatter="(value) => func.MaskInteger(value)" placeholder=""
                              class="mb-3">
                        <template #append>шт</template>
                    </el-input>
                </el-form-item>
                <el-button type="info" plain @click="dialogConsumable = false">
                    Отмена
                </el-button>
                <el-button type="primary" @click="attachConsumable">Сохранить</el-button>
                <span v-if="dialogSave" class="text-lime-500 text-sm ml-3">Сохранено</span>
            </el-form>
        </el-dialog>
    </el-tab-pane>
</template>
<script lang="ts" setup>
import {reactive, ref} from "vue";
import {func} from '@/func.js'
import {router} from "@inertiajs/vue3";

const dialogConsumable = ref(false)
const dialogSave = ref(false)
const props = defineProps({
    consumables: Array,
    detach: String,
    attach: String,
    out_consumables: Array,
})
const formConsumable = reactive({
    consumable_id: null,
    count: null
});
function attachConsumable() {
    if (formConsumable.consumable_id === null) return;
    router.post(props.attach, formConsumable);
    dialogConsumable.value = false;
}


function detachConsumable(val) {
    router.post(props.detach, {consumable_id: val})
}
function rowClick(row) {
    //router.get(row.url)
}
</script>
