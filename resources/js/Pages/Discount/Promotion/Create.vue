<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новую акцию</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <el-tabs type="border-card" class="mb-4">
                <el-tab-pane>
                    <template #label>
                    <span class="custom-tabs-label">
                        <el-icon><Present/></el-icon>
                        <span> Акция</span>
                    </span>
                    </template>
                    <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                        <div class="p-4">
                            <el-form-item label="Базовая скидка в %%" :rules="{required: true}">
                                <el-input-number v-model="form.discount" placeholder=""/>
                                <div v-if="errors.discount" class="text-red-700">{{ errors.discount }}</div>
                            </el-form-item>
                            <el-form-item label="Для акций по расписанию" label-position="top">
                                <el-date-picker
                                    v-model="form.range_at"
                                    type="daterange"
                                    range-separator="По"
                                    start-placeholder="Начало акции"
                                    end-placeholder="Конец акции"
                                />
                            </el-form-item>
                        </div>
                        <div class="p-4">
                            <el-form-item label="Ссылка условия акции" :rules="{required: true}">
                                <el-input v-model="form.condition_url"
                                          placeholder="без домена: /page/action-condition"/>
                                <div v-if="errors.condition_url" class="text-red-700">{{ errors.condition_url }}</div>
                            </el-form-item>
                            <el-form-item label="Описание">
                                <el-input v-model="form.description" placeholder="Выводится в виджетах" type="textarea"
                                          rows="4" maxlength="250" show-word-limit/>
                                <div v-if="errors.description" class="text-red-700">{{ errors.description }}</div>
                            </el-form-item>
                        </div>
                        <div class="p-4">

                        </div>
                    </div>
                </el-tab-pane>
                <DisplayedFieldsPanel
                    :errors="errors"
                    :templates="templates"
                    :tiny_api="tiny_api"
                    v-model:displayed="form.displayed"
                >
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
import DisplayedFieldsPanel from '@/Components/Displayed/Fields.vue'

const props = defineProps({
    errors: Object,
    route: String,
    title: {
        type: String,
        default: 'Создание Акции',
    },
    templates: Array,
    tiny_api: String,
});

const form = reactive({
    displayed: func.displayedInfo(),

    description: null,
    condition_url: null,
    start_at: null,
    finish_at: null,
    discount: null,
    range_at: [null, null],
})

///Блок сохранения и обновления=>
const isUnSave = ref(false)
watch(
    () => ({...form}),
    function (newValue, oldValue) {
        isUnSave.value = true
    },
    {deep: true}
);

function onSubmit() {
    if (form.range_at !== null && form.range_at.length === 2 && form.range_at[0] !== null)
        form.range_at = form.range_at.map(item => func.date(item));

    router.post(props.route, form)
}

</script>

