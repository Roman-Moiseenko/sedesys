<template>
    <el-menu :default-active="getUrl($page.url)" class=""
             active-text-color="rgb(253 186 116)" text-color="rgb(244 244 245)"
             background-color="rgb(82 82 91)">
        <template v-for="(item, index)  in $page.props.menus">
            <template v-if="item.submenu">
                <el-sub-menu :index="index">
                    <template #title>
                        <el-icon>
                            <component :is="item.icon"></component>
                        </el-icon>
                        <span>{{ item.title }}</span>
                    </template>
                    <template v-for="subitem in item.submenu">
                        <el-menu-item :index="subitem.route">
                            <Link :href="subitem.route" class="flex items-center">
                            <el-icon>
                                <component :is="subitem.icon"></component>
                            </el-icon>
                            <span>{{ subitem.title }}</span>
                            </Link>
                        </el-menu-item>
                    </template>
                </el-sub-menu>
            </template >
            <template v-else >
                    <el-menu-item :index="item.route">
                        <Link :href="item.route" class="flex items-center">
                        <el-icon>
                            <component :is="item.icon"></component>
                        </el-icon>
                        <span>{{ item.title }}</span>
                        </Link>
                    </el-menu-item>
            </template>
        </template>
    </el-menu>

</template>

<script>
import { Link } from '@inertiajs/vue3'


export default {
    components: {
        Link,
    },
    props: {
        menus: Object,
    },

    methods: {
        getUrl(url) {
            let tt = url.match(/^(.+?)\/[0-9]/,'gm');
            if (tt === null) return url;
            return tt[1];
        },
    },
}
</script>
