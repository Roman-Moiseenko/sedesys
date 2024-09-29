<template>
    <el-card class="mb-4">
        <div>
            Заказ <el-tag >Оплачен</el-tag>
        </div>
        <div class="mt-1">
            Дата/время: <el-tag type="warning" effect="plain">{{ order.status.date }}</el-tag>
        </div>
    </el-card>
</template>

<script lang="ts" setup>
import {defineProps} from "vue";
import InfoOrder from './Info/Show.vue'
const props = defineProps({
    order: Object,
})
</script>

<style scoped>

</style>
