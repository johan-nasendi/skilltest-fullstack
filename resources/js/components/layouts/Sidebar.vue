<template>
    <div class="left-side-menu" v-if="isLoggedIn">
            <div class="h-100" data-simplebar>
                <div id="sidebar-menu">

                    <ul id="side-menu" v-if="loginType = 'user'">
                        <li class="menu-title mt-2" v-for="role in user.roles" :key="role.id">{{ role.display_name }}</li>
                            <li>
                                <a data-toggle="collapse">
                                    <vue-feather type="airplay" stroke-width="2" size="1.2rem"></vue-feather>
                                    <span> <router-link class="text-dark" :to="{name: 'user'}">Dashboards</router-link> </span>
                                </a>
                            </li>
                            <li>
                                <a>

                                    <vue-feather type="list" stroke-width="2" size="1.2rem"></vue-feather>
                                    <span><router-link class="text-dark" :to="{name: 'todolist'}">Todo List</router-link></span>
                                </a>
                            </li>
                    </ul>

                </div>
                <div class="clearfix"></div>
            </div>
            <!-- Sidebar -left -->

    </div>
</template>
<script>
export default {
    name: "Sidebar",
    data() {
    return {
        user:null,
        loginType: '',
        isLoggedIn: false,
    }
    },
    created() {
        if (this.$route.params.message !== undefined) {
            this.message = this.$route.params.message
        }
    },
    mounted() {
        this.setUser()
    },
    methods: {
        async setUser() {
        this.user = JSON.parse(localStorage.getItem('user'))
        this.isLoggedIn = localStorage.getItem('token') != null

        await axios.get(`https://testskill-fullstack.herokuapp.com/api/user`)
            .then(response => {
                    this.user = response.data
                    this.loginType = response.data.roles[0].name
            })
            .catch(error => {
                if(error.response.status === 401 || error.response.status === 419)
                {
                    localStorage.clear();
                    this.$router.push('/')
                }
                console.log(error);
            })
        },
    },

}
</script>

