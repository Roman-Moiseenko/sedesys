<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">{{ title }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto" style="max-width: 500px">

            <el-form-item label="Название" :rules="{required: true}">
                <el-input v-model="form.name" placeholder="Название/Бренд"/>
                <div v-if="errors.name" class="text-red-700">{{ errors.name }}</div>
            </el-form-item>

            <el-form-item label="Долгота" :rules="{required: true}">
                <el-input v-model="form.longitude" placeholder="Longitude" @input="handleMaskLongitude"/>
                <div v-if="errors.longitude" class="text-red-700">{{ errors.longitude }}</div>
            </el-form-item>
            <el-form-item label="Широта" :rules="{required: true}">
                <el-input v-model="form.latitude" placeholder="Latitude" @input="handleMaskLatitude"/>
                <div v-if="errors.latitude" class="text-red-700">{{ errors.latitude }}</div>
            </el-form-item>

            <el-form-item label="Адрес" :rules="{required: true}">
                <el-input v-model="form.address" placeholder="Адрес"/>
                <div v-if="errors.address" class="text-red-700">{{ errors.address }}</div>
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
        office: Object,
        title: {
            type: String,
            default: 'Настройки Офиса',
        }
    });

    const form = reactive({
        slug: 'office',
        name: props.office.name,
        longitude: props.office.longitude,
        latitude: props.office.latitude,

        address: props.office.address,

        /**
         * Добавить новые поля
         */
    })

    function handleMaskLongitude(val) {
        form.longitude = func.MaskFloat(val);
    }
    function handleMaskLatitude(val) {
        form.latitude = func.MaskFloat(val);
    }
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
