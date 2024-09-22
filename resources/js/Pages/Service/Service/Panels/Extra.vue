<template>
    <el-tab-pane>
        <template #label>
            <span class="custom-tabs-label">
              <el-icon><Box/></el-icon>
              <span> Доп.услуги</span>
            </span>
        </template>
        <div class="mb-5">
            <el-table #default="mainscope"
                      :data="extras"
                      style="width: 100%; cursor: pointer;"
                      :row-class-name="tableRowClassName"
                      @row-click="router.get(mainscope.row.url)"
            >
                <el-table-column label="Иконка" width="120">
                    <template #default="scope">
                        <el-image style="width: 40px; height: 40px" :src="scope.row.icon" fit="fill"/>
                    </template>
                </el-table-column>
                <el-table-column label="Название" prop="name"/>
                <el-table-column label="Цена" prop="price" width="120"/>
                <el-table-column label="Длительность" prop="duration" width="120"/>
                <el-table-column label="Видимость" width="120">
                    <template #default="scope">
                        <Active :active="scope.row.active" />
                    </template>
                </el-table-column>
                <el-table-column label="Описание" prop="description" show-overflow-tooltip/>
                <el-table-column label="Действия" align="right">
                    <template #default="scope">
                        <el-button
                            size="small"
                            type="primary"
                            @click.stop="handleUp(scope.row)">
                            <el-icon>
                                <Top/>
                            </el-icon>
                        </el-button>
                        <el-button
                            size="small"
                            type="primary"
                            @click.stop="handleDown(scope.row)">
                            <el-icon>
                                <Bottom/>
                            </el-icon>
                        </el-button>
                        <el-button v-if="scope.row.active"
                                   size="small"
                                   type="warning"
                                   @click.stop="router.post(scope.row.toggle)">
                            Hide
                        </el-button>
                        <el-button v-if="!scope.row.active"
                                   size="small"
                                   type="success"
                                   @click.stop="router.post(scope.row.toggle)">
                            Show
                        </el-button>
                        <el-button
                            size="small"
                            @click.stop="handleEdit(scope.row)">
                            Edit
                        </el-button>
                        <el-button
                            size="small"
                            type="danger"
                            @click.stop="handleDelete(scope.row)"
                        >
                            Delete
                        </el-button>
                    </template>
                </el-table-column>

            </el-table>
        </div>
        <el-button @click="newExtra">Добавить</el-button>
    </el-tab-pane>

    <el-dialog v-model="dialogExtra" title="Добавить услугу" width="800" center>
        <el-form :model="form">
            <div class="grid grid-cols-2">
                <div class="p-4">
                    <el-form-item label="Услуга" :required="true">
                        <el-input v-model="form.name"/>
                        <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
                    </el-form-item>
                    <el-form-item label="Цена">
                        <el-input v-model="form.price" @input="handleInteger">
                            <template #append>₽</template>
                        </el-input>
                        <div v-if="errors.price" class="text-red-700">{{ errors.price }}</div>
                    </el-form-item>
                    <el-form-item label="Длительность">
                        <el-input v-model="form.duration" @input="handleIntegerDuration">
                            <template #append>мин</template>
                        </el-input>
                        <div v-if="errors.price" class="text-red-700">{{ errors.price }}</div>
                    </el-form-item>
                    <el-form-item label="Font Awesome">
                        <el-input v-model="form.awesome"/>
                        <div v-if="errors.awesome" class="text-red-700">{{ errors.awesome }}</div>
                    </el-form-item>
                    <el-form-item label="Описание">
                        <el-input v-model="form.description" type="textarea" rows="3"/>
                        <div v-if="errors.description" class="text-red-700">{{ errors.description }}</div>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <UploadImageFile
                        label="Иконка"
                        :image="form.icon"
                        @selectImageFile="selectIcon"
                        :key="routeSubmit"
                    />
                </div>
            </div>

            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
        </el-form>
    </el-dialog>


    <!-- Dialog Delete -->
    <el-dialog v-model="dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить Доп.услугу?
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
</template>

<script lang="ts" setup>
import {reactive, ref} from "vue";
import {func} from '/resources/js/func.js'
import {router} from "@inertiajs/vue3";
import DialogDeleteEntity from '/resources/js/Components/DialogDeleteEntity.vue'
import UploadImageFile from '@/Components/UploadImageFile.vue'
import Active from '/resources/js/Components/Elements/Active.vue'

interface IRow {
    active: number
}

const tableRowClassName = ({row, rowIndex}: { row: IRow }) => {
    if (row.active === 0) {
        return 'warning-row'
    }
    return ''
}

const dialogDelete = ref(false)
const dialogExtra = ref(false)
const routeDestroy = ref(null)
const routeSubmit = ref(null)

const props = defineProps({
    extras: Array,
    add: String,
    errors: Object,
    service_id: Number,
})

const form = reactive({
    service_id: props.service_id,
    name: null,
    description: null,
    price: null,
    duration: null,
    awesome: null,
    icon: null,
    clear_icon: false,
    _method: 'post',
})

function handleDelete(row) {
    routeDestroy.value = row.destroy;
    dialogDelete.value = true;
}
function removeItem(val) {
    if (val !== null) {
        router.delete(val);
        dialogDelete.value = false;
    }
}

function handleInteger(val) {
    form.price = func.MaskInteger(val, 9)
}

function handleIntegerDuration(val) {
    form.duration = func.MaskInteger(val, 9)
}
function selectIcon(val) {
    form.clear_icon = val.clear_file
    form.icon = val.file
}

function onSubmit() {
   // router.post(routeSubmit.value, form);
    router.visit(routeSubmit.value, {
        method: "post",
        data: form,
        preserveState: true,
        preserveScroll: true,
        onSuccess: page => {
            dialogExtra.value = false
        },
    })
}

function __removeItem(_route) {
    if (_route !== null) {
        router.visit(_route, {
            method: 'delete'
        });
        dialogDelete.value = false;
        routeDestroy.value = null;
    }
}

function newExtra() {
    form.name = null
    form.description = null
    form.price = null
    form.duration = null
    form.awesome = null
    form.icon = null
    form._method = 'post'
    routeSubmit.value = props.add
    dialogExtra.value = true
}

function handleEdit(row) {
    form.name = row.name
    form.description = row.description
    form.price = row.price
    form.duration = row.duration
    form.awesome = row.awesome
    console.log(row.icon)
    form.icon = row.icon
    form._method = 'put'
    routeSubmit.value = row.update
    dialogExtra.value = true
}

function handleUp(row) {
    router.post(row.up);
}
function handleDown(row) {
    router.post(row.down);
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
