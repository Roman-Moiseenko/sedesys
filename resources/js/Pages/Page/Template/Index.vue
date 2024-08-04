<template>
    <Head><title>{{ title }}</title></Head>
    <el-config-provider :locale="ru">
        <h1 class="font-medium text-xl">Шаблоны</h1>
        <el-button type="primary" class="p-4 my-3" @click="dialogFormVisible = true">Создать Шаблон</el-button>

        <div class="mt-2 p-5 bg-white rounded-md">
            <el-table
                :data="tableData"
                :max-height="tableHeight"
                style="width: 100%; cursor: pointer;"
                @row-click="routeClick"
            >
                <el-table-column sortable prop="name" label="Название"/>
                <el-table-column sortable prop="template" label="Шаблон" width="150"/>
                <el-table-column sortable prop="type" label="Вид" width="100"/>
                <el-table-column prop="file" label="Путь"/>

                <!-- Повторить -->
                <el-table-column label="Действия">
                    <template #default="scope">
                        <el-button
                            size="small"
                            type="danger"
                            @click.stop="handleDelete(scope.$index, scope.row)"
                        >
                            Delete
                        </el-button>
                    </template>
                </el-table-column>
            </el-table>
        </div>


    </el-config-provider>
    <!-- Dialog Delete -->
    <el-dialog v-model="dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить Шаблон?
        </div>
        <div class="text-red-600 text-md mt-2">
            Восстановить данные будет невозможно!
        </div>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogDelete = false">Отмена</el-button>
                <el-button type="danger" @click="removeItem(routeDestroy)">
                    Удалить
                </el-button>
            </div>
        </template>
    </el-dialog>

    <el-dialog v-model="dialogFormVisible" title="Создать шаблон" width="500">
        <el-form :model="form">
            <el-form-item label="Название шаблона">
                <el-input v-model="form.name" autocomplete="off" placeholder="На русском"/>
            </el-form-item>
            <el-form-item label="Шаблон">
                <el-input v-model="form.template" autocomplete="off" placeholder="Имя файла"/>
            </el-form-item>
            <el-form-item label="Тип шаблона">
                <el-select v-model="form.type" placeholder="Выберите тип">
                    <el-option label="Виджет" value="widget"/>
                    <el-option label="Страницы" value="page"/>
                </el-select>
            </el-form-item>
        </el-form>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="dialogFormVisible = false">Отмена</el-button>
                <el-button type="primary" @click="onSubmit">
                    Создать
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>


<script>
import ru from 'element-plus/dist/locale/ru.mjs'
import Layout from '@/Components/Layout.vue'
import {router} from '@inertiajs/vue3'
import {Head, Link} from '@inertiajs/vue3'

export default {
    components: {
        Head,
        Link,
    },
    layout: Layout,

    data() {
        return {
            tableData: [...this.templates],
            tableHeight: '600',
            dialogDelete: false,
            dialogFormVisible: false,
            routeDestroy: null,
            form: {
                name: null,
                template: null,
                type: null,
            },
        }
    },
    props: {
        templates: Array,
        title: {
            type: String,
            default: 'Список Шаблонов',
        },
        store: String
    },

    methods: {
        handleDelete(index, row) {
            this.dialogDelete = true;
            this.routeDestroy = row.destroy;
        },
        removeItem(_route) {
            if (_route !== null) {
                router.visit(_route, {
                    method: 'delete'
                });
                this.dialogDelete = false;
                this.routeDestroy = null;
            }
        },
        onSubmit() {
            this.dialogFormVisible = false;
            router.post(this.store, this.form);
        },
        routeClick(row) {
            router.get(row.url);
        }

    }
}
</script>

<style>
.el-table tr.warning-row {
    --el-table-tr-bg-color: var(--el-color-warning-light-7);
}

.el-table .success-row {
    --el-table-tr-bg-color: var(--el-color-success-light-9);
}
</style>
