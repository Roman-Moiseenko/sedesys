<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ classification.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid lg:grid-cols-6 grid-cols-1 divide-x">
            <div class="p-4 col-span-4">
                <el-descriptions :column="1" border>
                    <el-descriptions-item label="Классификация">{{ classification.name }}</el-descriptions-item>
                    <el-descriptions-item label="Ссылка">{{ classification.slug }}</el-descriptions-item>
                </el-descriptions>
                <DisplayedShow :displayed="classification" />
            </div>
            <div class="p-4 col-span-2 flex">
                <DisplayedImage :image="$props.image" :icon="$props.icon" />
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!classification.active" type="success" @click="handleToggle">Показывать</el-button>
            <el-button v-if="classification.active" type="warning" @click="handleToggle">Скрыть из показа</el-button>
        </div>
    </div>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <h2 class="font-medium text-lg mb-3">Услуги:</h2>
        <el-table
            :data="services"
            row-key="id"
            :row-class-name="tableRowClassName"
            style="width: 100%; cursor: pointer; margin-bottom: 20px;"
            @row-click="routeClick"
            default-expand-all
        >
            <el-table-column sortable prop="name" label="Название" width="200" />
            <el-table-column sortable prop="price" label="Цена" width="200" />
            <el-table-column sortable prop="duration" label="Длительность" width="200" />
            <el-table-column label="Действия" >
                <template #default="scope">
                    <el-button v-if="scope.row.active"
                               size="small"
                               type="warning"
                               @click.stop="handleToggleRow(scope.$index, scope.row)">
                        Hide
                    </el-button>
                    <el-button v-if="!scope.row.active"
                               size="small"
                               type="success"
                               @click.stop="handleToggleRow(scope.$index, scope.row)">
                        Show
                    </el-button>
                    <el-button
                        size="small"
                        @click.stop="handleEdit(scope.$index, scope.row)">
                        Edit
                    </el-button>
                </template>
            </el-table-column>
        </el-table>
    </div>

</template>

<script lang="ts" setup>
import {Head, Link, router} from '@inertiajs/vue3'
import DisplayedImage from '@/Components/DisplayedImage.vue'
import DisplayedShow from '@/Components/DisplayedShow.vue'

    interface IRow {
        active: number
    }
    const tableRowClassName = ({row, rowIndex}: {row: IRow }) => {
        if (row.active === false) {
            return 'warning-row'
        }
        return ''
    }
    const props = defineProps({
        classification: Object,
        edit: String,
        title: {
            type: String,
            default: 'Карточка категории услуг',
        },
        image: String,
        icon: String,
        toggle: String,
        services: Array,
    });

    /**
     * Методы
     */
    function handleToggle() {
        router.post(props.toggle);
    }

</script>
<script lang="ts">
    import { router } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'
    import DisplayedShow from '@/Components/DisplayedShow.vue'

    export default {
        layout: Layout,
        methods: {
            goEdit() {
                router.get(this.$props.edit);
            },
            routeClick(row) {
                router.get(row.url)
            },
            handleToggleRow(index, row) {
                router.visit(row.toggle, {
                    method: 'post'
                });
            },
            handleEdit(index, row) {
                router.get(row.edit);
            },
        },
    }

</script>

<style >
.el-table tr.warning-row {
    --el-table-tr-bg-color: var(--el-color-warning-light-7);
}
.el-table .success-row {
    --el-table-tr-bg-color: var(--el-color-success-light-9);
}
</style>
