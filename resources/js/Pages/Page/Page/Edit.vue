<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ page.name }}</h1>
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
                    <el-form-item label="Родительская страница">
                        <el-select v-model="form.parent_id" placeholder="Select" style="width: 240px">
                            <el-option v-for="item in pages" :key="item.value" :label="item.label" :value="item.value"/>
                        </el-select>
                        <div v-if="errors.parent_id" class="text-red-700">{{ errors.parent_id }}</div>
                    </el-form-item>
                </DisplayedFieldsPanel>
            </el-tabs>

            <el-button type="primary" plain @click="onSubmit(false)" :disabled="!isUnSave">Сохранить</el-button>
            <el-button type="primary" @click="onSubmit(true)" :disabled="!isUnSave">Сохранить и Закрыть</el-button>
            <div v-if="isUnSave" class="text-red-700">Были внесены изменения, данные не сохранены</div>
        </el-form>
    </div>
</template>


<script lang="ts" setup>
import {reactive, ref, watch} from 'vue'
import {router, Head} from "@inertiajs/vue3";
import {func} from "/resources/js/func.js"
import DisplayedFieldsPanel from '@/Components/Displayed/Fields.vue'

const props = defineProps({
    errors: Object,
    route: String,
    page: Object,
    title: {
        type: String,
        default: 'Редактирование Страницы',
    },
    image: String,
    icon: String,
    templates: Array,
    pages: Array,
    tiny_api: String,
});
const form = reactive({
    parent_id: props.page.parent_id,
    displayed: func.displayedInfo(props.page, props.image, props.icon),
    _method: 'put',
    close: null
})

///Блок сохранения и обновления=>
const isUnSave = ref(false)
watch(
    () => ({ ...form }),
    function (newValue, oldValue) {
        isUnSave.value = true
    },
    {deep: true}
);
function onSubmit(val) {
    form.close = val
    router.visit(props.route, {
        method: 'post',
        data: form,
        preserveScroll: true,
        preserveState: true,
        onSuccess: page => {
            isUnSave.value = false
        }
    });
}
////<=

</script>
<script lang="ts">
import Layout from '@/Components/Layout.vue'

export default {
    layout: Layout,
}
</script>
