<template>
    <div class="mt-3">
        <el-pagination
            class=""
            layout="total, sizes, prev, pager, next, jumper"
            :page-sizes="[20, 100, 200, 500]"
            :page-size="PageSize"
            :current-page="CurrentPage"
            :total="Total"
            @size-change="handleSizeChange"
            @current-change="handleCurrentChange"
        >
        </el-pagination>
    </div>
</template>



<script>
import { router } from '@inertiajs/vue3'

export default {
    props: {
        current_page: Number,
        per_page: Number,
        total: Number,
    },
    emits: [],
    data() {
        return {
            CurrentPage: this.current_page,
            PageSize: this.per_page,
            Total: this.total,
        }
    },
    methods: {
        handleSizeChange(val) {

           // this.$emit('toggle-loading', 'begiiiin');
            this.pageSize = val;
            router.get(this.$page.url, {page: this.$data.CurrentPage, size: val});
        },
        handleCurrentChange(val) {

           // this.$emit('toggle-loading', 'begiiiineeer');
            this.$data.CurrentPage = val;
            router.get(this.$page.url, {page: val, size: this.$data.PageSize});
        },
    }
}
</script>
