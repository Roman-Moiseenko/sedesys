<template>
    <el-tab-pane>
        <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><ChatLineSquare/></el-icon>
                      <span> Отзывы</span>
                    </span>
        </template>
        <div class="mb-5">
            <el-table :data="reviews" style="width: 100%;">
                <el-table-column label="Дата" prop="created_at"  width="160" />
                <el-table-column label="Клиент" prop="from" width="250"/>
                <el-table-column label="Исполнитель" prop="employee" width="250"></el-table-column>
                <el-table-column label="Рейтинг" prop="rating"  width="120" />
                <el-table-column label="Отзыв" prop="text" show-overflow-tooltip />
            </el-table>
        </div>
    </el-tab-pane>
</template>

<script lang="ts" setup>
import {reactive, ref} from "vue";

const props = defineProps({
    reviews: Array,
})

</script>
