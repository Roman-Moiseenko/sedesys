<template>
    <el-tab-pane>
        <template #label>
            <span class="custom-tabs-label">
              <el-icon><Box/></el-icon>
              <span> Доп.услуги</span>
            </span>
        </template>
        <div class="mb-5">
            <el-table
                      :data="extras"
                      style="width: 100%; cursor: pointer;"
                      :row-class-name="tableRowClassName"
                      @row-click="rowClick"
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
                                   @click.stop="handleToggle(scope.row)">
                            Hide
                        </el-button>
                        <el-button v-if="!scope.row.active"
                                   size="small"
                                   type="success"
                                   @click.stop="handleToggle(scope.row)">
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
                            @click.stop="handleDeleteEntity(scope.row)"
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
                        <el-input v-model="form.price" :formatter="(val) => func.MaskInteger(val, 9)">
                            <template #append>₽</template>
                        </el-input>
                        <div v-if="errors.price" class="text-red-700">{{ errors.price }}</div>
                    </el-form-item>
                    <el-form-item label="Длительность">
                        <el-input v-model="form.duration" :formatter="(val) => func.MaskInteger(val, 9)">
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

    <DeleteEntityModal name_entity="доп.услугу" />
</template>

<script lang="ts" setup>
import {inject, reactive, ref} from "vue";
import {func} from '/resources/js/func.js'
import {router} from "@inertiajs/vue3";
import DialogDeleteEntity from '/resources/js/Components/DialogDeleteEntity.vue'
import UploadImageFile from '@/Components/UploadImageFile.vue'
import Active from '/resources/js/Components/Elements/Active.vue'

interface IRow {
    active: number
}
const $delete_entity = inject("$delete_entity")
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
function rowClick(row){
    router.get(route('admin.service.extra.show', {extra: row.id}))
}
function handleToggle(row) {
    router.post(route('admin.service.extra.toggle', {extra: row.id}))
}
function handleDeleteEntity(row) {
    $delete_entity.show(route('admin.service.extra.destroy', {extra: row.id}));
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
function newExtra() {
    form.name = null
    form.description = null
    form.price = null
    form.duration = null
    form.awesome = null
    form.icon = null
    form._method = 'post'
    routeSubmit.value = route('admin.service.extra.store')
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
    routeSubmit.value = route('admin.service.extra.update', {extra: row.id})
    dialogExtra.value = true
}
function handleUp(row) {
    router.post(route('admin.service.extra.up', {extra: row.id}));
}
function handleDown(row) {
    router.post(route('admin.service.extra.down', {extra: row.id}));
}
</script>
