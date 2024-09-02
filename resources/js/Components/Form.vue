<template>
    <el-form :model="form" label-width="auto">

        <slot :scope="form"/>

        <el-button type="primary" plain @click="onSubmit(false)">Сохранить</el-button>
        <el-button type="primary" @click="onSubmit(true)">Сохранить и Закрыть</el-button>
        <div v-if="isUnSave === true" class="text-red-700">Были внесены изменения, данные не сохранены</div>
    </el-form>
</template>



<script lang="ts" setup>
import {router} from "@inertiajs/vue3";
import {ref, watch, reactive} from "vue";

//TODO https://programmersought.com/article/561511549001/
const isUnSave = ref(false)
const props = defineProps({
    modelForm: Object,
    route: String,
})
const emit = defineEmits(['update:modelForm']);
const form = reactive({...props.modelForm})

console.log(props.modelForm);
console.log('form', form);
watch(
    form,
    function (newValue, oldValue) {
        console.log(newValue);
        emit('update:modelForm', form);
    },
    {deep: true}
);

function onSubmit(val) {
    isUnSave.value = false
    form.close = val
    router.post(props.route, form);
}
</script>

<style scoped>

</style>
