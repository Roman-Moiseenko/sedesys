<template>
    <el-tooltip effect="dark" v-if="order.status.manager"
                content="Убедитесь, что у клиента есть email"
                placement="top">
        <el-button type="warning" @click="goAwaiting">На оплату</el-button>
    </el-tooltip>
    <el-button type="success" plain @click="goPaid">Оплачен</el-button>
    <el-tooltip effect="dark"
                content="Распечатать чек"
                placement="top">
        <el-button type="success" dark @click="goCheque">Чек</el-button>
    </el-tooltip>
    <el-button type="info" plain @click="goCancel">Отменить</el-button>
</template>

<script lang="ts" setup>
import {router} from '@inertiajs/vue3'
import { func } from '/resources/js/func.js'
import {defineProps} from "vue";

const props = defineProps({
    order: Object,
})

function goAwaiting() {
    router.post(route('admin.order.order.awaiting', {order: props.order.id}))
}

function goPaid() {
    router.post(route('admin.order.order.paid', {order: props.order.id}))
}
function goCheque() {
    router.post(route('admin.order.order.cheque', {order: props.order.id}))
}
function goCancel() {
    router.post(route('admin.order.order.cancel', {order: props.order.id}))
}
</script>

