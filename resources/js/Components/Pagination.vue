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
import { useStore } from "/resources/js/store.js"

export default {
    props: {
        current_page: Number,
        per_page: Number,
        total: Number,
    },
    data() {
        return {
            CurrentPage: this.current_page,
            PageSize: this.per_page,
            Total: this.total,
            Loading: false,
        }
    },
    methods: {
        handleSizeChange(val) {
            this.$data.Loading = true;
            this.pageSize = val;
            router.visit(this.$page.url,
                {
                    method: 'get',
                    data: {page: this.$data.CurrentPage, size: val},
                    onBefore: visit => {
                        useStore().beforeLoad();
                    },
                    onFinish: visit => {
                        useStore().afterLoad();
                    },
                }
            );

        },
        handleCurrentChange(val) {
            this.$data.CurrentPage = val;
            router.visit(this.$page.url,
                {
                    method: 'get',
                    data: {page: val, size: this.$data.PageSize},
                    onBefore: visit => {
                        useStore().beforeLoad();
                    },
                    onFinish: visit => {
                        useStore().afterLoad();
                    },
                }
                );
        },
    }
}
</script>
