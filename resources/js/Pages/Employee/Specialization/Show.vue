<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ specialization.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
            <div class="p-4">
                <div class="flex flex-col justify-center items-center lg:items-start mt-4">
                    <div class="truncate sm:whitespace-normal flex items-center">
                        Специализация&nbsp;<span class="font-medium ml-6">{{ $props.specialization.name}}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Ссылка&nbsp;<span class="font-medium ml-6">{{ $props.specialization.slug}}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Страница (H1)&nbsp;<span class="font-medium ml-6">{{ $props.specialization.meta.h1}}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Заголовок&nbsp;<span class="font-medium ml-6">{{ $props.specialization.meta.title}}</span>
                    </div>
                    <div class="truncate sm:whitespace-normal flex items-center mt-2">
                        Описание&nbsp;<span class="font-medium ml-6">{{ $props.specialization.meta.description}}</span>
                    </div>
                </div>
            </div>
            <div class="p-4">
                <h2 class="font-medium mb-3">Изображение для каталога</h2>
                <div class="lg:w-56 lg:h-56 image-fit relative">
                    <el-image
                        :src="$props.image"
                        :zoom-rate="1.2"
                        :max-scale="3"
                        :min-scale="0.2"
                        :preview-src-list="[$props.image]"
                        :initial-index="0"
                        fit="cover"
                    />
                </div>
            </div>
            <div class="p-4">
                <h2 class="font-medium mb-3">Иконка для меню</h2>
                <div class="lg:w-56 lg:h-56 image-fit relative">
                    <el-image
                        :src="$props.icon"
                        :zoom-rate="1.2"
                        :max-scale="1"
                        :min-scale="0.2"
                        :preview-src-list="[$props.icon]"
                        :initial-index="0"
                        fit="cover"
                    />
                </div>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!$props.specialization.active" type="success" @click="handleToggle">Показывать в меню/каталогах</el-button>
            <el-button v-if="$props.specialization.active" type="warning" @click="handleToggle">Скрыть из показа</el-button>
        </div>
    </div>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <h2 class="font-medium text-lg mb-3">Специалисты:</h2>
        <el-form :model="form" label-width="auto">
            <div v-for="employee in employees">
                <el-checkbox v-model="form.employees" :label="employee.fullname"
                             type="checkbox" :checked="employee.checked"
                             :value="employee.id"
                />
            </div>
            <div class="mt-4">
                <el-button type="primary" @click="onSubmit">Сохранить</el-button>
            </div>
            <div v-if="form.isDirty">Изменения не сохранены</div>
        </el-form>
    </div>
</template>

<script lang="ts" setup>
import {Head, Link, router} from '@inertiajs/vue3'
    import {reactive} from "vue";

    const props = defineProps({
        specialization: Object,
        edit: String,
        title: {
            type: String,
            default: 'Карточка специализации',
        },
        toggle: String,
        attach: String,
        image: String,
        icon: String,
        employees: Object,

    });
    const form = reactive({
        id: props.specialization.id,
        employees: [],
    })
function onSubmit() {
    router.post(props.attach, form)
}


</script>
<script lang="ts">
    import { router } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'

    export default {
        layout: Layout,
        methods: {
            goEdit() {
                router.get(this.$props.edit);
            },
            handleToggle(val) {
                router.post(this.$props.toggle);
            }
        },
    }

</script>

<style>

</style>
