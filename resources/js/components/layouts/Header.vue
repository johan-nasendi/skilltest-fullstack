<template>
    <div class="navbar-custom" v-if="isLoggedIn">
        <div class="container-fluid">
                <ul class="list-unstyled topnav-menu float-right mb-0">
                    <li class="dropdown d-none d-lg-inline-block">
                        <a class="nav-link dropdown-toggle arrow-none waves-effect waves-light" data-toggle="fullscreen" href="#">
                            <!-- <i class="fe-maximize noti-icon"></i> -->
                            <vue-feather type="maximize-2" class="noti-icon" stroke-width="2" size="1.2rem"></vue-feather>
                        </a>
                     </li>
                         <li class="dropdown notification-list topbar-dropdown" v-for="role in user.roles" :key="role.id">

                             <a v-if="loginType = 'user'" class="nav-link dropdown-toggle nav-user mr-0 waves-effect waves-light" data-toggle="dropdown" role="button" aria-haspopup="false" aria-expanded="false">
                                 <img v-if="user.userimage" :src="'https://testskill-fullstack.herokuapp.com/photos/'+user.userimage" alt="user-image" class="rounded-circle">
                                 <img v-else src="/assets/images/users/user-5.jpg" alt="user-image" class="rounded-circle">
                                 <span class="pro-user-name ml-1">
                                         {{user.name}} <i class="mdi mdi-chevron-down"></i>
                                 </span>
                             </a>


                             <div class="dropdown-menu dropdown-menu-right profile-dropdown ">
                                 <!-- item-->
                                 <a class="dropdown-item notify-item">
                                     <router-link class="text-dark" :to="{name: 'profile'}">
                                     <!-- <i class="fe-user"></i> -->
                                     <vue-feather type="user" stroke-width="1" size="1.1rem"></vue-feather>
                                     <span>My Account</span>
                                     </router-link>
                                 </a>

                                 <a class="dropdown-item notify-item">
                                     <router-link class="text-dark" :to="{name: 'profilechangespassword'}">
                                     <!-- <i class="fe-user"></i> -->
                                     <vue-feather type="lock" stroke-width="1" size="1.1rem"></vue-feather>
                                     <span>Change Password</span>
                                     </router-link>
                                 </a>

                                 <div class="dropdown-divider"></div>
                                 <!-- item-->
                                 <a href="javascript:void()" class="dropdown-item notify-item" @click="logout">
                                     <!-- <i class="fe-log-out"></i> -->
                                     <vue-feather type="log-out" stroke-width="1" size="1.2rem"></vue-feather>
                                     <span>Logout</span>
                                 </a>

                             </div>
                         </li>
                </ul>


            <!-- LOGO -->
            <div class="logo-box">
                <a href="javascript:void(0);" class="logo logo-dark text-center">
                    <span class="logo-sm">
                        <img src="/assets/images/logo-sm.png" alt="" height="44">
                            <!-- <span class="logo-lg-text-light">UBold</span> -->
                    </span>
                    <span class="logo-lg">
                        <img src="/assets/images/logo-sm.png" alt="" height="33">
                            <!-- <span class="logo-lg-text-light">U</span> -->
                    </span>
                </a>

                <a href="javascript:void(0);" class="logo logo-light text-center">
                    <span class="logo-sm">
                        <img src="/assets/images/logo-sm-light.png" alt="" height="44">
                    </span>
                    <span class="logo-lg">
                        <img src="/assets/images/logo-sm-light.png" alt="" height="33">
                    </span>
                </a>
            </div>

            <ul class="list-unstyled topnav-menu topnav-menu-left m-0">
                <li>
                    <button class="button-menu-mobile waves-effect waves-light">
                            <i class="fe-menu"></i>
                        </button>
                </li>

                <li>
                    <!-- Mobile menu toggle (Horizontal Layout)-->
                    <a class="navbar-toggle nav-link" data-toggle="collapse" data-target="#topnav-menu-content">
                        <div class="lines">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </a>
                    <!-- End mobile menu toggle-->
                </li>
            </ul>

            <div class="clearfix"></div>
        </div>
    </div>
</template>

<script>
export default {
    name: "Header",
    props:['id'],
    data() {
    return {
        user: {},
        isLoggedIn: false,
        loginType: '',
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
        setUser() {
        this.user = JSON.parse(localStorage.getItem('user'))
        this.isLoggedIn = localStorage.getItem('token') != null

        if(this.isLoggedIn)
        {} else if(this.user = JSON.parse(localStorage.getItem('user'))) {
            axios.get(`https://testskill-fullstack.herokuapp.com/api/user`)
            .then(response => {
                    this.user = response.data
                    this.loginType = response.data.roles[0].name
            })
            .catch(error => {
                console.error(error);
            })
        } else {
            return false;
        }

        },
        logout() {
        localStorage.removeItem('token')
        localStorage.removeItem('user')
        this.setUser()
        this.$router.push('/')
        this.$notify({
            type: "success",
            title: "Log Out",
            text: "Log Out Successfull",
        });
        }
    }
}
</script>
