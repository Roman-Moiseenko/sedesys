<template>
    <el-tab-pane>
        <template #label>
            <span class="custom-tabs-label">
                <el-icon><Service/></el-icon>
                <span> Специалисты</span>
            </span>
        </template>
        <el-table :data="employees"
                  style="width: 100%;"
        >
            <el-table-column label="Персонал" width="250">
                <template #default="scope">
                    {{ func.fullName(scope.row.fullname) }}
                </template>
            </el-table-column>

            <el-table-column label="Стаж" width="250">
                <template #default="scope">
                    {{ func.experience(scope.row.experience_year) }}
                </template>
            </el-table-column>
            <el-table-column label="Действия" width="250">
                <template #default="scope">
                    <el-button type="warning" @click.stop="detachEmployee(scope.row)">Detach</el-button>
                </template>
            </el-table-column>

        </el-table>
        <el-button type="success" plain @click="dialogEmployee = true" class="mt-3">
            <el-icon>
                <Service/>
            </el-icon>&nbsp;
            Добавить Персонал
        </el-button>
        <!--Dialog-->
        <el-dialog v-model="dialogEmployee" width="400" class="p-4" center>
            <el-form :model="formEmployee" class="mt-3">
                <el-form-item label="Персонал">
                    <el-select v-model="formEmployee.employee_id">
                        <el-option v-for="item in out_employees" :value="item.id" :key="item.id"
                                   :label="func.fullName(item.fullname)"/>
                    </el-select>
                </el-form-item>

                <el-button type="info" plain @click="dialogEmployee = false">
                    Отмена
                </el-button>
                <el-button type="primary" @click="attachEmployee">Сохранить</el-button>

            </el-form>
        </el-dialog>

    </el-tab-pane>
</template>

<script lang="ts" setup>
import {defineProps, reactive, ref} from "vue";
import {func} from '@/func.js'
import {router} from "@inertiajs/vue3";

const dialogEmployee = ref(false)
const props = defineProps({
    specialization_id: Number,
    employees: Object,
    out_employees: Object,

})
const formEmployee = reactive({
    employee_id: null,
    extra_cost: null
});
function attachEmployee() {
    if (formEmployee.employee_id === null) return;
    router.post(route('admin.employee.specialization.attach', {specialization: props.specialization_id}), formEmployee);
    dialogEmployee.value = false;
}
function detachEmployee(row) {
    router.post(route('admin.employee.specialization.detach', {specialization: props.specialization_id}), {employee_id: row.id})
}
</script>
