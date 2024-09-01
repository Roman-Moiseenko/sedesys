<template>
    <el-tab-pane>
        <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><TakeawayBox/></el-icon>
                      <span> Расходники</span>
                    </span>
        </template>
        Список материала + кол-во + цена за 1 шт.
    </el-tab-pane>
</template>
<script lang="ts" setup>
import {reactive, ref} from "vue";
import {func} from '@/func.js'
import {router} from "@inertiajs/vue3";

const props = defineProps({
    consumables: Array,
    detach: String,
    attach: String,
    out_consumables: Array,
})

</script>
