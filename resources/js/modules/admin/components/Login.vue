<template>
    <div>
        <h1>Логин</h1>
        <login-form
            :errors="authErrors"
            :loading="loading"
            @submit="onSubmit"
        />
    </div>
</template>

<script>
import LoginForm from './LoginForm.vue'

//import {SET_AUTH} from "../store/types.js";
export default {
    name: 'Login',
    components: {LoginForm},
    data() {
        return {
            error: null,
            loading: false,
            authErrors: {}
        }
    },
    methods: {
        onSubmit(loginData) {
            this.loading = true

            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('api/admin/login', {
                    login: loginData.login,
                    password: loginData.password
                })
                    .then(response => {
                        console.log(response.data)
                        if (response.data.success) {
                            console.log('*');
                            console.log(this.$router);
                            this.$store.commit('admin/SET_AUTH', true);

                            this.$router.go('/admin')
                        } else {
                            this.error = response.data.message
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        },
        beforeRouteEnter(to, from, next) {
            if (window.Laravel.isLoggedin) {
                return next('dashboard');
            }
            next();
        }
    }
}
</script>

<style scoped lang="scss">

</style>
