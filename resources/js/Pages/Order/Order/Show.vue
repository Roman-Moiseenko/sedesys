<template>
    <Head><title>{{ title + ' ' + order.name }}</title></Head>
    <h1 class="font-medium text-xl"> {{ order.name }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid grid-cols-3 divide-x">
            <div class="p-4">
                <EditUser
                    :user="order.user"
                    :find_user="order.find_user"
                    :set_user="order.set_user"
                />
            </div>
            <div class="p-4">
                Менеджер + Инфа + Основание
            </div>
            <div class="p-4">
                <el-tooltip effect="dark" v-if="order.status.manager"
                    content="Убедитесь, что у клиента есть email"
                    placement="top">
                    <el-button type="warning" @click="router.post(order.routers.awaiting)">На оплату</el-button>
                </el-tooltip>
                <el-button type="success" plain @click="router.post(order.routers.paid)">Оплачен</el-button>
                <el-tooltip effect="dark"
                            content="Распечатать чек"
                            placement="top">
                    <el-button type="success" dark @click="router.post(order.routers.cheque)">Чек</el-button>
                </el-tooltip>
                <el-button type="info" plain @click="router.post(order.routers.cancel)">Отменить</el-button>

            </div>
        </div>
    </div>
    <div class="mt-5 grid grid-cols-6 divide-x gap-6">
        <!-- Панель позиции в заказе -->
        <div class=" p-3 bg-white rounded-lg col-span-4">
            <TableOrderServices :order="order"/>
            <TableOrderExtras :order="order"/>
            <TableOrderConsumables :order="order"/>
        </div>
        <!-- Функциональные Панели в Зависимости от статуса -->
        <div class="p-3 bg-white rounded-lg col-span-2">
            <StatusPanelsNew v-if="order.status.new"
                                 :order="order"
            />
            <StatusPanelsManager v-if="order.status.manager"
                                 :order="order"
            />
            <StatusPanelsAwaiting v-if="order.status.awaiting"
                                 :order="order"
            />
            <!--el-tabs type="border-card" class="mb-4" v-if="order.status.manager">
                <OrderService
                    :services="services"
                    :add_item="order.routers.add_item"
                    :errors="errors"
                />
                <OrderExtra
                    :extras="extras"
                    :add_item="order.routers.add_item"
                    :errors="errors"
                />
                <OrderConsumable
                    :consumables="consumables"
                    :add_item="order.routers.add_item"
                    :errors="errors"
                />
            </el-tabs-->

        </div>
    </div>
</template>

<script lang="ts" setup>
import {reactive, ref, provide, computed} from 'vue'
import {Head, Link} from '@inertiajs/vue3'
import {router} from '@inertiajs/vue3'
import { func } from '/resources/js/func.js'

//Добавление OrderItems
import OrderService from './Items/OrderService.vue'
import OrderExtra from './Items/OrderExtra.vue'
import OrderConsumable from './Items/OrderConsumable.vue'

//Таблицы OrderItems
import TableOrderServices from './Tables/OrderServices.vue'
import TableOrderExtras from './Tables/OrderExtras.vue'
import TableOrderConsumables from './Tables/OrderConsumables.vue'

//Функциональные блоки по статусу
import StatusPanelsNew from  './StatusPanels/New.vue'
import StatusPanelsManager from  './StatusPanels/Manager.vue'
import StatusPanelsAwaiting from  './StatusPanels/Awaiting.vue'


import EditUser from '@/Components/Edit/User.vue'

const props = defineProps({
    order: Object,
    errors: Object,
    title: {
        type: String,
        default: 'Заказ',
    },
    //Массивы для добавления позиций
    consumables: Array,
    services: Array,
    extras: Array,
});

//Данные для дочерних элементов
provide("prov_errors", computed(() => props.errors))

provide("prov_items", {
    consumables: computed(() => props.consumables),
    services: computed(() => props.services),
    extras: computed(() => props.extras),
})


/**
 * Методы
 */

</script>

<style>

</style>
