<template>
    <Head><title>{{ title }}</title></Head>
    <h1 class="font-medium text-xl">Отзыв на {{ review.service.name }}</h1>

    <div class="mt-3 p-3 bg-white rounded-lg">
        <div class="grid grid-cols-1 divide-x">
            <div class="p-4">
                <el-descriptions :column="2" border>
                    <el-descriptions-item label="Клиент">
                        <span v-if="review.user_id == null">{{ review.external.user_name }} ( {{ review.external.external }})</span>
                        <span v-else>{{ func.fullName(review.user.fullname) }}</span>
                    </el-descriptions-item>
                    <el-descriptions-item label="Дата">{{ review.created_at}}</el-descriptions-item>
                    <el-descriptions-item label="Услуга">{{ review.service.name }}</el-descriptions-item>
                    <el-descriptions-item label="Персонал">
                        <span v-if="review.employee_id != null">{{ func.fullName(review.employee.fullname) }}</span>
                    </el-descriptions-item>
                    <el-descriptions-item label="Рейтинг">{{ review.rating}}</el-descriptions-item>

                    <el-descriptions-item label="Отзыв">{{ review.text}}</el-descriptions-item>
                </el-descriptions>
            </div>
        </div>
        <div class="mt-3 flex flex-row">
            <el-button v-if="review.user_id == null" type="primary" @click="goEdit">Редактировать</el-button>
            <el-button v-if="!review.active" type="success" @click="handleToggle">Показывать на сайте
            </el-button>
            <el-button v-if="review.active" type="warning" @click="handleToggle">Скрыть из показа
            </el-button>
        </div>
    </div>
    <div v-if="gallery" class="mt-3 p-3 bg-white rounded-lg">
        <span v-for="item in gallery" class="mr-2 mt-1">
                    <el-image class=" lg:w-48 lg:h-48"
                        v-bind:src="item.url"
                        :zoom-rate="1.2"
                        :max-scale="1"
                        :min-scale="0.2"
                        :preview-src-list="[item.url]"
                        :initial-index="0"
                        fit="cover"
                    />
        </span>

    </div>
</template>

<script lang="ts" setup>
import {Head, Link, router} from '@inertiajs/vue3'
    import {func} from '/resources/js/func.js'
    import {ref} from "vue";
    import {UploadUserFile} from "element-plus";

const props = defineProps({
    review: Object,
    title: {
        type: String,
        default: 'Карточка отзывы',
    },
    gallery: Array,
});
function goEdit() {
    router.get(route('admin.service.review.edit', {review: props.review.id}));
}
function handleToggle(val) {
    router.post(route('admin.service.review.edit', {review: props.review.id}));
}
</script>

