<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новую специальность</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <el-tabs type="border-card" class="mb-4">
                <DisplayedFieldsPanel
                    :errors="errors"
                    :templates="templates"
                    :tiny_api="tiny_api"
                    v-model:displayed="form.displayed"
                />
                <el-tab-pane>
                    <template #label>
                    <span class="custom-tabs-label">
                        <el-icon><User/></el-icon>
                        <span> Специалисты</span>
                    </span>
                    </template>
                    <div class="grid lg:grid-cols-4 grid-cols-1 divide-x">
                        <div v-for="employee in employees" class="p-2">
                            <el-checkbox v-model="form.employees" :label="employee.fullname"
                                         type="checkbox" :key="employee.id"
                                         :value="employee.id"
                            />
                        </div>
                    </div>
                </el-tab-pane>
            </el-tabs>

            <el-button type="primary" @click="onSubmit" :disabled="!isUnSave">Сохранить</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
    import {Head, router} from '@inertiajs/vue3'
    import {reactive, ref, watch} from 'vue'
    import {func} from "/resources/js/func.js"
    import DisplayedFieldsPanel from '@/Components/Displayed/Fields.vue'

    const props = defineProps({
        errors: Object,
        route: String,
        title: {
            type: String,
            default: 'Создание новой специальности',
        },
        employees: Array,
        templates: Array,
        tiny_api: String,
    });

    const form = reactive({
        displayed: func.displayedInfo(),

        employees: [],
    })

    function onSubmit() {
        router.post(props.route, form)
    }
    ///Блок сохранения и обновления=>
    const isUnSave = ref(false)
    watch(
        () => ({...form}),
        function (newValue, oldValue) {
            isUnSave.value = true
        },
        {deep: true}
    );

</script>
<script lang="ts">
    import Layout from '@/Components/Layout.vue'

    export default {
        layout: Layout,
    }
</script>
