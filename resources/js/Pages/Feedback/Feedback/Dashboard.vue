<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Новые заявки</h1>

        <div v-for="dashboard in dashboards" class="mt-5 p-5 rounded-lg"
             :style="{ 'background-color':  dashboard.color }">
            <h2 class="font-medium text-lg mb-2">{{ dashboard.name }}</h2>
            <el-table
                :data="[...dashboard.feedbacks]"
                :max-height="600"
                style="width: 100%;"
            >
                <!-- Повторить поля -->
                <el-table-column prop="created_at" label="Дата" width="160"/>
                <el-table-column prop="user" label="Клиент" width="120"/>
                <el-table-column prop="email" label="Почта" width="120"/>
                <el-table-column prop="phone" label="Телефон" width="120"/>
                <el-table-column prop="message" label="Сообщение" width="220" show-overflow-tooltip/>
                <el-table-column label="Данные">
                    <template #default="scope">
                        <el-tag v-for="(item, index) in scope.row.data" type="info" effect="dark">{{
                                index + ': ' + item
                            }}
                        </el-tag>
                    </template>
                </el-table-column>
                <el-table-column prop="phone" label="Статус" width="100">
                    <template #default="scope">
                        <el-tag type="info">{{ scope.row.status_html }}</el-tag>
                    </template>
                </el-table-column>

                <el-table-column label="Ответственный">
                    <template #default="scope">
                        <div class="flex">
                            <el-tag v-if="scope.row.staff" type="success" effect="dark">{{ scope.row.staff }}</el-tag>


                            <el-dropdown @command="onStaffChange(scope.row, $event)">
                                <el-button type="primary" class="mini-drop-button"><el-icon><arrow-down/></el-icon></el-button>
                                <template #dropdown>
                                    <el-dropdown-menu>
                                        <el-dropdown-item v-for="item in staffs" :command="item.id">{{ func.fullName(item.fullname) }}</el-dropdown-item>
                                    </el-dropdown-menu>
                                </template>
                            </el-dropdown>


                            <!--el-select @change="onStaffChange(scope.row, $event)" style="width: 40px;" placeholder="">
                                <el-option :value="null"></el-option>
                                <el-option v-for="item in staffs" :value="item.id">{{
                                        func.fullName(item.fullname)
                                    }}
                                </el-option>
                            </el-select-->
                        </div>
                    </template>
                </el-table-column>
                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button v-if="scope.row.email"
                                   size="small"
                                   @click.stop="handleEmail(scope.row)">
                            Email
                        </el-button>
                        <el-button v-if="!scope.row.completed"
                                   size="small"
                                   type="success"
                                   @click.stop="handleCompleted(scope.row)">
                            Complete
                        </el-button>
                        <el-button
                            size="small"
                            type="danger"
                            @click.stop="handleArchive(scope.row)"
                        >
                            Archive
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>

    </el-config-provider>

</template>

<script lang="ts" setup>
import {useStore} from "/resources/js/store.js"
import {Head, Link, router} from '@inertiajs/vue3'
import ru from 'element-plus/dist/locale/ru.mjs'
import {ref} from 'vue'
import {func} from "/resources/js/func.js"

const store = useStore();

const staffChange = ref(null);

interface IRow {
    /**
     * Статусы
     */
    active: number
}

const tableRowClassName = ({row, rowIndex}: { row: IRow }) => {
    if (row.active === false) {
        return 'warning-row'
    }
    return ''
}

const props = defineProps({
    dashboards: Object,
    title: {
        type: String,
        default: 'Текущие заявки',
    },
    staffs: Object,
})

function handleEmail(row) {
    router.post(row.to_email)
}

function handleCompleted(row) {
    router.post(row.to_completed)
}

function handleArchive(row) {
    router.post(row.to_archive)
}

function onStaffChange(row, staff) {
    router.post(row.set_staff, {staff: staff})
}
</script>


<style>
.el-table {
    --el-table-header-bg-color: rgba(0, 0, 0, 0);
    --el-table-bg-color: rgba(0, 0, 0, 0);
    --el-table-tr-bg-color: rgba(0, 0, 0, 0);
    --el-table-header-text-color: #333;
    --el-table-text-color: #111;
}
.mini-drop-button {
    width: 30px;
    height: 24px;
    margin-left: 8px;
    padding: 8px;
}
</style>
