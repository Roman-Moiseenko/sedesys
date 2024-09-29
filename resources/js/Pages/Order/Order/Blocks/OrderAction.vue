<template>
    <el-tooltip effect="dark" v-if="order.status.manager"
                content="Убедитесь, что у клиента есть email"
                placement="top">
        <el-button type="warning" @click="goAwaiting">На оплату</el-button>
    </el-tooltip>
    <el-popover trigger="click" placement="bottom-start" :width="160">
        <el-form :model="filter">
            <el-input v-model="formPayment.amount" :formatter="(val) => func.MaskInteger(val)">
                <template #append>₽</template>
            </el-input>
            <el-radio-group v-model="formPayment.method" class="mt-1" placeholder="Способ">
                <el-radio v-for="item in methods" :key="item.value" :value="item.value" :label="item.label"/>
            </el-radio-group>
            <div class="mt-2">
                <el-button @click="goPaid" type="primary">Оплатить</el-button>
            </div>
        </el-form>
        <template #reference>
            <el-button type="success" plain>Оплачен</el-button>
        </template>
    </el-popover>

    <el-tooltip effect="dark"
                content="Распечатать чек и закрыть заказ"
                placement="top">
        <el-button type="success" dark @click="goCheque">Чек</el-button>

    </el-tooltip>
    <el-button type="info" plain @click="goCancel">Отменить</el-button>
</template>

<script lang="ts" setup>
import {router} from '@inertiajs/vue3'
import {func} from '/resources/js/func.js'
import {defineProps, reactive} from "vue";
import {ClickOutside as vClickOutside} from 'element-plus'

const props = defineProps({
    order: Object,
    methods: Array,

})

const formPayment = reactive({
    method: null,
    amount: props.order.info.amount_sell,
})


function goAwaiting() {
    router.post(route('admin.order.order.awaiting', {order: props.order.id}))
}

function goPaid() {
    router.post(route('admin.order.order.paid', {order: props.order.id}), formPayment)
}

function goCheque() {
    router.post(route('admin.order.order.cheque', {order: props.order.id}))
}

function goCancel() {
    router.post(route('admin.order.order.cancel', {order: props.order.id}))
}
</script>

