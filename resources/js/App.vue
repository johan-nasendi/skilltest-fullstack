<template>
    <RouterView name="HeaderComponent"></RouterView>
    <RouterView name="SidebarComponent"></RouterView>
        <main class="container-fluid py-5">
            <notifications />
            <router-view @loggedIn="setUser"></router-view>
        </main>
    <RouterView name="FooterComponent"></RouterView>
    </template>

    <script>
        export default {
        data() {
            return {
                user: null,
                isLoggedIn: false
            }
            },
            mounted() {
            this.setUser()
            },
            methods: {
            setUser() {
                this.user = JSON.parse(localStorage.getItem('user'))
                this.isLoggedIn = localStorage.getItem('token') != null

                },

            }
        }
    </script>
