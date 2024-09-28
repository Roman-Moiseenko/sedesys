<template>
    <el-table :data="[...order.services]"
              style="width: 100%;">
        <el-table-column sortable prop="service" label="Услуга" >
            <template #default="scope">
                <div>
                    {{ scope.row.service}}
                </div>
                <div>
                    <el-tag v-if="scope.row.employee" type="primary">{{ scope.row.employee }}</el-tag>
                </div>
            </template>
        </el-table-column>
        <el-table-column label="Цена Баз." width="140">
            <template #default="scope">
                <div>
                    {{ func.price(scope.row.base_cost)}}
                </div>
                <div>
                    <el-tag v-if="scope.row.promotion" type="danger">{{ scope.row.promotion }}</el-tag>
                </div>
            </template>
        </el-table-column>
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
import {defineProps, ref, computed} from "vue";
import {router} from '@inertiajs/vue3'
import { func } from '/resources/js/func.js'

const iSaving = ref(false)
const props = defineProps({
    order: Object,
})
const isEdit = computed<Boolean>(() => props.order.status.new || props.order.status.manager)

function setItem(row) {
    iSaving.value = true;
    router.visit(route('admin.order.order.set-item', {order: props.order.id}), {
        method: "post",
        data: {
            item: 'service',
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
    router.post(route('admin.order.order.del-item', {order: props.order.id}), {
        item: 'service',
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
