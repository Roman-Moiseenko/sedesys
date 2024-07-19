<template>
    <div>
        <div id="dropdown" />
        <div class="md:flex md:flex-col">
            <div class="md:flex md:flex-col md:h-screen">
                <div class="md:flex md:shrink-0">
                    <!-- Logo -->
                    <div class="flex items-center justify-between px-6 py-4 bg-zinc-900 md:shrink-0 md:justify-center md:w-56">
                        <Link class="mt-1 flex" href="/admin">
                            <logo class="fill-white" width="28" height="28" />
                            <span class="text-white text-lg ml-3 font-medium">SEDESYS</span>
                        </Link>

                        <dropdown class="md:hidden" placement="bottom-end">
                            <template #default>
                                <svg class="w-6 h-6 fill-white" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20"><path d="M0 3h20v2H0V3zm0 6h20v2H0V9zm0 6h20v2H0v-2z" /></svg>
                            </template>
                            <template #dropdown>
                                <div class="mt-2 px-8 py-4 bg-indigo-800 rounded shadow-lg">
                                    <main-menu />
                                </div>
                            </template>
                        </dropdown>
                    </div>
                    <!-- BreadCrumbs -->
                    <div class="bg-zinc-900 text-white md:text-md flex items-center justify-between p-4 w-full text-sm border-b md:px-12 md:py-0">
                        <div class="mr-4 mt-1">
                            <bread-crumbs />
                        </div>
                        <dropdown class="mt-1" placement="bottom-end">
                            <template #default>
                                <div class="group flex items-center cursor-pointer select-none">
                                    <div class="mr-1 text-gray-50 group-hover:text-white focus:text-indigo-600 whitespace-nowrap">
                                        <span>{{ auth.user.first_name }}</span>
                                        <span class="hidden md:inline">&nbsp;{{ auth.user.last_name }}</span>
                                    </div>
                                    <icon class="w-5 h-5 fill-gray-50 group-hover:fill-white focus:fill-indigo-600" name="cheveron-down" />
                                </div>
                            </template>
                            <template #dropdown>
                                <div class="mt-2 py-2 text-sm bg-white rounded shadow-xl">
                                    <Link class="block px-6 py-2 hover:text-white hover:bg-indigo-500" :href="`/admin/staff/${auth.user.id}/edit`">My Profile</Link>
                                    <Link class="block px-6 py-2 hover:text-white hover:bg-indigo-500" href="/users">Manage Users</Link>
                                    <Link class="block px-6 py-2 w-full text-left hover:text-white hover:bg-indigo-500" href="/logout" method="delete" as="button">Logout</Link>
                                </div>
                            </template>
                        </dropdown>
                    </div>
                </div>
                <div class="md:flex md:grow md:overflow-hidden">
                    <main-menu class="hidden shrink-0 pt-3 w-56  overflow-y-auto md:block" />
                    <div class="px-4 py-8 md:flex-1 md:p-10 md:overflow-y-auto bg-zinc-100" scroll-region>
                        <flash-messages />
                        <slot />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import { Link } from '@inertiajs/vue3'

import Icon from '@/Components/Icon.vue'
import Logo from '@/Components/Logo.vue'
import Dropdown from '@/Components/Dropdown.vue'
import MainMenu from '@/Components/MainMenu.vue'
import FlashMessages from '@/Components/FlashMessages.vue'
import BreadCrumbs from "@/Components/BreadCrumbs.vue";


export default {
    components: {
        BreadCrumbs,
        Dropdown,
        FlashMessages,
        Icon,
        Link,
        Logo,
        MainMenu,
    },
    props: {
        auth: Object,
        breadcrumbs: Object,
    },
}
</script>

<style scoped>

</style>
