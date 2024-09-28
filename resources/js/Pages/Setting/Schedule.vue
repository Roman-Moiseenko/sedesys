<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">{{ title }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <h2 class="font-medium text-lg mb-3">График работы</h2>

                    <div class="demo-time-range">
                        <el-time-select
                            v-model="form.begin_work"
                            style="width: 240px"
                            :max-time="form.end_work"
                            class="mr-4"
                            placeholder="Start time"
                            start="00:00"
                            step="00:15"
                            end="14:00"
                        />
                        <el-time-select
                            v-model="form.end_work"
                            style="width: 240px"
                            :min-time="form.begin_work"
                            placeholder="End time"
                            start="12:00"
                            step="00:15"
                            end="24:00"
                        />
                    </div>
                    <el-form-item label="Дата отсчета посменно" label-position="top" class="mt-3">
                        <el-date-picker
                            v-model="form.begin_x_date"
                            type="date"
                            placeholder="Дата отсчета посменно"
                        />

                    </el-form-item>

                </div>
                <div class="p-4">

                </div>
                <div class="p-4">

                </div>
            </div>
            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
import {reactive} from 'vue'
import {Head, router} from "@inertiajs/vue3";
import {func} from "/resources/js/func.js"

const props = defineProps({
    errors: Object,
    schedule: Object,
    title: {
        type: String,
        default: 'Настройки расписания',
    }
});

const form = reactive({
    slug: 'schedule',
    begin_x_date: props.schedule.begin_x_date,
    begin_work: props.schedule.begin_work,
    end_work: props.schedule.end_work,
    holiday: props.schedule.holiday,

})

function onSubmit() {

    form.begin_x_date = func.date(form.begin_x_date);
    router.put(route('admin.setting.update'), form)
}

</script>

