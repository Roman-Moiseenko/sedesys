<template>
    <div class="container">
        <div class="text-center" style="margin: 20px 0px 20px 0px;">
            <a href="https://shouts.dev/" target="_blank"><img src="https://i.imgur.com/Nt3kJXa.png"></a><br>
            <span class="text-secondary">Laravel SPA with Vue 3, Auth (Sanctum), CURD Example</span>
        </div>

        <nav class="navbar navbar-expand-lg navbar-light bg-light">
            <div class="collapse navbar-collapse">
                <!-- for logged-in user-->
                <div class="navbar-nav" v-if="$store.getters.isAuth">
                    <home />
                </div>
                <!-- for non-logged user-->
                <div class="navbar-nav" v-else>
                    <login />

                </div>
            </div>
        </nav>
        <br/>
        <router-view/>
    </div>
</template>
<script>

import Login from '../modules/admin/components/Login.vue'
import Home from "./components/Home.vue";


export default {
    name: 'app',
    methods: {
        logout(e) {
            console.log('ss')
            e.preventDefault()
            this.$axios.get('/sanctum/csrf-cookie').then(response => {
                this.$axios.post('/api/admin/logout')
                    .then(response => {
                        if (response.data.success) {
                            window.location.href = "/"
                        } else {
                            console.log(response)
                        }
                    })
                    .catch(function (error) {
                        console.error(error);
                    });
            })
        }
    },

    components: {
        Home,
        Login
    }
};
</script>
<style scoped>
/* Add scoped styles */
#app {
    padding: 20px;
}
</style>
