<template>
    <Head><title>{{ $props.title }}</title></Head>
    <h1 class="font-medium text-xl">  {{ employee.fullname.surname + ' ' + employee.fullname.firstname + ' ' + employee.fullname.secondname }}  </h1>
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
                <div class="grid lg:grid-cols-3 grid-cols-1 divide-x">
                    <div class="p-2">
                        <div class="flex flex-1 px-5 items-center justify-center lg:justify-start">
                            <div class="w-20 h-20 sm:w-24 sm:h-24 flex-none lg:w-32 lg:h-32 image-fit relative">
                                <el-image
                                    style="width: 100px; height: 100px"
                                    :src="$props.photo"
                                    :zoom-rate="1.2"
                                    :max-scale="7"
                                    :min-scale="0.2"
                                    :preview-src-list="[$props.photo]"
                                    :initial-index="0"
                                    fit="cover"
                                />
                            </div>
                            <div class="ml-5">
                                <div class="w-24 sm:w-40 truncate sm:whitespace-normal font-medium text-lg">
                                    {{ employee.fullname.surname + ' ' + employee.fullname.firstname + ' ' + employee.fullname.secondname }}
                                </div>
                                <div class="text-slate-500">{{ '' }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="p-2">
                        <el-descriptions :column="1" border title="Персональные данные">
                            <el-descriptions-item>
                                <template #label>
                                    <div class="items-center flex">
                                        <el-icon><iphone  /></el-icon>&nbsp;Телефон
                                    </div>
                                </template>
                                {{ employee.phone }}
                            </el-descriptions-item>
                            <el-descriptions-item>
                                <template #label>
                                    <div class="items-center flex">
                                        <el-icon><Promotion /></el-icon>&nbsp;Телеграм ID
                                    </div>
                                </template>
                                {{ employee.telegram_user_id }}
                            </el-descriptions-item>
                            <el-descriptions-item>
                                <template #label>
                                    <div class="items-center flex">
                                        <el-icon><Location /></el-icon>&nbsp;Адрес
                                    </div>
                                </template>
                                {{ employee.address.address }}
                            </el-descriptions-item>
                            <el-descriptions-item>
                                <template #label>
                                    <div class="items-center flex">
                                        <el-icon><Calendar /></el-icon>&nbsp;Стаж с
                                    </div>
                                </template>
                                {{ employee.experience_year }} г
                            </el-descriptions-item>
                        </el-descriptions>
                    </div>
                    <div class="p-2">
                        <h2 class="font-medium">Специализация</h2>

                        <div v-for="specialization in specializations" class="flex mt-1">
                            <el-image :src="specialization.icon" class="w-8 h-8"/>
                            <span class="ml-2 my-auto">{{ specialization.name }}</span>
                        </div>

                    </div>
                </div>
            </el-tab-pane>
            <!-- Панель Услуги -->
            <el-tab-pane>
                <template #label>
                    <span class="custom-tabs-label">
                        <el-icon><SuitcaseLine /></el-icon>
                        <span> Услуги</span>
                    </span>
                </template>
                <div class="mb-5">
                    <el-table
                    :data="services"
                    style="width: 100%; cursor: pointer;"
                    @row-click="routeClick"
                >
                    <!-- Повторить поля -->
                    <el-table-column sortable prop="name" label="Услуга" width="250" show-overflow-tooltip/>
                    <el-table-column sortable prop="classification" label="Классификация"  width="250"/>
                    <el-table-column prop="price" label="Базовая стоимость" width="100" />
                        <el-table-column prop="extra_cost" label="Доп. наценка" width="100" >
                            <template #default="scope">
                                {{ func.price(scope.row.extra_cost) }}
                            </template>
                        </el-table-column>
                    <el-table-column label="Расх.материалы (₽)" width="160" />
                    <el-table-column label="Действия" align="right">
                        <template #default="scope">
                            <el-button
                                size="small"
                                type="danger"
                                @click.stop="detachService(scope.row)"
                            >
                                Detach
                            </el-button>
                        </template>
                    </el-table-column>
                </el-table>
                </div>
                <el-button type="success" plain @click="dialogService = true">
                    <el-icon><SuitcaseLine /></el-icon>&nbsp;Добавить Услугу
                </el-button>
                <!--Dialog-->
                <el-dialog v-model="dialogService" width="400" class="p-4" center>
                    <el-form :model="formService" class="mt-3">
                        <el-form-item label="Персонал">
                            <el-select v-model="formService.service_id">
                                <el-option v-for="item in out_services" :value="item.id" :key="item.id"
                                           :label="item.name"/>
                            </el-select>
                        </el-form-item>
                        <el-form-item label="Дополнительная наценка" class="mb-3">
                            <el-input v-model="formService.extra_cost" @input="handleExtraCost" placeholder=""
                                      class="mb-3">
                                <template #append>₽</template>
                            </el-input>
                        </el-form-item>
                        <el-button type="info" plain @click="dialogService = false">
                            Отмена
                        </el-button>
                        <el-button type="primary" @click="attachService">Сохранить</el-button>
                        <span v-if="dialogSave" class="text-lime-500 text-sm ml-3">Сохранено</span>
                    </el-form>
                </el-dialog>
            </el-tab-pane>
            <!-- Панель Примеры -->
            <el-tab-pane>
                <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><Help/></el-icon>
                      <span> Примеры работы</span>
                    </span>
                </template>
                <div class="mb-5">
                    <el-table :data="examples"
                              style="width: 100%; cursor: pointer;"
                              @row-click="routeClick"
                    >
                        <el-table-column label="Дата" prop="date"  width="120" />
                        <el-table-column label="Заголовок" prop="title" width="250"/>

                        <el-table-column label="Исполнители" width="250">
                            <template #default="scope">
                                <el-tag class="mr-1" v-for="item in scope.row.employees">
                                    {{ func.fullName(item.fullname) }}
                                </el-tag>
                            </template>
                        </el-table-column>

                        <el-table-column label="Стоимость" prop="cost"  width="120" />
                        <el-table-column label="Изображения" prop="gallery_count"  width="120" />
                        <el-table-column label="Описание" prop="description" show-overflow-tooltip/>
                        <el-table-column label="Действия" width="250">
                            <template #default="scope">
                                <el-button v-if="scope.row.active"
                                           size="small"
                                           type="warning"
                                           @click.stop="handleToggleRow(scope.$index, scope.row)">
                                    Hide
                                </el-button>
                                <el-button v-if="!scope.row.active"
                                           size="small"
                                           type="success"
                                           @click.stop="handleToggleRow(scope.$index, scope.row)">
                                    Show
                                </el-button>
                                <el-button
                                    size="small"
                                    @click.stop="handleEditRow(scope.$index, scope.row)">
                                    Edit
                                </el-button>
                            </template>
                        </el-table-column>

                    </el-table>
                </div>
                <el-button @click="newExample">Новый пример</el-button>
            </el-tab-pane>
            <!-- Панель Отзывы -->
            <el-tab-pane>
                <template #label>
                    <span class="custom-tabs-label">
                      <el-icon><ChatLineSquare/></el-icon>
                      <span> Отзывы</span>
                    </span>
                </template>
                Список + рейтинг + пагинация с подгрузгой
            </el-tab-pane>
        </el-tabs>


    </div>
    <div class="mt-3 p-3 bg-white rounded-lg">
        <el-button type="primary" @click="goEdit">Редактировать</el-button>
        <el-button v-if="!employee.active" type="success" @click="handleToggle">Разблокировать
        </el-button>
        <el-button v-if="employee.active" type="warning" @click="handleToggle">Заблокировать
        </el-button>
    </div>

    <div class="mt-5 p-3 bg-white rounded-lg ">
        Dashboard Персонала - графики, клиенты, записи и т.п.
    </div>
</template>

<script lang="ts" setup>
import {reactive, ref} from "vue";
import {router} from "@inertiajs/vue3";
import {func} from '@/func.js'

const dialogService = ref(false)
const dialogSave = ref(false)

const props = defineProps({
    employee: Object,
    edit: String,
    photo: {
        type: String,
        default: null,
    },
    title: {
        type: String,
        default: 'Карточка Персонала',
    },
    attach: String,
    detach: String,
    new_example: String,
    specializations:  Object,
    services: Array,
    examples: Array,
    out_services: Array,
    toggle: String,

});

const formService = reactive({
    service_id: null,
    extra_cost: null
});

function handleToggle() {
    router.post(props.toggle);
}
function newExample() {
    router.get(props.new_example);
}
function handleExtraCost(val) {
    formService.extra_cost = func.MaskInteger(val);
}
function attachService() {
    if (formService.service_id === null) return;
    router.post(props.attach, formService);
    dialogService.value = false;
}

function detachService(row) {
    router.post(props.detach, {
        service_id: row.id
    });
}

</script>

<script lang="ts">
    import { Head, Link, router } from '@inertiajs/vue3'
    import Layout from '@/Components/Layout.vue'

    export default {
        components: {
            Head,
        },
        layout: Layout,
        methods: {
            goEdit() {
                router.get(this.$props.edit);
            },
            routeClick(row) {
                router.get(row.url)
            },
        },
    }

</script>

<style scoped>

</style>
