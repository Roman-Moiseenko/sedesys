<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новую классификацию</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <el-tabs type="border-card" class="mb-4">
                <DisplayedFieldsPanel
                    :errors="errors"
                    :templates="templates"
                    :tiny_api="tiny_api"
                    v-model:displayed="form.displayed"
                >
                    <!-- Доп.поля в 1ю секцию 1й панели -->
                    <el-form-item label="Родительская категория" :rules="{required: true}">
                        <el-select v-model="form.parent_id" placeholder="Select" style="width: 240px">
                            <el-option v-for="item in classifications" :key="item.value" :label="item.label" :value="item.value"/>
                        </el-select>
                        <div v-if="errors.parent_id" class="text-red-700">{{ errors.parent_id }}</div>
                    </el-form-item>
                </DisplayedFieldsPanel>
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
    import {useStore} from '/resources/js/store.js'
    import DisplayedFieldsPanel from '@/Components/Displayed/Fields.vue'

    const store = useStore();
    const props = defineProps({
        errors: Object,
        route: String,
        title: {
            type: String,
            default: 'Создание классификации',
        },
        classifications: Array,
        templates: Array,
        tiny_api: String,
    });
    const form = reactive({
        displayed: func.displayedInfo(),

        parent_id: null,
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
