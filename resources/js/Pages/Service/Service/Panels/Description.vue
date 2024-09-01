<template>
    <el-tab-pane>
        <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><Document/></el-icon>
                      <span> Описание</span>
                    </span>
        </template>
        <div class="mt-5 p-5 bg-white rounded-lg border shadow" v-html="text"></div>
    </el-tab-pane>
</template>

<script lang="ts" setup>
import {reactive, ref} from 'vue'

const props = defineProps({
    text: String
});

</script>

