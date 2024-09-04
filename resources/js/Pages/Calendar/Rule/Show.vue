<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ rule.name }}  </h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid grid-cols-1 divide-x">
            <div class="p-4">
                <el-descriptions :column="2" border>
                    <el-descriptions-item label="Название">{{ rule.name }}</el-descriptions-item>
                    <el-descriptions-item label="Периодичность">{{ rule.regularity }}</el-descriptions-item>
                    <el-descriptions-item label="Услуги">
                        <el-tag type="" v-for="item in rule.services" class="mr-1">{{item.name}}</el-tag>
                    </el-descriptions-item>
                    <el-descriptions-item label="Персонал">
                        <el-tag type="success" v-for="item in rule.employees" class="mr-1">{{item.name}}</el-tag>
                    </el-descriptions-item>
                    <el-descriptions-item label="Макс.одновременно">{{ rule.name }}</el-descriptions-item>
                </el-descriptions>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!rule.active" type="success" @click="handleToggle">Показывать на сайте
            </el-button>
            <el-button v-if="rule.active" type="warning" @click="handleToggle">Скрыть из показа
            </el-button>
        </div>
    </div>

</template>

<script lang="ts" setup>
    import { Head, Link } from '@inertiajs/vue3'

    const props = defineProps({
        rule: Object,
        edit: String,
        title: {
            type: String,
            default: 'Карточка rule',
        },
        /**
         * Задать props
         */
    });
    console.log(props.rule.services);
    /**
     * Методы
     */


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
                router.post(this.$props.rule.toggle);
            }
        },
    }

</script>

<style>

</style>
