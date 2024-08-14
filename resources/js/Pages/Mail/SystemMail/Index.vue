<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Системные письма</h1>

        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="$data.tableHeight"
                style="width: 100%; cursor: pointer;"
                @row-click="routeClick"
                v-loading="store.getLoading"
            >
                <el-table-column sortable prop="mailable" label="Служба" width="100" />
                <el-table-column sortable prop="user" label="Получатель" />
                <el-table-column sortable prop="created_at" label="Отправлено" />
                <el-table-column prop="count" label="Отправок" />

                <!-- Повторить -->
                <el-table-column label="Действия">
                    <template #default="scope">
                        <el-button
                            size="small"
                            @click.stop="handleRepeat(scope.$index, scope.row)">
                            Repeat
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>

        <pagination
            :current_page="$page.props.systemMails.current_page"
            :per_page="$page.props.systemMails.per_page"
            :total="$page.props.systemMails.total"
        />
    </el-config-provider>
    <!-- Dialog Delete -->
    <el-dialog v-model="$data.dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить systemMail?
        </div>
        <div class="text-red-600 text-md mt-2">
            Восстановить данные будет невозможно!
        </div>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="$data.dialogDelete = false">Отмена</el-button>
                <el-button type="danger" @click="removeItem($data.routeDestroy)">
                    Удалить
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
    import { useStore } from "/resources/js/store.js"
    import { Head, Link } from '@inertiajs/vue3'
    import Pagination from '@/Components/Pagination.vue'
    import ru from 'element-plus/dist/locale/ru.mjs'

    const store = useStore();

</script>

<script lang="ts">
import Layout from '@/Components/Layout.vue'
import { router } from '@inertiajs/vue3'

export default {

    layout: Layout,
    props: {
        systemMails: Object,
        title: {
            type: String,
            default: 'Системная почта',
        }
    },
    data() {
        return {
            tableData: [...this.systemMails.data],
            tableHeight: '600',
            Loading: false,
            dialogDelete: false,
            routeDestroy: null,
        }
    },
    methods: {
        routeClick(row) {
            router.get(row.url)
        },
        handleRepeat(index, row) {
            router.post(row.repeat);
        },

        removeItem(_route) {
            if (_route !== null) {
                router.visit(_route, {
                    method: 'delete'
                });
                this.$data.dialogDelete = false;
                this.$data.routeDestroy = null;
            }
        },
    }
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
