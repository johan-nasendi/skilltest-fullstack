<template>
    <div class="account-pages mt-1 mb-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-8 col-lg-8 col-xl-8">
                <div class="card bg-pattern bg-dark">

                    <div class="card-body mt-2">
                        <div class="text-center w-55 m-auto">
                            <div class="auth-logo">
                                <a class="logo logo-dark text-center">
                                    <span class="logo-lg">
                                        <img src="/assets/images/logo-sm.png" alt="logo" height="44">
                                    </span>
                                </a>
                                <a class="logo logo-light text-center">
                                    <span class="logo-lg">
                                        <img src="/assets/images/logo-sm-light.png" alt="logo" height="44">
                                    </span>
                                </a>
                            </div>
                            <br>
                            <div v-if="notifmsg" class="alert bg-danger text-white alert-dismissible fade show" role="alert">
                                <strong >
                                    <i class="mdi mdi-information-outline mdi-18px mr-1"></i> Errors....
                                </strong>
                                <div v-for="(v, k) in notifmsg" :key="k">
                                      <ul v-for="error in v" :key="error" class="text-sm">
                                        <li>{{ error }}</li>
                                      </ul>
                                </div>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>
                            <div v-if="serverErros" class="alert bg-danger text-white alert-dismissible fade show" role="alert">
                                <strong >
                                    <i class="mdi mdi-information-outline mdi-18px mr-1"></i>{{serverErros}}
                                </strong>
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                            </div>

                        </div>
                        <form @submit.prevent="submitFormRegister">

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-white">Full Name</label>
                                        <input  type="text" v-model="user.name" class="form-control bg-dark text-white" name="name"
                                        placeholder="Enter your name" required autocomplete="on">

                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-white">Email address</label>
                                        <input type="email" v-model="user.email" class="form-control bg-dark text-white" name="email"
                                        placeholder="Enter your email" required autocomplete="on">
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-white">Password</label>
                                        <div class="input-group input-group-merge">
                                            <input v-if="showPassword" type="text"  class="form-control bg-dark text-white"
                                            placeholder="Enter your password"  v-model="user.password" />
                                            <input v-else type="password" class="form-control bg-dark text-white"
                                            required autocomplete="on" autofocus placeholder="Enter your password" v-model="user.password">
                                            <div class="input-group-append">
                                                <div class="input-group-text bg-dark" @click="toggleShow">
                                                    <span class="fas text-white" :class="{ 'fa-eye-slash': showPassword, 'fa-eye': !showPassword }"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="text-white">Confirm Password</label>
                                        <div class="input-group input-group-merge">
                                            <input v-if="showPasswordConf" type="text"  class="form-control bg-dark text-white"
                                            placeholder="Confirm Password"  v-model="user.password_confirmation" />
                                            <input v-else type="password" class="form-control bg-dark text-white"
                                            required autocomplete="on" autofocus placeholder="Confirm Password" v-model="user.password_confirmation">
                                            <div class="input-group-append">
                                                <div class="input-group-text bg-dark" @click="toggleShowConf">
                                                    <span class="fas text-white" :class="{ 'fa-eye-slash': showPasswordConf, 'fa-eye': !showPasswordConf }"></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>


                            <div class="form-group mb-0 text-center">
                                <button class="btn btn-outline-success btn-block" type="submit"> Sign Up </button>
                            </div>

                             <div class="row mt-3">
                                <div class="col-12 text-center">
                                    <p class="text-dark-50">Already have account?
                                        <b><router-link class="text-white" :to="{name: 'login'}"> Sign In</router-link></b>
                                    </p>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->

                        </form>
                    </div>
                    <!-- end card-body -->
                </div>
                <!-- end card -->

            </div>
            <!-- end col -->
        </div>
        <!-- end row -->
    </div>
    <!-- end container -->
</div>
<!-- end page -->
</template>

<script>
 export default{
    name:"Register",
    data() {
        return {
             notifmsg: null,
             showPassword: false,
             showPasswordConf: false,
             hidePassword: null,
             serverErros: '',
            user: {
                name: '',
                email: '',
                password: '',
                password_confirmation: '',
            },
          }
        },
        computed: {
            buttonLabelFirst() {
            return (this.showPassword) ? "Hide" : "Show";
            },
            buttonLabelFirst() {
            return (this.showPasswordConf) ? "Hide" : "Show";
            },
        },
        methods: {
        submitFormRegister() {
            axios.post('https://testskill-fullstack.herokuapp.com/api/register',
            { useCredentails: true },
            this.user)
            .then(response => {
                if(response.data.status){
                    this.$router.push({
                    name: 'login',
                    params: {
                        message: response.data.message
                    }
                    })
                }
            })
            .catch(e => {
                 this.serverErros  = e.response.data.message
                 if(error.response.status === 500){
                 this.serverErros = error.response.status + ' Opsss... Internal Server Error,Try once Again!'
              }
            });
        },
        toggleShow() {
            this.showPassword = !this.showPassword;
        },
        toggleShowConf() {
            this.showPasswordConf = !this.showPasswordConf;
        },
        }
    }
</script>
