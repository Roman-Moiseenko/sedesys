<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">Добавить новую услугу</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <el-tabs type="border-card" class="mb-4">
                <el-tab-pane>
                    <template #label>
                        <span class="custom-tabs-label">
                            <el-icon><User/></el-icon>
                            <span> Услуга</span>
                        </span>
                    </template>
                    <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                        <div class="p-4">
                            <el-form-item label="Классификация">
                                <el-select v-model="form.classification_id" placeholder="Select" style="width: 240px">
                                    <el-option v-for="item in classifications" :key="item.value" :label="item.label" :value="item.value"/>
                                </el-select>
                                <div v-if="errors.classification_id" class="text-red-700">{{ errors.classification_id }}</div>
                            </el-form-item>

                            <el-form-item label="Цена">
                                <el-input v-model="form.price" placeholder="В рублях" @input="handleMaskPrice">
                                    <template #append>₽</template>
                                </el-input>
                                <div v-if="errors.price" class="text-red-700">{{ errors.price }}</div>
                            </el-form-item>
                            <el-form-item label="Длительность">
                                <el-input v-model="form.duration" placeholder="В минутах" @input="handleMaskDuration">
                                    <template #append>мин</template>
                                </el-input>
                                <div v-if="errors.duration" class="text-red-700">{{ errors.duration }}</div>
                            </el-form-item>

                        </div>
                        <div class="p-4">
                            <el-form-item label="Опции">
                                <el-input v-model="form.data" placeholder="В формате JSON [{}]" :rows="5" type="textarea"/>
                                <div v-if="errors.data" class="text-red-700">{{ errors.data }}</div>
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
            default: 'Создание услуги',
        },
        classifications: Array,
        templates: Array,
        tiny_api: String,
    });

    const form = reactive({
        classification_id: null,
        displayed: func.displayedInfo(null),
        price: null,
        duration: null,
        data: null,
    })

    function handleMaskPrice(val) {
        form.price = func.MaskInteger(val);
    }
    function handleMaskDuration(val) {
        form.duration = func.MaskInteger(val);
    }
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
    import Editor from '@tinymce/tinymce-vue'

    export default {
        components: {
            'editor': Editor,
        },
        layout: Layout,
    }
</script>
