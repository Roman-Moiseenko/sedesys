<template>
    <el-table :data="[...order.consumables]"
              style="width: 100%;">
        <el-table-column sortable prop="consumable" label="Материал" />
        <el-table-column prop="base_cost" label="Цена Баз." width="140" />
        <el-table-column label="Цена Прод." width="140">
            <template #default="scope">
                <el-input v-model="scope.row.sell_cost"
                          :formatter="(value) => func.MaskInteger(value)"
                          @change="setItem(scope.row)"
                          :disabled="iSaving"
                          :readonly="!isEdit"
                >
                    <template #append>₽</template>
                </el-input>
            </template>
        </el-table-column>
        <el-table-column label="Кол-во" width="120">
            <template #default="scope">
                <el-input v-model="scope.row.quantity"
                          :formatter="(value) => func.MaskCount(value)"
                          @change="setItem(scope.row)"
                          :disabled="iSaving"
                          :readonly="!isEdit"
                          min="1"
                >
                    <template #append>шт</template>
                </el-input>
            </template>
        </el-table-column>
        <el-table-column label="Комментарий" >
            <template #default="scope">
                <el-input v-model="scope.row.comment"
                          @change="setItem(scope.row)"
                          :disabled="iSaving"
                          :readonly="!isEdit"
                />
            </template>
        </el-table-column>
        <el-table-column label="" width="70">
            <template #default="scope">
                <el-button v-if="isEdit" type="danger" @click="delItem(scope.row)" plain><el-icon><Delete /></el-icon></el-button>
            </template>
        </el-table-column>
    </el-table>
</template>

<script lang="ts" setup>
import {computed, defineProps, ref} from "vue";
import {router} from '@inertiajs/vue3'
import { func } from '/resources/js/func.js'

const iSaving = ref(false)
const props = defineProps({
    order: Object,
})
const isEdit = computed<Boolean>(() => props.order.status.new || props.order.status.manager)

function setItem(row) {
    iSaving.value = true;
    router.visit(props.order.routers.set_item, {
        method: "post",
        data: {
            item: 'consumable',
            id: row.id,
            sell_cost: row.sell_cost,
            quantity: row.quantity,
            comment: row.comment,
        },
        onSuccess: page => {
            iSaving.value = false;
        }
    })

}
function delItem(row) {
    router.post(props.order.routers.del_item, {
        item: 'consumable',
        id: row.id,
    })
}


</script>

<style>
    .el-input-group__append {
        padding: 0 12px;
    }
    .el-button {
        padding: 8px 12px;
    }
</style>
