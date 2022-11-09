<template>
    <div class="content-page mt-1" v-if="isLoggedIn">
       <div class="content" v-if="loginType = 'user'">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-12">
                        <div class="page-title-box">
                            <div class="page-title-right">
                                <ol class="breadcrumb m-0">
                                    <li class="breadcrumb-item"><a><router-link class="text-dark" :to="{name: 'user'}">Dashboard</router-link> </a></li>
                                    <li class="breadcrumb-item"><a href="javascript: void(0);"><router-link class="text-dark" :to="{name: 'profile'}">My Account</router-link></a></li>
                                    <li class="breadcrumb-item active"><a href="#"></a> Change Password </li>
                                </ol>
                            </div>
                            <h2 class="page-title"><i class="mdi mdi-lock"></i></h2>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-8 offset-2">
                        <div class="card-box bg-dark bg-pattern">
                                <div class="row">
                                    <div class="col-md-6 text-left">
                                    </div> <!-- end col -->
                                    <div class="col-md-6 text-right">
                                        <h5 class="header-title text-white">
                                            <router-link class="text-danger" :to="{name: 'profile'}">
                                                <i class="mdi mdi-close-circle-outline mdi-18px mr-1"></i>
                                            </router-link>
                                        </h5>
                                    </div> <!-- end col -->
                                </div> <!-- end row -->

                            <div v-if="errors" class="alert bg-danger text-white dark-dismissible fade show" role="alert">
                                <strong > {{errors}} </strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <div v-if="serverErros" class="alert bg-danger text-white alert-dismissible fade show" role="alert">
                                <strong >
                                     {{serverErros}}
                                </strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                            <form @submit.prevent="handleChangePassword">
                                 <div class="row">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-white">Old Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <input v-if="showPasswordOld" type="text"  class="form-control bg-dark text-white"
                                                        placeholder="Enter your password"  v-model="changePassd.current_passsowrd" />
                                                        <input v-else type="password"  class="form-control bg-dark text-white"
                                                        required autocomplete="on" autofocus placeholder="Enter your password" v-model="changePassd.current_passsowrd">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text bg-dark" @click="toggleShowOld">
                                                                <span class="fas text-white" :class="{ 'fa-eye-slash': showPasswordOld, 'fa-eye': !showPasswordOld }"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <small class="text-white">If you forget your old password, please contact the admin </small>
                                                </div>
                                             </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-white">New  Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <input v-if="showPasswordNew" type="text"  class="form-control bg-dark text-white"
                                                        placeholder="Enter new password"  v-model="changePassd.password" />
                                                        <input v-else type="password"  class="form-control bg-dark text-white"
                                                        required autocomplete="on" autofocus placeholder="Enter new password" v-model="changePassd.password">
                                                            <div class="input-group-append">
                                                                <div class="input-group-text bg-dark" @click="toggleShowNew">
                                                                    <span class="fas text-white" :class="{ 'fa-eye-slash': showPasswordNew, 'fa-eye': !showPasswordNew }"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                 </div>
                                            </div>
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label class="text-white">Confirm New  Password</label>
                                                    <div class="input-group input-group-merge">
                                                        <input v-if="showPasswordConf" type="text"  class="form-control bg-dark text-white"
                                                        placeholder="Enter new password"  v-model="changePassd.password_confirmation" />
                                                        <input v-else type="password"  class="form-control bg-dark text-white"
                                                        required autocomplete="on" autofocus placeholder="Enter new password" v-model="changePassd.password_confirmation">
                                                        <div class="input-group-append">
                                                                <div class="input-group-text bg-dark" @click="toggleShowConf">
                                                                    <span class="fas text-white" :class="{ 'fa-eye-slash': showPasswordConf, 'fa-eye': !showPasswordConf }"></span>
                                                                </div>
                                                            </div>
                                                        </div>
                                                 </div>
                                            </div>
                                        </div>
                                </div> <!-- end row -->
                                <div class="form-group mb-0 text-center">
                                    <button class="btn btn-outline-success btn-block" type="submit">
                                        <i class="mdi mdi-content-save"></i> Reset
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
       </div>
    </div>
</template>

<script>
export default {
    name:"ChangePassdAccount",
    props:['id'],
        data() {
             return {
                loginType: '',
                isLoggedIn: false,
                errors: null,
                showPasswordOld: false,
                showPasswordNew: false,
                showPasswordConf: false,
                hidePassword: null,
                serverErros: '',
                changePassd:{
                    password: '',
                    current_passsowrd: '',
                    password_confirmation: ''
                }
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
        computed: {
            buttonLabelFirst() {
            return (this.showPasswordOld) ? "Hide" : "Show";
            },
            buttonLabelSecond() {
            return (this.showPasswordNew) ? "Hide" : "Show";
            },
            buttonLabelthird() {
            return (this.showPasswordConf) ? "Hide" : "Show";
            },
        },
        methods: {
            handleChangePassword() {
              axios.post('https://testskill-fullstack.herokuapp.com/api/profile/change-password',this.changePassd)
              .then((response) => {
                if(response.data.status) {
                    this.$notify({
                            type: "success",
                            title: "Success",
                            text: response.data.message,
                    });
                    this.$router.push({
                         name: 'profile',
                     })
                }
              }).catch((e) => {
                if(e.response.status === 500){
                    this.serverErros = e.response.message + ' Opsss... Internal Server Error,Try once Again!'
                }
                this.errors  = e.response.data.message
              })
            },
           async setUser() {
                this.user = JSON.parse(localStorage.getItem('user'))
                this.isLoggedIn = localStorage.getItem('token') != null

                if(this.isLoggedIn === false ){
                    this.$notify({
                        type: "error",
                        title: "Authorization",
                        text: "Please Log In!",
                    });
                    this.$router.push('/')
                }
            },

            toggleShowOld() {
                this.showPasswordOld = !this.showPasswordOld;
            },
            toggleShowNew() {
                this.showPasswordNew = !this.showPasswordNew;
            },
            toggleShowConf() {
                this.showPasswordConf = !this.showPasswordConf;
            },
    },
}
</script>
