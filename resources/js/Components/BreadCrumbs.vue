<template>
    <el-breadcrumb :separator-icon="ArrowRight">
        <template v-for="item in $page.props.breadcrumbs">
        <el-breadcrumb-item :to="{ path: item.url }">
            <Link :href="item.url" class="flex items-center">

            {{ item.title}}
            </Link>

        </el-breadcrumb-item>
        </template>
    </el-breadcrumb>

</template>

<script lang="ts" setup>
import { ArrowRight } from '@element-plus/icons-vue'

</script>
<script lang="ts">
import { Link } from '@inertiajs/vue3'

export default {
    props: {
        breadcrumbs: Object
    }
}
</script>

<style scoped>

</style>
