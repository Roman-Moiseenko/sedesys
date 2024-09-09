<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">{{ title }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto" style="max-width: 500px">

            <el-form-item label="Длина кода купона">
                <el-input-number v-model="form.coupon_length" placeholder=""/>
                <div v-if="errors.coupon_length" class="text-red-700">{{ errors.coupon_length }}</div>
            </el-form-item>
            <el-form-item label="Использовать строчные символы">
                <el-checkbox v-model="form.coupon_full"/>
            </el-form-item>

            <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
    </div>
</template>


<script setup>
    import {reactive} from 'vue'
    import {router} from "@inertiajs/vue3";
    import {func} from "/resources/js/func.js"

    const props = defineProps({
        errors: Object,
        route: String,
        discount: Object,
        title: {
            type: String,
            default: 'Настройки скидок',
        }
    });

    const form = reactive({
        slug: 'discount',
        coupon_length: props.discount.coupon_length,
        coupon_full: props.discount.coupon_full,

        /**
         * Добавить новые поля
         */
    })

    function onSubmit() {
        router.put(props.route, form)
    }

</script>
<script>
    import {Head} from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'
    export default {
        components: {
            Head,
        },
        layout: Layout,
    }
</script>
