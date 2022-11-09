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
            async setUser() {
                this.user = JSON.parse(localStorage.getItem('user'))
                this.isLoggedIn = localStorage.getItem('token') != null

                await axios.get('https://testskill-fullstack.herokuapp.com/api/user')
                    .then(response => {
                            this.user = response.data
                            this.loginType = response.data.roles[0].name
                    })
                    .catch(error => {
                        if(error.response.status === 401 || error.response.status === 419)
                        {
                            localStorage.clear();
                            this.$notify({
                                type: "error",
                                title: "Authorization Token is Expired",
                                text: error.response,
                            });
                            this.$router.push('/')
                        }
                        console.log(error);
                    })

                },

            }
        }
    </script>
