<template>
    <el-menu default-active="1" class=""
             active-text-color="#ffd04b" text-color="#fff"
             background-color="#545c64" @open="handleOpen" @close="handleClose">
        <template v-for="(item, index)  in $page.props.menus">
            <template v-if="item.submenu">
                <el-sub-menu :index="index">
                    <template #title>
                        <icon :name="item.icon" class="mr-2 w-4 h-4" />
                        <span>{{ item.title }}</span>
                    </template>
                    <template v-for="(subitem, subindex) in item.submenu">
                        <el-menu-item :index="subindex">
                            <Link :href="subitem.route" class="flex items-center">
                            <icon :name="subitem.icon" class="mr-2 w-4 h-4" />
                            <span>{{ subitem.title }}</span>
                            </Link>
                        </el-menu-item>
                    </template>
                </el-sub-menu>
            </template >
            <template v-else >
                    <el-menu-item :index="index">
                        <Link :href="item.route" class="flex items-center">
                        <icon :name="item.icon" class="mr-2 w-4 h-4" />
                        <span>{{ item.title }}</span>
                        </Link>
                    </el-menu-item>
            </template>
        </template>
    </el-menu>
</template>

<script>
import { Link } from '@inertiajs/vue3'
import Icon from '@/Components/Icon.vue'

export default {
    components: {
        Icon,
        Link,
    },
    props: {
        menus: Object,
    },
    methods: {
        isUrl(...urls) {
            let currentUrl = this.$page.url.substr(1)
            if (urls[0] === '') {
                return currentUrl === ''
            }
            return urls.filter((url) => currentUrl.startsWith(url)).length
        },
        handleOpen(key, keyPath) {
            console.log(key, keyPath);

            console.log(this.$page.props.menus);
        },
        handleClose(key, keyPath) {
            console.log(key, keyPath)
        }
    },
}
</script>
