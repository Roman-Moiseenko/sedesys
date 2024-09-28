<template>
    <el-tab-pane>
        <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><Service/></el-icon>
                      <span> Персонал</span>
                    </span>
        </template>
        <div class="mb-5">
            <el-table :data="employees"
                      style="width: 100%;"
            >
                <el-table-column label="Персонал" width="250">
                    <template #default="scope">
                        {{ func.fullName(scope.row.fullname) }}
                    </template>
                </el-table-column>
                <el-table-column label="Специализация" width="250">
                    <template #default="scope">
                        <el-tag class="mr-1" v-for="item in scope.row.specializations">{{ item.name }}</el-tag>
                    </template>
                </el-table-column>
                <el-table-column label="Стаж" width="250">
                    <template #default="scope">
                        {{ func.experience(scope.row.experience_year) }}
                    </template>
                </el-table-column>
                <el-table-column label="Доп. наценка" width="250">
                    <template #default="scope">
                        {{ func.price(scope.row.pivot.extra_cost) }}
                    </template>
                </el-table-column>
                <el-table-column label="Действия" width="250">
                    <template #default="scope">
                        <el-button type="warning" @click.stop="detachEmployee(scope.row.id)">Detach</el-button>
                    </template>
                </el-table-column>

            </el-table>
        </div>

        <el-button type="success" plain @click="dialogEmployee = true">
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
                <el-form-item label="Дополнительная наценка" class="mb-3">
                    <el-input v-model="formEmployee.extra_cost" :formatter="(value) => func.MaskInteger(value)" placeholder=""
                              class="mb-3">
                        <template #append>₽</template>
                    </el-input>
                </el-form-item>
                <el-button type="info" plain @click="dialogEmployee = false">
                    Отмена
                </el-button>
                <el-button type="primary" @click="attachEmployee">Сохранить</el-button>
                <span v-if="dialogSave" class="text-lime-500 text-sm ml-3">Сохранено</span>
            </el-form>
        </el-dialog>
    </el-tab-pane>
</template>

<script lang="ts" setup>
import {reactive, ref} from "vue";
import {func} from '@/func.js'
import {router} from "@inertiajs/vue3";

const dialogEmployee = ref(false)
const dialogSave = ref(false)

const props = defineProps({
    service_id: Number,
    employees: Array,
    out_employees: Array,
})
const formEmployee = reactive({
    employee_id: null,
    extra_cost: null
});
function attachEmployee() {
    if (formEmployee.employee_id === null) return;
    router.post(route('admin.service.service.attach', {service: props.service_id}), formEmployee);
    dialogEmployee.value = false;
}
function detachEmployee(val) {
    router.post(route('admin.service.service.detach', {service: props.service_id}), {employee_id: val})
}


</script>

<script lang="ts">
export default {
    name: "Employee"
}
</script>

<style scoped>

</style>
