<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Редактировать {{ service.name }}</h1>
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

            <el-button type="primary" plain @click="onSubmit(false)" :disabled="!isUnSave">Сохранить</el-button>
            <el-button type="primary" @click="onSubmit(true)" :disabled="!isUnSave">Сохранить и Закрыть</el-button>
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
        service: Object,
        title: {
            type: String,
            default: 'Редактирование услуги',
        },
        image: String,
        icon: String,
        classifications: Array,
        templates: Array,
        tiny_api: String,
    });
    const form = reactive({
        displayed: func.displayedInfo(props.service, props.image, props.icon),

        classification_id: props.service.classification_id,
        price: props.service.price,
        duration: props.service.duration,
        data: props.service.data,
        close: null,
        _method: 'put',
    })

    function handleMaskPrice(val) {
        form.price = func.MaskInteger(val);
    }
    function handleMaskDuration(val) {
        form.duration = func.MaskInteger(val);
    }
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
