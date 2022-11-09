<template>
    <div class="account-pages mt-3 mb-5">
            <div class="container">
                <div class="row justify-content-center">
                    <div class="col-md-8 col-lg-6 col-xl-5">
                        <div class="card bg-pattern bg-dark">
                            <div class="card-body p-4">
                                <div class="text-center w-75 m-auto">
                                    <div class="auth-logo">
                                        <a class="logo logo-dark text-center">
                                            <span class="logo-lg">
                                               <img src="/assets/images/logo-sm.png" alt="logo" height="44">
                                            </span>
                                        </a>
                                        <a  class="logo logo-light text-center">
                                            <span class="logo-lg">
                                                <img src="/assets/images/logo-sm-light.png" alt="logo" height="44">
                                            </span>
                                        </a>
                                    </div>
                                </div>

                                <p class="text-success mb-4 mt-3" v-if="showLoading">
                                   Loading....
                                 </p>

                                <div v-if="message" class="alert bg-success text-dark alert-dismissible fade show" role="alert">
                                    <strong >
                                        <i class="mdi mdi-information-outline mdi-18px mr-1"></i> {{message}}
                                    </strong>
                                    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>

                                <div v-if="error" class="alert bg-danger text-white dark-dismissible fade show" role="alert">
                                    <strong >
                                        <i class="mdi mdi-information-outline mdi-18px mr-1"></i>{{error}}
                                    </strong>
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


                                <form @submit.prevent="resetPaswordForm">
                                    <div class="form-group mb-3 mt-2">
                                        <label>Email address</label>
                                        <input id="email" type="email" class="form-control bg-dark text-white"
                                        placeholder="Enter your email"  v-model="resetpassword.email" name="email" required autocomplete="on" autofocus >
                                    </div>
                                    <div class="form-group mb-3 mt-2">
                                        <label>New Password</label>
                                        <input id="email" type="email" class="form-control bg-dark text-white"
                                        placeholder="Enter new password"  v-model="resetpassword.password" name="password" required autocomplete="on" autofocus >
                                    </div>
                                    <div class="form-group mb-3 mt-2">
                                        <label>Confirm Password</label>
                                        <input id="email" type="email" class="form-control bg-dark text-white"
                                        placeholder="Enter confirm new password"  v-model="resetpassword.password_confirmation"  required autocomplete="on" autofocus >
                                    </div>

                                    <div class="form-group mb-0 text-center">
                                        <button class="btn btn-outline-success btn-block" type="submit" @click="showLoading = true">
                                            Reset
                                        </button>
                                    </div>
                                </form>

                                <div class="row mt-3">
                                <div class="col-12 text-left">
                                    <p class="text-dark-50">No password reset
                                        <b><router-link class="text-white" :to="{name: 'login'}"> Sign In</router-link></b>
                                    </p>
                                </div>
                                <!-- end col -->
                            </div>
                            <!-- end row -->


                            </div>
                        </div>
                    </div>
                </div>
            </div>
    </div>
</template>

<script>
export default {
    name:"ForgotPassword",
    data() {
      return {
        showLoading: false,
        resetpassword : {
           email: '',
           password: '',
           password_confirmation: '',
        },
        error: '',
        message: '',
        serverErros: '',
      }
    },
    created() {
      if (this.$route.params.message !== undefined) {
        this.message = this.$route.params.message
      }
    },
    methods: {
        resetPaswordForm() {
            axios.post('https://testskill-fullstack.herokuapp.com/api/login',
            this.resetpassword)
            .then(response => {
                if(response.data.status){
                    this.$notify({
                        type: "success",
                        title: "Success",
                        text: response.data.message,
                    });
                        this.$router.push({
                        name: 'login',
                    })
                }
            })
            .catch(e => {
                 if(e.response.status === 500){
                 this.serverErros = e.response.message + ' Opsss... API Error,Try once Again!'
              }
              this.serverErros  = e.response.data.message
            });

        }

    }
}
</script>
