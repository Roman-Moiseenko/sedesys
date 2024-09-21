<template>
    <el-tabs type="border-card" class="mb-4">
        <AddService :add_item="order.routers.add_item" />
        <AddExtra :add_item="order.routers.add_item"/>
        <AddConsumable :add_item="order.routers.add_item"/>
    </el-tabs>
    <InfoEdit :order="order" />
    <InfoShow :order="order" />
</template>

<script lang="ts" setup>
import { defineProps } from "vue";
import InfoEdit from './Info/Edit.vue'
import InfoShow from './Info/Show.vue'
//Добавление OrderItems
import AddService from './AddItems/Service.vue'
import AddExtra from './AddItems/Extra.vue'
import AddConsumable from './AddItems/Consumable.vue'

const props = defineProps({
    order: Object,
})
</script>

<style scoped>

</style>
