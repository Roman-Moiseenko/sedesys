<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">{{ func.fullName(user.fullname) }}</h1>

    <div class="mt-3 p-3 bg-white rounded-lg ">
        <div class="grid grid-cols-3 divide-x">
            <div class="p-2">
                <el-descriptions :column="1" border title="Контактные данные">
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon>
                                    <iphone/>
                                </el-icon>&nbsp;Телефон
                            </div>
                        </template>
                        {{ user.phone }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon>
                                    <Message/>
                                </el-icon>&nbsp;Email
                            </div>
                        </template>
                        {{ user.email }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon>
                                    <Location/>
                                </el-icon>&nbsp;Адрес
                            </div>
                        </template>
                        {{ user.address.address }}
                    </el-descriptions-item>
                    <el-descriptions-item>
                        <template #label>
                            <div class="items-center flex">
                                <el-icon>
                                    <Key/>
                                </el-icon>&nbsp;OAuth
                            </div>
                        </template>
                        <el-tag type="info" v-for="item in user.oauths">{{ item.network }}</el-tag>
                    </el-descriptions-item>
                </el-descriptions>
            </div>

            <div class="p-2">

            </div>

        </div>
        <div class="mt-3 flex flex-row">
            <el-button type="primary" @click="goEdit">Редактировать</el-button>
        </div>
    </div>

    <div class="mt-5 p-3 bg-white rounded-lg ">
        Данные о заказах клиента
    </div>
</template>

<script lang="ts" setup>
import {func} from '/resources/js/func.js'
import {Head, router} from '@inertiajs/vue3'

const props = defineProps({
    user: Object,
    title: {
        type: String,
        default: 'Карточка Клиента',
    }
})
function goEdit() {
    router.get(route('admin.user.user.edit', {user: props.user.id}));
}
</script>
