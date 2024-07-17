<template>
    <Head title="Login" />
    <div class="flex items-center justify-center p-6 min-h-screen bg-indigo-800">
        <div class="w-full max-w-md">
            <div class="block mx-auto w-full max-w-xs fill-white flex text-gray-50" >
                <logo height="100" />
                <span class="text-4xl my-auto font-semibold pt-3">SeDeSys</span>
            </div>


            <form class="mt-8 bg-white rounded-lg shadow-xl overflow-hidden" @submit.prevent="login">
                <div class="px-10 py-12">
                    <h1 class="text-center text-3xl font-bold">Welcome Back!</h1>
                    <div class="mt-6 mx-auto w-24 border-b-2" />

                    <el-input v-model="form.login" :error="form.errors.login" class="mt-10" label="Login" type="text" autofocus autocapitalize="off" />
                    <el-input v-model="form.password" :error="form.errors.password" class="mt-6" label="Password" type="password" />
                    <label class="flex items-center mt-6 select-none" for="remember">
                        <input id="remember" v-model="form.remember" class="mr-1" type="checkbox" />
                        <span class="text-sm">Запомнить меня</span>
                    </label>
                </div>
                <div class="flex px-10 py-4 bg-gray-100 border-t border-gray-100">
                    <el-button :loading="form.processing" class="ml-auto" type="primary" @click="login">Login</el-button>
                </div>
            </form>
        </div>
    </div>
</template>

<script>
import { Head } from '@inertiajs/vue3'
import Logo from '@/Components/Logo.vue'

export default {
    components: {
        Head,
        Logo,
    },
    data() {
        return {
            form: this.$inertia.form({
                login: '',
                password: '',
                remember: false,
            }),
        }
    },
    methods: {
        login() {
            this.form.post('/admin/login')
        },
    },
}
</script>

<style scoped>

</style>
