<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">{{ title }}</h1>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-form :model="form" label-width="auto">
            <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                <div class="p-4">
                    <h2 class="font-medium text-lg mb-3">Данные об офисе</h2>
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

                    <el-form-item label="Время работы">
                        <el-input v-model="form.open_hours" placeholder="ПН-ПТ - 10:00-19:00"/>
                        <div v-if="errors.open_hours" class="text-red-700">{{ errors.open_hours }}</div>
                    </el-form-item>

                    <el-form-item label="Город" :rules="{required: true}">
                        <el-input v-model="form.city" placeholder="Город"/>
                        <div v-if="errors.city" class="text-red-700">{{ errors.city }}</div>
                    </el-form-item>
                    <el-form-item label="Адрес" :rules="{required: true}">
                        <el-input v-model="form.address" placeholder="Адрес"/>
                        <div v-if="errors.address" class="text-red-700">{{ errors.address }}</div>
                    </el-form-item>
                    <el-form-item label="Телефоны">
                        <el-select
                            v-model="form.phones"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            :reserve-keyword="false"
                            placeholder="Добавьте телефоны"
                        >
                            <el-option
                                v-for="item in form.phones"
                                :key="item"
                                :label="item"
                                :value="item"
                            />
                        </el-select>
                    </el-form-item>
                </div>
                <div class="p-4">
                    <h2 class="font-medium text-lg mb-3">Данные для Schema.org</h2>
                    <el-form-item label="Способы оплаты">
                        <el-input v-model="form.payment" placeholder="Перечислить через запятую"/>
                        <div v-if="errors.payment" class="text-red-700">{{ errors.payment }}</div>
                    </el-form-item>
                    <el-form-item label="Диапазон цен">
                        <el-input v-model="form.prices" placeholder="от и до в руб."/>
                        <div v-if="errors.prices" class="text-red-700">{{ errors.prices }}</div>
                    </el-form-item>
                    <el-form-item label="Рейтинг">
                        <el-input v-model="form.rating_value" placeholder="от 0 до 5, дробное число" @input="handleMaskRating"/>
                        <div v-if="errors.rating_value" class="text-red-700">{{ errors.rating_value }}</div>
                    </el-form-item>
                    <el-form-item label="Кол-во голосов">
                        <el-input v-model="form.rating_count" placeholder="больше 0" @input="handleMaskCount"/>
                        <div v-if="errors.rating_count" class="text-red-700">{{ errors.rating_count }}</div>
                    </el-form-item>
                    <el-form-item label="Ссылка на рейтинг">
                        <el-input v-model="form.rating_url" placeholder="Любой сторонний ресурс"/>
                        <div v-if="errors.rating_url" class="text-red-700">{{ errors.rating_url }}</div>
                    </el-form-item>

                    <el-form-item label="Бренд">
                        <el-input v-model="form.brand_name" placeholder=""/>
                        <div v-if="errors.brand_name" class="text-red-700">{{ errors.brand_name }}</div>
                    </el-form-item>
                    <el-form-item label="Альтернатива">
                        <el-select
                            v-model="form.brand_alternate"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            :reserve-keyword="false"
                            placeholder="Добавьте ваши бренды"
                        >
                            <el-option
                                v-for="item in form.brand_alternate"
                                :key="item"
                                :label="item"
                                :value="item"
                            />
                        </el-select>
                    </el-form-item>
                    <el-form-item label="Ссылки">
                        <el-select
                            v-model="form.brand_sameas"
                            multiple
                            filterable
                            allow-create
                            default-first-option
                            :reserve-keyword="false"
                            placeholder="Добавьте ссылки на соцсети"
                        >
                            <el-option
                                v-for="item in form.brand_sameas"
                                :key="item"
                                :label="item"
                                :value="item"
                            />
                        </el-select>
                    </el-form-item>

                </div>
            </div>
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
        open_hours: props.office.open_hours,

        city: props.office.city,
        address: props.office.address,
        phones: props.office.phones,

        payment: props.office.payment,
        prices: props.office.prices,
        rating_value: props.office.rating_value,
        rating_count: props.office.rating_count,
        rating_url: props.office.rating_url,

        brand_name: props.office.brand_name,
        brand_alternate: props.office.brand_alternate,
        brand_sameas: props.office.brand_sameas,

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
    function handleMaskRating(val) {
        form.rating_value = func.MaskFloat(val);
    }
    function handleMaskCount(val) {
        form.rating_count = func.MaskInteger(val, 6);
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
