<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl"> {{ service.name }} </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-tabs type="border-card" class="">
            <!-- Панель Общая информация -->
            <el-tab-pane>
                <template #label>
                    <span class="custom-tabs-label">
                        <el-icon><Memo/></el-icon>
                        <span> Общая информация</span>
                    </span>
                </template>
                <div class="grid lg:grid-cols-6 grid-cols-1 divide-x">
                    <div class="p-4 col-span-4">
                        <el-descriptions :column="2" border>
                            <el-descriptions-item label="Классификация" v-if="service.classification_id !== null">
                                {{ service.classification.name }}
                            </el-descriptions-item>
                            <el-descriptions-item label="Услуга">{{ service.name }}</el-descriptions-item>
                            <el-descriptions-item label="Цена">{{ service.price }} ₽</el-descriptions-item>
                            <el-descriptions-item label="Длительность">{{ service.duration }} мин</el-descriptions-item>
                            <el-descriptions-item label="Данные">{{ service.data }}</el-descriptions-item>
                            <el-descriptions-item label="Шаблон">{{ service.template }}</el-descriptions-item>
                            <el-descriptions-item label="Ссылка">{{ service.slug }}</el-descriptions-item>
                        </el-descriptions>
                        <DisplayedShow :displayed="service" />
                    </div>

                    <div class="p-4 col-span-2 flex">
                        <DisplayedImage :image="$props.image" :icon="$props.icon" />
                    </div>
                </div>
            </el-tab-pane>
            <!-- Панель Описание -->
            <DescriptionPanel :text="service.text"/>
            <!-- Панель Галерея -->
            <GalleryPanel
                :add="gallery_data.add"
                :del="gallery_data.del"
                :set="gallery_data.set"
                :gallery="gallery_data.gallery"
            />
            <!-- Панель Персонал -->
            <EmployeePanel
                :attach="employee_data.attach"
                :detach="employee_data.detach"
                :employees="service.employees"
                :out_employees="employee_data.out_employees"
            />
            <!-- Панель Расходники -->
            <ConsumablesPanel />

            <!-- Панель Примеры работ -->
            <ExamplesPanel
                :examples="example_data.examples"
                :new_example="example_data.new_example"
            />
            <!-- Панель Отзывы -->
            <ReviewPanel :reviews="reviews" />
            <!-- Панель Доп.услуги -->
            <ExtraPanel
                :extras="extra_data.extras"
                :errors="errors"
                :add="extra_data.add"
                :service_id="service.id"
            />
        </el-tabs>
    </div>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.service.active" type="success" @click="handleToggle">Показывать</el-button>
            <el-button v-if="$props.service.active" type="warning" @click="handleToggle">Скрыть из показа</el-button>
        </div>
    </div>


    <!-- Dialog Delete -->
    <el-dialog v-model="$data.dialogDelete" title="Удалить запись" width="400" center>
        <div class="font-medium text-md mt-2">
            Вы уверены, что хотите удалить service?
        </div>
        <div class="text-red-600 text-md mt-2">
            Восстановить данные будет невозможно!
        </div>
        <template #footer>
            <div class="dialog-footer">
                <el-button @click="$data.dialogDelete = false">Отмена</el-button>
                <el-button type="danger" @click="removeItem($data.routeDestroy)">
                    Удалить
                </el-button>
            </div>
        </template>
    </el-dialog>
</template>

<script lang="ts" setup>
import {Head, Link} from '@inertiajs/vue3'
import {reactive, ref} from 'vue'
import {Plus} from '@element-plus/icons-vue'
import {router} from "@inertiajs/vue3";
import {func} from '@/func.js'
import type {UploadProps, UploadUserFile, UploadRawFile} from 'element-plus'
import DisplayedShow from '@/Components/DisplayedShow.vue'
import DisplayedImage from '@/Components/DisplayedImage.vue'

///Панели
import DescriptionPanel from './Panels/Description.vue'
import GalleryPanel from './Panels/Gallery.vue'
import EmployeePanel from './Panels/Employee.vue'
import ConsumablesPanel from './Panels/Consumables.vue'
import ExamplesPanel from './Panels/Examples.vue'
import ExtraPanel from './Panels/Extra.vue'
import ReviewPanel from './Panels/Review.vue'

const props = defineProps({
    service: Object,
    edit: String,
    image: String,
    icon: String,
    errors: Object,

    title: {
        type: String,
        default: 'Карточка услуги',
    },
    gallery_data: Array,
    employee_data: Array,

    toggle: String,
    class_name: String,

    example_data: Array,

    reviews: Array,
    extra_data: Array,
});


function handleToggle() {
    router.post(props.toggle);
}


function newExtra() {
    alert('Добавить');
}
</script>

<script lang="ts">
import {Head, Link, router} from '@inertiajs/vue3'
import Layout from '@/Components/Layout.vue'
import {ref} from "vue";

export default {
    layout: Layout,
    methods: {
        goEdit() {
            router.get(this.$props.edit);
        },
        handleToggleRow(index, row) {
            router.post(row.toggle);
        },
        handleEditRow(index, row) {
            router.get(row.edit);
        },
        routeClick(row) {
            router.get(row.url)
        },
        handleDelete(index, row) {
            this.$data.dialogDelete = true;
            this.$data.routeDestroy = row.destroy;
        },
        removeItem(_route) {
            if (_route !== null) {
                router.visit(_route, {
                    method: 'delete'
                });
                this.$data.dialogDelete = false;
                this.$data.routeDestroy = null;
            }
        },
    },
    data() {
        return {
            //csrf: document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
            dialogDelete: false,
            routeDestroy: null,
        }
    },
}

</script>

<style>

</style>
